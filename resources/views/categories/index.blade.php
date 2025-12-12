@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
           <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
          <tr>
               <td>{{ $category->name }}</td>
              <td>
                 <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
            @csrf
                      @method('DELETE')
                  <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                  </form>
               </td>
              </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection