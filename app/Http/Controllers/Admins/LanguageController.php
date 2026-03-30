<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Services\TranslationSyncService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index() {
        $languages = Language::orderByDesc('is_default')->orderBy('name')->get();
        $edit = null; // create mode
        return view('admins.languages.index', compact('languages','edit'));
    }

    public function edit($id) {
        $languages = Language::orderByDesc('is_default')->orderBy('name')->get();
        $edit = Language::findOrFail($id);
        return view('admins.languages.index', compact('languages','edit'));
    }

    public function store(Request $r, TranslationSyncService $sync) {
        $data = $r->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:10|unique:languages,code',
            'is_default' => 'nullable|boolean',
        ]);
        $lang = Language::create([
            'name'=>$data['name'],
            'code'=>$data['code'],
            'is_default'=> $r->boolean('is_default'),
        ]);
        if ($lang->is_default) {
            Language::where('id','<>',$lang->id)->update(['is_default'=>false]);
        }
        $sync->rebuildOne($lang->code);
        return back()->with('success','Language created.');
    }

    public function update($id, Request $r, TranslationSyncService $sync) {
        $lang = Language::findOrFail($id);
        $data = $r->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:10|unique:languages,code,'.$lang->id,
            'is_default' => 'nullable|boolean',
        ]);
        $lang->update([
            'name'=>$data['name'],
            'code'=>$data['code'],
            'is_default'=>$r->boolean('is_default')
        ]);
        if ($lang->is_default) {
            Language::where('id','<>',$lang->id)->update(['is_default'=>false]);
        }
        $sync->rebuildOne($lang->code);
        return redirect()->route('admins.languages')->with('success','Language updated.');
    }

    public function destroy($id) {
        $lang = Language::findOrFail($id);
        if ($lang->is_default) return back()->with('error','Cannot delete default language.');
        $lang->delete();
        return back()->with('success','Language deleted.');
    }

    public function makeDefault($id) {
        Language::query()->update(['is_default'=>false]);
        Language::where('id',$id)->update(['is_default'=>true]);
        return back()->with('success','Default language set.');
    }
}
