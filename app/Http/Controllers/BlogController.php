<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->latest()->get();
        return view('admins.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admins.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content' => 'required',
            'content_ar' => 'required',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'status' => 'required|boolean',
            'read_time' => 'nullable|integer|min:1',
            'added_by' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'short_description_ar' => 'nullable|string|max:500',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $directory = public_path('images/blogs/');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            $file = $request->file('image');
            $extension = 'webp';
            $name = time() . '.' . $extension;
            $file->move($directory, $name);
            $data['image'] = 'images/blogs/' . $name;
        }

        Blog::create($data);

        return redirect()->route('admins.blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        return view('admins.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content' => 'required',
            'content_ar' => 'required',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'status' => 'required|boolean',
            'read_time' => 'nullable|integer|min:1',
            'added_by' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'short_description_ar' => 'nullable|string|max:500',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            
            $directory = public_path('images/blogs/');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
            }

            $file = $request->file('image');
            $extension = 'webp';
            $name = time() . '.' . $extension;
            $file->move($directory, $name);
            $data['image'] = 'images/blogs/' . $name;

            // Delete the old image if it exists
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }
        }

        $blog->update($data);

        return redirect()->route('admins.blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }
        $blog->delete();
        return redirect()->route('admins.blogs.index')->with('success', 'Blog deleted successfully.');
    }
}