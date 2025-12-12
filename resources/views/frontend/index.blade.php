@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Blogs</h1>

    <div class="mb-3">
        <strong>Filter by Category:</strong>
        <a href="{{ route('blogs.frontend.index') }}" class="btn btn-sm btn-secondary">All</a>
        @foreach(\App\Models\Category::all() as $category)
            <a href="{{ route('blogs.frontend.filter', $category->id) }}" class="btn btn-sm btn-primary">{{ $category->name }}</a>
        @endforeach
    </div>

    <div class="row">
        @foreach($blogs as $blog)
        <div class="col-md-4 mb-4">
            <div class="card">
                @if($blog->image)
                <img src="{{ Storage::url($blog->image) }}" class="card-img-top" alt="{{ $blog->title }}">
        @endif
          <div class="card-body">
               <h5 class="card-title">{{ $blog->title }}</h5>
                    <p>
                  @foreach($blog->categories as $cat)
                            <span class="badge bg-info">{{ $cat->name }}</span>
                   @endforeach
                    </p>
                    <a href="{{ route('blogs.frontend.show', $blog->id) }}" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection