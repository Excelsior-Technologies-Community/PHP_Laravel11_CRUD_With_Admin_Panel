@extends('layouts.admin')

@section('content')

<div class="container">

    <h1 class="mb-4">Edit Product</h1>

    <form
        action="{{ route('products.update', $product) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        @method('PUT')


        {{-- Name --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $product->name) }}"
                required
            >

        </div>


        {{-- Details --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Details
            </label>

            <textarea
                name="details"
                class="form-control"
                rows="4"
            >{{ old('details', $product->details) }}</textarea>

        </div>


        {{-- Current Image --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Current Image
            </label>

            <br>

            @if($product->image)

                <img
                    src="{{ asset($product->image) }}"
                    width="120"
                    class="border rounded mb-2"
                >

            @else

                <p class="text-muted">
                    No Image Found
                </p>

            @endif

        </div>


        {{-- New Image --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Upload New Image
            </label>

            <input
                type="file"
                name="image"
                class="form-control"
                accept="image/jpeg,image/png"
            >

            <small class="text-muted">
                Leave blank to keep the current image.
            </small>

        </div>


        {{-- Size --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Size
            </label>

            <input
                type="text"
                name="size"
                class="form-control"
                value="{{ old('size', $product->size) }}"
                required
            >

        </div>


        {{-- Color --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Color
            </label>

            <input
                type="text"
                name="color"
                class="form-control"
                value="{{ old('color', $product->color) }}"
                required
            >

        </div>


        {{-- Category --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Category
            </label>

            <input
                type="text"
                name="category"
                class="form-control"
                value="{{ old('category', $product->category) }}"
                required
            >

        </div>


        {{-- Price --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Price (₹)
            </label>

            <input
                type="number"
                name="price"
                class="form-control"
                value="{{ old('price', $product->price) }}"
                min="0"
                step="0.01"
                required
            >

        </div>


        {{-- Stock --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Stock Quantity
            </label>

            <input
                type="number"
                name="stock"
                class="form-control"
                value="{{ old('stock', $product->stock) }}"
                min="0"
                required
            >

            <small class="text-muted">
                Current available quantity.
            </small>

        </div>


        {{-- Availability --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Availability
            </label>

            <select
                name="is_active"
                class="form-select"
            >

                <option
                    value="1"
                    {{ old('is_active', $product->is_active ? '1' : '0') == '1' ? 'selected' : '' }}
                >
                    Active
                </option>

                <option
                    value="0"
                    {{ old('is_active', $product->is_active ? '1' : '0') == '0' ? 'selected' : '' }}
                >
                    Inactive
                </option>

            </select>

        </div>


        {{-- Buttons --}}
        <button
            type="submit"
            class="btn btn-primary"
        >
            Update Product
        </button>

        <a
            href="{{ route('products.index') }}"
            class="btn btn-secondary"
        >
            Back
        </a>

    </form>

</div>

@endsection