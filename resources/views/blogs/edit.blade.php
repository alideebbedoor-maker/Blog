@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Blog</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}">
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control">{{ old('content', $blog->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Image</label>
            @if($blog->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$blog->image) }}" width="150" alt="Blog Image">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Categories</label>
            <select name="category_ids[]" class="form-select" multiple>
                @foreach($categories as $category)
               <option value="{{ $category->id }}"
                    @if(in_array($category->id, $blogCategories)) selected @endif
                  >{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Blog</button>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection