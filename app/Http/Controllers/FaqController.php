<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admins.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admins.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'question_ar' => 'required',
            'answer_ar' => 'required',
            'page' => 'nullable|string',
        ]);


        Faq::create($request->all());
        return redirect()->route('admins.faq')->with('success', 'FAQ created successfully');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admins.faq.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'question_ar' => 'required',
            'answer_ar' => 'required',
            'page' => 'nullable|string',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->all());
        return redirect()->route('admins.faq')->with('success', 'FAQ updated successfully');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return redirect()->route('admins.faq')->with('success', 'FAQ deleted successfully');
    }
}