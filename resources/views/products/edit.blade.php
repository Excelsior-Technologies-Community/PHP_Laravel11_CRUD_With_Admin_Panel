@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Product</h1>

    <!-- Edit form submits to products.update route with PUT method spoofing -->
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf          <!-- CSRF protection token -->
        @method('PUT') <!-- Laravel method spoofing for PUT request -->

        <!-- PRODUCT NAME INPUT - pre-filled with current value or old input -->
        <div class="mb-3">
            <label class="form-label fw-bold">Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $product->name) }}" required>
            <!-- old('name', $product->name) shows old input on validation fail, else current value -->
        </div>

        <!-- PRODUCT DETAILS TEXTAREA - pre-filled -->
        <div class="mb-3">
            <label class="form-label fw-bold">Details</label>
            <textarea name="details" class="form-control" required>
                {{ old('details', $product->details) }}
            </textarea>
        </div>

        <!-- SHOW CURRENT IMAGE (READ-ONLY PREVIEW) -->
        <div class="mb-3">
            <label class="form-label fw-bold">Current Image</label><br>
            @if($product->image)
                <!-- Display existing product image (100px width) -->
                <img src="{{ asset($product->image) }}" width="100" class="border rounded mb-2">
            @else
                <!-- Fallback if no image exists -->
                <p class="text-muted">No Image Found</p>
            @endif
        </div>

        <!-- NEW IMAGE UPLOAD (OPTIONAL) -->
        <div class="mb-3">
            <label class="form-label fw-bold">Upload New Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <!-- No 'required' - optional for updates -->
            <small class="text-muted">Leave blank if you don't want to replace the image.</small>
        </div>

        <!-- PRODUCT SIZE INPUT - pre-filled -->
        <div class="mb-3">
            <label class="form-label fw-bold">Size</label>
            <input type="text" name="size" class="form-control"
                   value="{{ old('size', $product->size) }}" required>
        </div>

        <!-- PRODUCT COLOR INPUT - pre-filled -->
        <div class="mb-3">
            <label class="form-label fw-bold">Color</label>
            <input type="text" name="color" class="form-control"
                   value="{{ old('color', $product->color) }}" required>
        </div>

        <!-- PRODUCT CATEGORY INPUT - pre-filled -->
        <div class="mb-3">
            <label class="form-label fw-bold">Category</label>
            <input type="text" name="category" class="form-control"
                   value="{{ old('category', $product->category) }}" required>
        </div>

        <!-- PRODUCT PRICE NUMBER INPUT - pre-filled -->
        <div class="mb-3">
            <label class="form-label fw-bold">Price</label>
            <input type="number" name="price" class="form-control"
                   value="{{ old('price', $product->price) }}" required>
        </div>

        <!-- FORM ACTION BUTTONS -->
        <button type="submit" class="btn btn-primary">Update Product</button>
        <!-- Back button to return to products list -->
        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back</a>
    </form>
</div>
@endsection
