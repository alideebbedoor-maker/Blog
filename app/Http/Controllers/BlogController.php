<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // عرض قائمة جميع المدونات
    public function index()
    {
        $blogs = Blog::with('categories')->get();
        return view('blogs.index', compact('blogs'));
    }

    // صفحة إضافة Blog جديد
    public function create()
    {
        $categories = Category::all();
        return view('blogs.create', compact('categories'));
    }

    // حفظ Blog جديد
    public function store(StoreBlogRequest $request)
    {
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->content = $request->content;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('blogs', 'public');
            $blog->image = $image;
        }

        $blog->save();

        // ربط المدونة مع عدة Categories
        $blog->categories()->sync($request->category_ids ?? []);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    // صفحة عرض Blog واحد (اختياري)
    public function show(Blog $blog)
    {
        return view('blogs.show', compact('blog'));
    }

    // صفحة تعديل Blog
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        $blogCategories = $blog->categories->pluck('id')->toArray();
        return view('blogs.edit', compact('blog', 'categories', 'blogCategories'));
    }

    // تحديث Blog
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->title = $request->title ?? $blog->title;
        $blog->content = $request->content ?? $blog->content;

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::delete('public/' . $blog->image);
            }
            $image = $request->file('image')->store('blogs', 'public');
            $blog->image = $image;
        }

        $blog->save();

        // تحديث علاقة Categories
        $blog->categories()->sync($request->category_ids ?? []);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    // حذف Blog (Soft Delete)
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    // عرض المدونات المحذوفة (Trash)
    public function trash()
    {
        $blogs = Blog::onlyTrashed()->with('categories')->get();
        return view('blogs.trash', compact('blogs'));
    }

    // استعادة Blog محذوف
    public function restore($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        $blog->restore();
        return redirect()->route('blogs.trash')->with('success', 'Blog restored successfully.');
    }

    // حذف Blog نهائي (Force Delete)
    public function forceDelete($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        if ($blog->image) {
            Storage::delete('public/' . $blog->image);
        }
        $blog->forceDelete();
        return redirect()->route('blogs.trash')->with('success', 'Blog permanently deleted.');
    }
}