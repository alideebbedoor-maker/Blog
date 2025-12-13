{
        $blogs = Blog::with('categories')->latest()->get();
        $categories = Category::all();
        
        // استخدم frontend view إذا موجود، وإلا استخدم admin view مع إخفاء الأزرار
        if (view()->exists('frontend.blogs.index')) {
            return view('frontend.blogs.index', compact('blogs', 'categories'));
        }
        
        return view('blogs.index', compact('blogs', 'categories'))
            ->with('isFrontend', true);
    }

    public function frontendShow(Blog $blog)
    {
        $blog->load('categories');
        
        if (view()->exists('frontend.blogs.show')) {
            return view('frontend.blogs.show', compact('blog'));
        }
        
        return view('blogs.edit', compact('blog'))
            ->with('isFrontend', true);
    }

    public function filterByCategory(Category $category)
    {
        $blogs = $category->blogs()->with('categories')->latest()->get();
        $categories = Category::all();
        
        if (view()->exists('frontend.blogs.index')) {
            return view('frontend.blogs.index', compact('blogs', 'categories', 'category'));
        }
        
        return view('blogs.index', compact('blogs', 'categories'))
            ->with('isFrontend', true)
            ->with('currentCategory', $category);
    }

    public function toggleFavorite(Blog $blog)
    {
        $user = auth()->user();

        if ($user->favorites()->where('blog_id', $blog->id)->exists()) {
            $user->favorites()->detach($blog->id);
            $message = 'Removed from favorites';
            $type = 'warning';
        } else {
            $user->favorites()->attach($blog->id);
            $message = 'Added to favorites';
            $type = 'success';
        }
        
        return back()->with($type, $message);
    }
    
    public function favorites()
    {
        $favorites = auth()->user()->favorites()->with('categories')->latest()->get();
        
        if (view()->exists('frontend.favorites')) {
            return view('frontend.favorites', compact('favorites'));
        }
        
        return view('blogs.index', ['blogs' => $favorites])
            ->with('isFrontend', true)
            ->with('title', 'My Favorites');
    }
}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Blogs</h1>
    
    {{-- فقط أضفت هذا الشرط لحل الخطأ --}}
    @auth
        @if(auth()->user()->is_admin == 1)
            <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Add New Blog</a>
        @endif
    @endauth

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
           <th>Title</th>
        <th>Categories</th>
         <th>Image</th>
         <th>Actions</th>
     </tr>
        </thead>
        <tbody>
    @foreach($blogs as $blog)
         <tr>
             <td>{{ $blog->title }}</td>
             <td>
                @foreach($blog->categories as $cat)
                    <span class="badge bg-secondary">{{ $cat->name }}</span>
                   @endforeach
                    </td>
                    <td>
                        @if($blog->image)
                            <img src="{{ asset('storage/'.$blog->image) }}" width="100" alt="Blog Image">
                        @endif
            </td>
                <td>
                {{-- فقط أضفت هذا الشرط لحل الخطأ --}}
                @auth
                    @if(auth()->user()->is_admin == 1)
                        <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning">Edit</a>
                      
                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    @endif
                @endauth
                  </td>
         </tr>
            @endforeach
        </tbody>
    </table>

    {{-- فقط أضفت هذا الشرط لحل الخطأ --}}
    @auth
        @if(auth()->user()->is_admin == 1)
            <a href="{{ route('blogs.trash') }}" class="btn btn-secondary mt-3">View Trash</a>
        @endif
    @endauth
</div>
@endsection