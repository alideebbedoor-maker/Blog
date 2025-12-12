@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Filter by Category --}}
    <div class="mb-3">
        <strong>Filter by Category:</strong>
        <a href="{{ route('blogs.frontend.index') }}" class="btn btn-sm btn-secondary">All</a>
        @foreach(\App\Models\Category::all() as $category)
            <a href="{{ route('blogs.frontend.filter', $category->id) }}" class="btn btn-sm btn-primary">{{ $category->name }}</a>
        @endforeach
    </div>

    {{-- Blogs List --}}
    <div class="row">
        @forelse($blogs as $blog)
            <div class="col-md-4 mb-3">
                <div class="card">
                    @if($blog->image)
                    <img src="{{ asset('storage/'.$blog->image) }}" class="card-img-top" alt="{{ $blog->title }}">
                  @endif
                    <div class="card-body">
                  <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text">{{ Str::limit($blog->content, 100) }}</p>
                        
                    {{-- Categories --}}
                       <p>
                            @foreach($blog->categories as $cat)
                              <span class="badge bg-info">{{ $cat->name }}</span>
                           @endforeach
                        </p>
                       {{-- Details link --}}
                       <a href="{{ route('blogs.frontend.show', $blog->id) }}" class="btn btn-primary btn-sm">Read More</a>
                 {{-- Favorite button --}}
                        @auth
                       <form action="{{ route('blogs.toggleFavorite', $blog->id) }}" method="POST" class="d-inline">
                                @csrf
                           @if(auth()->user()->favorites->contains($blog->id))
                        <button type="submit" class="btn btn-danger btn-sm">Remove from Favorites</button>
                     @else
                        <button type="submit" class="btn btn-success btn-sm">Add to Favorites</button>
                        @endif
                      </form>
                   @endauth
                   </div>
                </div>
            </div>
        @empty
            <p>No blogs found.</p>
        @endforelse
    </div>
</div>
@endsection