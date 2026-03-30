<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\TranslationKey;
use App\Models\TranslationValue;
use App\Services\TranslationSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranslationController extends Controller
{
    public function index($lang, Request $r)
    {
        $language = Language::where('code', $lang)->firstOrFail();
        // Render the page (table body will be filled by DataTables via AJAX)
        return view('admins.translations.index', compact('language'));
    }

    // DataTables server-side JSON
    public function datatable($lang, Request $r)
    {
        $language = Language::where('code', $lang)->firstOrFail();
        $default  = Language::where('is_default', true)->first(); // English (reference)

        $draw   = (int) $r->get('draw', 1);
        $start  = (int) $r->get('start', 0);
        $length = (int) $r->get('length', 50);
        $search = $r->input('search.value', null);
        $orderColIndex = (int) data_get($r->input('order', [['column' => 1]]), '0.column', 1);
        $orderDir = data_get($r->input('order', [['dir' => 'asc']]), '0.dir', 'asc');

        // 0=srno, 1=key, 2=default_en, 3=value, 4=action
        $orderable = [
            1 => 'translation_keys.key',
            2 => 'default_tv.value',
            3 => 'current_tv.value',
        ];
        $orderBy = $orderable[$orderColIndex] ?? 'translation_keys.key';
        $orderDir = strtolower($orderDir) === 'desc' ? 'desc' : 'asc';

        // base query: join current language value + LEFT JOIN default(English) value
        $base = DB::table('translation_keys')
            ->leftJoin('translation_values as current_tv', function ($j) use ($language) {
                $j->on('current_tv.translation_key_id', '=', 'translation_keys.id')
                    ->where('current_tv.language_id', '=', $language->id);
            })
            ->leftJoin('translation_values as default_tv', function ($j) use ($default) {
                if ($default) {
                    $j->on('default_tv.translation_key_id', '=', 'translation_keys.id')
                        ->where('default_tv.language_id', '=', $default->id);
                } else {
                    // no default language yet; still left join w/ impossible id to keep columns
                    $j->on('default_tv.translation_key_id', '=', 'translation_keys.id')
                        ->whereRaw('1=0');
                }
            })
            ->select(
                'translation_keys.id as id',
                'translation_keys.key as tkey',
                DB::raw("COALESCE(default_tv.value, '') as default_value"),
                DB::raw("COALESCE(current_tv.value, '') as tvalue")
            );

        $recordsTotal = (clone $base)->count();

        if ($search) {
            $base->where(function ($q) use ($search) {
                $q->where('translation_keys.key', 'like', "%{$search}%")
                    ->orWhere('current_tv.value', 'like', "%{$search}%")
                    ->orWhere('default_tv.value', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = (clone $base)->count();

        $rows = $base->orderBy($orderBy, $orderDir)->skip($start)->take($length)->get();

        $data = [];
        $sr = $start + 1;
        foreach ($rows as $row) {
            $data[] = [
                'srno' => $sr++,
                'key'  => '<input type="text" class="form-control" value="' . e($row->tkey) . '" readonly>',
                'default_en' => '<div>' . nl2br(e($row->default_value)) . '</div>',
                'value' => '<textarea class="form-control js-translation-input" style="width: 100% !important;" rows="3" data-key-id="' . $row->id . '">' . e($row->tvalue) . '</textarea><small class="text-muted js-inline-status" style="display:none;"></small>',
                'action' => '<button type="button" class="btn btn-primary btn-xs js-save-one"  data-key-id="' . $row->id . '">Save</button>
                         <button type="button" class="btn btn-danger btn-xs js-delete-key" data-key-id="' . $row->id . '">Delete Key</button>',
            ];
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    // Add a new key ONCE (no values here)
    public function storeKey($lang, Request $r)
    {
        $r->validate(['key' => 'required|string|max:200|unique:translation_keys,key']);
        $tkey = TranslationKey::create(['key' => $r->key]);

        // if editor supplied an English default value, save it to default language
        if ($r->filled('default_value')) {
            $default = Language::where('is_default', true)->first();
            if ($default) {
                TranslationValue::updateOrCreate(
                    ['language_id' => $default->id, 'translation_key_id' => $tkey->id],
                    ['value' => $r->input('default_value')]
                );
            }
        }

        return back()->with('success', 'Key added. Now set values per language.');
    }

    // Save/update one value for a key for this language (keys are immutable)
    public function saveValue($lang, Request $r, TranslationSyncService $sync)
    {
        $language = Language::where('code', $lang)->firstOrFail();
        $data = $r->validate([
            'translation_key_id' => 'required|exists:translation_keys,id',
            'value' => 'nullable|string'
        ]);

        TranslationValue::updateOrCreate(
            ['language_id' => $language->id, 'translation_key_id' => $data['translation_key_id']],
            ['value' => $data['value']]
        );

        $sync->rebuildOne($language->code);

        return response()->json(['ok' => true, 'message' => 'Saved']);
    }

    // Save many values at once from the list table
    public function bulkSave($lang, Request $r, TranslationSyncService $sync)
    {
        $language = Language::where('code', $lang)->firstOrFail();
        $items = $r->get('items', []); // [translation_key_id => value]
        DB::transaction(function () use ($items, $language) {
            foreach ($items as $keyId => $val) {
                TranslationValue::updateOrCreate(
                    ['language_id' => $language->id, 'translation_key_id' => $keyId],
                    ['value' => $val]
                );
            }
        });
        $sync->rebuildOne($language->code);
        return redirect()->back()->with('success', 'Translations saved.');
    }

    // Import values for this language from JSON (keys must exist or are optionally created)
    public function importJson($lang, Request $r, TranslationSyncService $sync)
    {
        $language = Language::where('code', $lang)->firstOrFail();
        $data = $r->validate([
            'json_file' => 'required|file|mimes:json,txt,application/json'
        ]);

        $json = json_decode(file_get_contents($r->file('json_file')->getRealPath()), true);
        if (!is_array($json)) return back()->with('error', 'Invalid JSON');

        DB::transaction(function () use ($json, $language) {
            foreach ($json as $key => $value) {
                // ensure key exists (create-if-missing)
                $tkey = TranslationKey::firstOrCreate(['key' => $key]);
                TranslationValue::updateOrCreate(
                    ['language_id' => $language->id, 'translation_key_id' => $tkey->id],
                    ['value' => (string)$value]
                );
            }
        });

        $sync->rebuildOne($language->code);
        return redirect()->back()->with('success', 'JSON imported & synced.');
    }

    // Optional: delete a key across all languages
    public function deleteKey($lang, $keyId)
    {
        TranslationKey::findOrFail($keyId)->delete();
        return redirect()->back()->with('success', 'Key deleted.');
    }

    public function deleteKeyAjax($keyId)
    {
        TranslationKey::findOrFail($keyId)->delete();
        return response()->json(['ok' => true]);
    }
}
