@extends('layouts.app')

@section('title', 'Category Form')

@section('content')

<div class="container">
    <h2>{{ isset($category->id) ? 'Edit Category' : 'Create Category' }}</h2>

  <form method="POST" 
      action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}">
    @csrf
    @if(isset($category))
        @method('PUT')
    @endif

    <div class="form-group mb-3">
        <label for="name">Category Name</label>
        <input type="text" 
               name="name" 
               id="name" 
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $category->name ?? '') }}" 
               placeholder="Enter category name" 
               required>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <button type="submit" class="btn btn-success">
            {{ isset($category) ? 'Update Category' : 'Save Category' }}
        </button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
    </div>
</form>

</div>

@endsection
