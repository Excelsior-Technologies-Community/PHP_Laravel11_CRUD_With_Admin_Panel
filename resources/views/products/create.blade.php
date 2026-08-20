@extends('layouts.admin')

@section('content')

<div class="container">

    <h1 class="mb-4">Create Product</h1>

    <form
        action="{{ route('products.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        {{-- Product Name --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Name
            </label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
            >

            @error('name')
                <div class="text-danger small">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- Product Details --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Details
            </label>

            <textarea
                name="details"
                class="form-control"
                rows="4"
            >{{ old('details') }}</textarea>

            @error('details')
                <div class="text-danger small">
                    {{ $message }}
                </div>
            @enderror

        </div>


        {{-- Product Image --}}
        <div class="mb-3">

            <label class="form-label fw-bold">
                Product Image
            </label>

            <input
                type="file"
                name="image"
                class="form-control"
                accept="image/jpeg,image/png"
                required
            >

            @error('image')
                <div class="text-danger small">
                    {{ $message }}
                </div>
            @enderror

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
                value="{{ old('size') }}"
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
                value="{{ old('color') }}"
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
                value="{{ old('category') }}"
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
                value="{{ old('price') }}"
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
                value="{{ old('stock', 0) }}"
                min="0"
                required
            >

            <small class="text-muted">
                Enter the number of products currently available.
            </small>

            @error('stock')
                <div class="text-danger small">
                    {{ $message }}
                </div>
            @enderror

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

                <option value="1"
                    {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                    Active
                </option>

                <option value="0"
                    {{ old('is_active') === '0' ? 'selected' : '' }}>
                    Inactive
                </option>

            </select>

            <small class="text-muted">
                Inactive products will not be displayed to customers.
            </small>

        </div>


        {{-- Buttons --}}
        <button
            type="submit"
            class="btn btn-primary"
        >
            Create Product
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