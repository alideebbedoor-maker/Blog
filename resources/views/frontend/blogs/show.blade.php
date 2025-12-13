@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $blog->title }}</h1>

    @if($blog->image)
        <img src="{{ Storage::url($blog->image) }}" class="img-fluid mb-3" alt="{{ $blog->title }}">
    @endif

    <p>{{ $blog->content }}</p>

    <p>
        @foreach($blog->categories as $cat)
            <span class="badge bg-info">{{ $cat->name }}</span>
        @endforeach
    </p>

    @auth
        <form action="{{ route('blogs.frontend.toggleFavorite', $blog) }}" method="POST">
            @csrf
            <button type="submit" class="btn {{ auth()->user()->favoriteBlogs->contains($blog) ? 'btn-danger' : 'btn-success' }}">
                {{ auth()->user()->favoriteBlogs->contains($blog) ? 'Remove from Favorites' : 'Add to Favorites' }}
            </button>
        </form>
    @endauth

    <a href="{{ route('blogs.frontend.index') }}" class="btn btn-secondary mt-2">Back to Blogs</a>
</div>
@endsection