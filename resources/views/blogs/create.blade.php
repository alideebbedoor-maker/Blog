@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Blog</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
         @foreach($errors->all() as $error)
           <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control">{{ old('content') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Categories</label>
            <select name="category_ids[]" class="form-select" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Add Blog</button>
        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection