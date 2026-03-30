<?php

// app/Http/Controllers/LocaleController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{
    public function switch(Request $request)
    {
        $request->validate(['locale' => 'required|string|max:10']);

        // Make sure it’s a known language
        $exists = Language::where('code', $request->locale)->exists();
        if (!$exists) {
            return back()->with('error', 'Unsupported language.');
        }

        // Save in session + cookie (so guests keep it)
        session(['locale' => $request->locale]);
        Cookie::queue('locale', $request->locale, 60 * 24 * 30); // 30 days

        // If you store per-user preference:
        if ($request->user()) {
            $request->user()->forceFill(['locale' => $request->locale])->save();
        }

        // If normal form submit: go back to the same page (URL unchanged)
        if (!$request->wantsJson()) {
            return back();
        }

        // For AJAX: just ok=true
        return response()->json(['ok' => true]);
    }

    public function switch_ar(Request $request)
    {

        // Make sure it’s a known language
        $exists = Language::where('code', 'ar')->exists();
        if (!$exists) {
            return back()->with('error', 'Unsupported language.');
        }

        // Save in session + cookie (so guests keep it)
        session(['locale' => 'ar']);
        Cookie::queue('locale', 'ar', 60 * 24 * 30); // 30 days

        // If you store per-user preference:
        if ($request->user()) {
            $request->user()->forceFill(['locale' => 'ar'])->save();
        }

        // If normal form submit: go back to the same page (URL unchanged)
        if (!$request->wantsJson()) {
            return back();
        }

        // For AJAX: just ok=true
        return response()->json(['ok' => true]);
    }

    public function switch_en(Request $request)
    {

        // Make sure it’s a known language
        $exists = Language::where('code', 'en')->exists();
        if (!$exists) {
            return back()->with('error', 'Unsupported language.');
        }

        // Save in session + cookie (so guests keep it)
        session(['locale' => 'en']);
        Cookie::queue('locale', 'en', 60 * 24 * 30); // 30 days

        // If you store per-user preference:
        if ($request->user()) {
            $request->user()->forceFill(['locale' => 'en'])->save();
        }

        // If normal form submit: go back to the same page (URL unchanged)
        if (!$request->wantsJson()) {
            return back();
        }

        // For AJAX: just ok=true
        return response()->json(['ok' => true]);
    }
}
