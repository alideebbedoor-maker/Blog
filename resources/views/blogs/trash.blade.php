@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Trash - Deleted Blogs</h1>

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
                <form action="{{ route('blogs.restore', $blog->id) }}" method="POST" style="display:inline-block;">
               @csrf
                  @method('PUT')
                        <button type="submit" class="btn btn-sm btn-success">Restore</button>
                   </form>

                        <form action="{{ route('blogs.forceDelete', $blog->id) }}" method="POST" style="display:inline-block;">
             @csrf
                   @method('DELETE')
                  <button type="submit" onclick="return confirm('Delete permanently?')" class="btn btn-sm btn-danger">Delete</button>
                </form>
               </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('blogs.index') }}" class="btn btn-secondary mt-3">Back to Blogs</a>
</div>
@endsection