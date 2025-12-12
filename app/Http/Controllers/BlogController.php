<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // ================= Admin Panel =================

    public function index()
    {
        $blogs = Blog::with('categories')->get();
        return view('blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('blogs.create', compact('categories'));
    }

    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $data['image'] ?? null,
        ]);

        $blog->categories()->sync($data['category_ids'] ?? []);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = Category::all();
        $blogCategories = $blog->categories->pluck('id')->toArray();
        return view('blogs.edit', compact('blog', 'categories', 'blogCategories'));
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update([
            'title' => $data['title'] ?? $blog->title,
            'content' => $data['content'] ?? $blog->content,
            'image' => $data['image'] ?? $blog->image,
        ]);

        if (isset($data['category_ids'])) {
            $blog->categories()->sync($data['category_ids']);
        }

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function trash()
    {
        $blogs = Blog::onlyTrashed()->with('categories')->get();
        return view('blogs.trash', compact('blogs'));
    }

    public function restore($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        $blog->restore();
        return redirect()->route('blogs.trash')->with('success', 'Blog restored successfully.');
    }

    public function forceDelete($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->forceDelete();
        return redirect()->route('blogs.trash')->with('success', 'Blog permanently deleted.');
    }

    // ================= Frontend =================

    public function frontendIndex()
    {
        $blogs = Blog::with('categories')->get();
        $categories = Category::all();
        return view('frontend.blogs.index', compact('blogs', 'categories'));
    }

    public function frontendShow(Blog $blog)
    {
        return view('frontend.blogs.show', compact('blog'));
    }

    public function filterByCategory(Category $category)
    {
        $blogs = $category->blogs()->with('categories')->get();
        $categories = Category::all();
        return view('frontend.blogs.index', compact('blogs', 'categories'));
    }

    public function toggleFavorite(Blog $blog)
    {
        $user = auth()->user();

        if ($user->favorites()->where('blog_id', $blog->id)->exists()) {
            $user->favorites()->detach($blog->id);
            return back()->with('success', 'Removed from favorites');
        } else {
            $user->favorites()->attach($blog->id);
            return back()->with('success', 'Added to favorites');
        }
    }

    public function favorites()
    {
        $favorites = auth()->user()->favorites()->with('categories')->get();
        return view('frontend.favorites', compact('favorites'));
    }
}