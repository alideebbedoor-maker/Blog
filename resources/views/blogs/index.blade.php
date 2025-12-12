@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Blogs</h1>
    <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Add New Blog</a>

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
                <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning">Edit</a>
                      
                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline-block;">
                  @csrf
                   @method('DELETE')
             <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
             </form>
                  </td>
         </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('blogs.trash') }}" class="btn btn-secondary mt-3">View Trash</a>
</div>
@endsection