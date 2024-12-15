@extends('layouts.app')

@section('title', 'Category List')

@section('content')
<div class="container mt-4">
    <h2>{{ $products->id ? 'Edit Product' : 'Create Product' }}</h2>

    <form method="POST" action="{{ $products->id ? route('products.update', $products->id) : route('products.store') }}">
        @csrf
        @if($products->id)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $products->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">Select a Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == old('category_id', $products->category_id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $products->price) }}" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-success">{{ $products  ->id ? 'Update' : 'Save' }}</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
