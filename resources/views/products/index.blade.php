@extends('layouts.admin')

@section('styles')
<style>
    .filter-form .form-control,
    .filter-form .form-select {
        font-size: 0.875rem;
        padding: 0.45rem 0.75rem;
    }

    .filter-form label {
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .product-image {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .stats-card {
        border: 0;
        border-radius: 12px;
        transition: 0.2s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
    }

    .stats-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 20px;
    }

    .table th {
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
    }
</style>
@endsection


@section('content')

<div class="container-fluid py-4">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                📦 Products
            </h2>

            <p class="text-muted mb-0">
                Manage, search and monitor all products.
            </p>
        </div>

        <div class="d-flex gap-2">

            {{-- Analytics --}}
            <a
                href="{{ route('products.analytics') }}"
                class="btn btn-dark">
                📊 Analytics
            </a>

            {{-- CSV Export --}}
            <a
                href="{{ route('products.export', request()->query()) }}"
                class="btn btn-success">
                📥 Export CSV
            </a>

            {{-- Trash --}}
            <a
                href="{{ route('products.trash') }}"
                class="btn btn-outline-danger">
                🗑️ Trash
            </a>

            {{-- Create --}}
            <a
                href="{{ route('products.create') }}"
                class="btn btn-primary">
                ➕ Add Product
            </a>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show shadow-sm">

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>

    </div>

    @endif


    {{-- ========================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show shadow-sm">

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>

    </div>

    @endif


    {{-- ========================================================= --}}
    {{-- VALIDATION ERRORS --}}
    {{-- ========================================================= --}}

    @if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif


    {{-- ========================================================= --}}
    {{-- QUICK STATS --}}
    {{-- ========================================================= --}}

    <div class="row g-3 mb-4">

        {{-- Total Products --}}
        <div class="col-md-3">

            <div class="card stats-card shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="stats-icon bg-primary-subtle text-primary me-3">
                        📦
                    </div>

                    <div>

                        <small class="text-muted">
                            Total Products
                        </small>

                        <h4 class="fw-bold mb-0">
                            {{ $products->total() }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- Current Page --}}
        <div class="col-md-3">

            <div class="card stats-card shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="stats-icon bg-success-subtle text-success me-3">
                        📄
                    </div>

                    <div>

                        <small class="text-muted">
                            Current Page
                        </small>

                        <h4 class="fw-bold mb-0">
                            {{ $products->count() }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- In Stock --}}
        <div class="col-md-3">

            <div class="card stats-card shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="stats-icon bg-info-subtle text-info me-3">
                        📦
                    </div>

                    <div>

                        <small class="text-muted">
                            In Stock
                        </small>

                        <h4 class="fw-bold mb-0">

                            {{ $products->where('stock', '>', 0)->count() }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- Out Of Stock --}}
        <div class="col-md-3">

            <div class="card stats-card shadow-sm h-100">

                <div class="card-body d-flex align-items-center">

                    <div class="stats-icon bg-danger-subtle text-danger me-3">
                        ⚠️
                    </div>

                    <div>

                        <small class="text-muted">
                            Out of Stock
                        </small>

                        <h4 class="fw-bold mb-0">

                            {{ $products->where('stock', '<=', 0)->count() }}

                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- FILTER FORM --}}
    {{-- ========================================================= --}}

    <form
        method="GET"
        action="{{ route('products.index') }}"
        class="filter-form mb-4 p-3 bg-white rounded shadow-sm">

        <div class="row g-3 align-items-end">

            {{-- Search --}}
            <div class="col-md-3">

                <label for="searchInput">
                    Search
                </label>

                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    class="form-control"
                    placeholder="Search products..."
                    value="{{ request('search') }}">

            </div>


            {{-- Category --}}
            <div class="col-md-2">

                <label for="categoryFilter">
                    Category
                </label>

                <select
                    id="categoryFilter"
                    name="category"
                    class="form-select">

                    <option value="">
                        All Categories
                    </option>

                    @foreach($categories as $cat)

                    <option
                        value="{{ $cat }}"
                        {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>

                    @endforeach

                </select>

            </div>


            {{-- Minimum Price --}}
            <div class="col-md-2">

                <label for="priceMin">
                    Min Price (₹)
                </label>

                <input
                    type="number"
                    id="priceMin"
                    name="price_min"
                    class="form-control"
                    placeholder="Min"
                    min="0"
                    step="1"
                    value="{{ request('price_min') }}">

            </div>


            {{-- Maximum Price --}}
            <div class="col-md-2">

                <label for="priceMax">
                    Max Price (₹)
                </label>

                <input
                    type="number"
                    id="priceMax"
                    name="price_max"
                    class="form-control"
                    placeholder="Max"
                    min="0"
                    step="1"
                    value="{{ request('price_max') }}">

            </div>


            {{-- Sort --}}
            <div class="col-md-3">

                <label for="sortSelect">
                    Sort By
                </label>

                <select
                    id="sortSelect"
                    name="sort"
                    class="form-select">

                    <option
                        value="latest"
                        {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>
                        Latest
                    </option>

                    <option
                        value="price_asc"
                        {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                        Price: Low to High
                    </option>

                    <option
                        value="price_desc"
                        {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                        Price: High to Low
                    </option>

                    <option
                        value="name_asc"
                        {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                        Name: A to Z
                    </option>

                    <option
                        value="name_desc"
                        {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                        Name: Z to A
                    </option>

                    <option
                        value="stock_asc"
                        {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>
                        Stock: Low to High
                    </option>

                    <option
                        value="stock_desc"
                        {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>
                        Stock: High to Low
                    </option>

                </select>

            </div>


            {{-- Stock --}}
            <div class="col-md-2">

                <label for="stockStatus">
                    Stock
                </label>

                <select
                    id="stockStatus"
                    name="stock_status"
                    class="form-select">

                    <option value="">
                        All
                    </option>

                    <option
                        value="in_stock"
                        {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>
                        In Stock
                    </option>

                    <option
                        value="out_of_stock"
                        {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                        Out of Stock
                    </option>

                </select>

            </div>


            {{-- Status --}}
            <div class="col-md-2">

                <label for="status">
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="form-select">

                    <option value="">
                        All
                    </option>

                    <option
                        value="active"
                        {{ request('status') == 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option
                        value="inactive"
                        {{ request('status') == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>


            {{-- Filter Buttons --}}
            <div class="col-md-8 text-end">

                <button
                    type="submit"
                    class="btn btn-primary btn-sm">
                    🔎 Apply Filters
                </button>

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-outline-secondary btn-sm">
                    ✕ Clear Filters
                </a>

            </div>

        </div>

    </form>


    {{-- ========================================================= --}}
    {{-- RESULT INFORMATION --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <span class="text-muted">

                Showing
                <strong>
                    {{ $products->firstItem() ?? 0 }}
                </strong>

                to

                <strong>
                    {{ $products->lastItem() ?? 0 }}
                </strong>

                of

                <strong>
                    {{ $products->total() }}
                </strong>

                products

            </span>

        </div>

        <div>

            @if(request()->hasAny([
            'search',
            'category',
            'price_min',
            'price_max',
            'stock_status',
            'status',
            'sort'
            ]))

            <span class="badge bg-primary">
                Filters Applied
            </span>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PRODUCTS TABLE --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0 align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Product
                            </th>

                            <th>
                                Details
                            </th>

                            <th>
                                Image
                            </th>

                            <th>
                                Size
                            </th>

                            <th>
                                Color
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Stock
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($products as $product)

                        <tr>

                            {{-- ID --}}
                            <td>
                                <span class="text-muted">
                                    #{{ $product->id }}
                                </span>
                            </td>


                            {{-- Product Name --}}
                            <td>

                                <div class="fw-semibold">
                                    {{ $product->name }}
                                </div>

                            </td>


                            {{-- Details --}}
                            <td style="max-width: 220px; white-space: normal;">

                                <span
                                    class="text-muted"
                                    title="{{ $product->details }}">
                                    {{ Str::limit($product->details, 60) }}
                                </span>

                            </td>


                            {{-- Image --}}
                            <td>

                                @if($product->image)

                                <img
                                    src="{{ asset($product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-image">

                                @else

                                <span class="text-muted">
                                    No Image
                                </span>

                                @endif

                            </td>


                            {{-- Size --}}
                            <td>
                                {{ $product->size }}
                            </td>


                            {{-- Color --}}
                            <td>
                                {{ $product->color }}
                            </td>


                            {{-- Category --}}
                            <td>

                                <span class="badge bg-light text-dark border">
                                    {{ $product->category }}
                                </span>

                            </td>


                            {{-- Price --}}
                            <td>

                                <span class="fw-bold text-success">
                                    ₹{{ number_format($product->price, 2) }}
                                </span>

                            </td>


                            {{-- Stock --}}
                            <td>

                                @if($product->stock > 0)

                                <span class="badge bg-success">

                                    {{ $product->stock }}

                                    Available

                                </span>

                                @else

                                <span class="badge bg-danger">
                                    Out of Stock
                                </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($product->is_active)

                                <span class="badge bg-primary">
                                    Active
                                </span>

                                @else

                                <span class="badge bg-secondary">
                                    Inactive
                                </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="action-buttons">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('products.show', $product) }}"
                                        class="btn btn-info btn-sm text-white"
                                        title="View Product">
                                        👁️
                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                        class="btn btn-warning btn-sm"
                                        title="Edit Product">
                                        ✏️
                                    </a>


                                    {{-- Delete / Trash --}}
                                    <form
                                        action="{{ route('products.destroy', $product) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Move to Trash"
                                            onclick="return confirm('Are you sure you want to move this product to trash?')">
                                            🗑️
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="11"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <div
                                        style="font-size: 40px;">
                                        📦
                                    </div>

                                    <h5 class="mt-2">
                                        No products found
                                    </h5>

                                    <p class="mb-3">
                                        Try changing your filters or search.
                                    </p>

                                    <a
                                        href="{{ route('products.index') }}"
                                        class="btn btn-outline-primary btn-sm">
                                        Reset Filters
                                    </a>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PAGINATION --}}
    {{-- ========================================================= --}}

    @if($products->hasPages())

    <div class="mt-4">

        {{ $products->withQueryString()->links() }}

    </div>

    @endif

</div>

@endsection


{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.querySelector('.filter-form');

        const searchInput = document.getElementById('searchInput');

        let debounceTimer;


        /*
        |--------------------------------------------------------------------------
        | Auto submit search
        |--------------------------------------------------------------------------
        */

        if (searchInput) {

            searchInput.addEventListener('input', function() {

                clearTimeout(debounceTimer);

                debounceTimer = setTimeout(function() {

                    form.submit();

                }, 500);

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Auto submit select filters
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll(
            '#categoryFilter, #sortSelect, #stockStatus, #status'
        ).forEach(function(element) {

            element.addEventListener('change', function() {

                form.submit();

            });

        });


    });
</script>

@endpush