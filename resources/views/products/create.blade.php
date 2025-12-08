@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create Product</h1>

    <!-- Main form for creating new product - multipart for image upload -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf  <!-- Laravel CSRF protection token -->

        <!-- PRODUCT NAME INPUT -->
        <div class="mb-3">
            <label class="form-label fw-bold">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <!-- PRODUCT DETAILS TEXTAREA -->
        <div class="mb-3">
            <label class="form-label fw-bold">Details</label>
            <textarea name="details" class="form-control" required></textarea>
        </div>

        <!-- SINGLE IMAGE FILE UPLOAD (REQUIRED) -->
        <div class="mb-3">
            <label class="form-label fw-bold">Product Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
            <!-- accept="image/*" restricts to image files only -->
        </div>

        <!-- PRODUCT SIZE INPUT -->
        <div class="mb-3">
            <label class="form-label fw-bold">Size</label>
            <input type="text" name="size" class="form-control" required>
        </div>

        <!-- PRODUCT COLOR INPUT -->
        <div class="mb-3">
            <label class="form-label fw-bold">Color</label>
            <input type="text" name="color" class="form-control" required>
        </div>

        <!-- PRODUCT CATEGORY INPUT -->
        <div class="mb-3">
            <label class="form-label fw-bold">Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>

        <!-- PRODUCT PRICE NUMBER INPUT -->
        <div class="mb-3">
            <label class="form-label fw-bold">Price</label>
            <input type="number" name="price" class="form-control" required>
            <!-- type="number" ensures numeric input only -->
        </div>

        <!-- FORM ACTION BUTTONS -->
        <button type="submit" class="btn btn-primary">Create Product</button>
        <!-- Back button to return to products list -->
        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
@endsection
