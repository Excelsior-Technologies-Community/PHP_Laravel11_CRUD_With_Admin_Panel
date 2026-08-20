@extends('layouts.admin')

@section('styles')
<style>
    .filter-form .form-control,
    .filter-form .form-select {
        font-size: 0.875rem;
        padding: 0.4rem 0.75rem;
    }

    .filter-form label {
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <!-- Header section with title and "Add New Product" button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📦 Products List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">➕ Add New Product</a>
    </div>

    <!-- Display success message from session flash data (set by controller after CRUD operations) -->
    @if(session('success'))
    <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <!-- Filter Form -->
    <form method="GET" class="filter-form mb-4 p-3 bg-white rounded shadow-sm">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="searchInput">Search</label>
                <input type="text" id="searchInput" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label for="categoryFilter">Category</label>
                <select id="categoryFilter" name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="priceMin">Min Price (₹)</label>
                <input type="number" id="priceMin" name="price_min" class="form-control" placeholder="Min" min="0" step="1" value="{{ request('price_min') }}">
            </div>
            <div class="col-md-2">
                <label for="priceMax">Max Price (₹)</label>
                <input type="number" id="priceMax" name="price_max" class="form-control" placeholder="Max" min="0" step="1" value="{{ request('price_max') }}">
            </div>
<div class="col-md-3">
    <label for="sortSelect">Sort By</label>

    <select
        id="sortSelect"
        name="sort"
        class="form-select"
    >

        <option
            value="latest"
            {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}
        >
            Latest
        </option>

        <option
            value="price_asc"
            {{ request('sort') == 'price_asc' ? 'selected' : '' }}
        >
            Price: Low to High
        </option>

        <option
            value="price_desc"
            {{ request('sort') == 'price_desc' ? 'selected' : '' }}
        >
            Price: High to Low
        </option>

        <option
            value="name_asc"
            {{ request('sort') == 'name_asc' ? 'selected' : '' }}
        >
            Name: A to Z
        </option>

        <option
            value="name_desc"
            {{ request('sort') == 'name_desc' ? 'selected' : '' }}
        >
            Name: Z to A
        </option>

    </select>
</div>


{{-- STOCK FILTER --}}
<div class="col-md-2">

    <label for="stockStatus">
        Stock
    </label>

    <select
        id="stockStatus"
        name="stock_status"
        class="form-select"
    >

        <option value="">
            All
        </option>

        <option
            value="in_stock"
            {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}
        >
            In Stock
        </option>

        <option
            value="out_of_stock"
            {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}
        >
            Out of Stock
        </option>

    </select>

</div>


{{-- ACTIVE STATUS FILTER --}}
<div class="col-md-2">

    <label for="status">
        Status
    </label>

    <select
        id="status"
        name="status"
        class="form-select"
    >

        <option value="">
            All
        </option>

        <option
            value="active"
            {{ request('status') == 'active' ? 'selected' : '' }}
        >
            Active
        </option>

        <option
            value="inactive"
            {{ request('status') == 'inactive' ? 'selected' : '' }}
        >
            Inactive
        </option>

    </select>

</div>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-end">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">Clear Filters</a>
            </div>
        </div>
    </form>

    <!-- Main card container for products table with shadow styling -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <!-- Responsive table with hover effect showing all products -->
                <table class="table table-hover mb-0 align-middle">
                    <!-- Dark header row defining table columns -->
                    <thead class="table-dark">

                        <tr>

                            <th>Name</th>

                            <th width="18%">
                                Details
                            </th>

                            <th>Image</th>

                            <th>Size</th>

                            <th>Color</th>

                            <th>Category</th>

                            <th>Price (₹)</th>

                            <th>Stock</th>

                            <th>Status</th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>

<tbody>

@forelse($products as $product)

    <tr>

        <td class="fw-semibold">
            {{ $product->name }}
        </td>


        <td style="white-space: normal;">
            {{ Str::limit($product->details, 60) }}
        </td>


        <td>

            @if($product->image)

                <img
                    src="{{ asset($product->image) }}"
                    width="70"
                    class="rounded shadow-sm border"
                >

            @else

                <span class="text-muted">
                    No Image
                </span>

            @endif

        </td>


        <td>
            {{ $product->size }}
        </td>


        <td>
            {{ $product->color }}
        </td>


        <td>
            {{ $product->category }}
        </td>


        <td class="fw-bold text-success">
            ₹{{ number_format($product->price, 2) }}
        </td>


        {{-- STOCK --}}
        <td>

            @if($product->stock > 0)

                <span class="badge bg-success">
                    {{ $product->stock }} Available
                </span>

            @else

                <span class="badge bg-danger">
                    Out of Stock
                </span>

            @endif

        </td>


        {{-- STATUS --}}
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


        {{-- ACTIONS --}}
        <td class="text-center">

            <a
                href="{{ route('products.edit', $product) }}"
                class="btn btn-warning btn-sm me-1"
            >
                ✏ Edit
            </a>


            <form
                action="{{ route('products.destroy', $product) }}"
                method="POST"
                class="d-inline"
            >

                @csrf

                @method('DELETE')

                <button
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this product?')"
                >
                    🗑 Delete
                </button>

            </form>

        </td>

    </tr>

@empty

    <tr>

        <td
            colspan="10"
            class="text-center py-4 text-muted"
        >
            No products found.
        </td>

    </tr>

@endforelse

</tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PAGINATION LINKS --}}
<div class="mt-4">
    {{ $products->links() }}
</div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.filter-form input, .filter-form select').forEach(function(el) {
        el.addEventListener('change', function() {
            this.closest('form') ? this.closest('form').submit() : this.form.submit();
        });
        el.addEventListener('input', function() {
            if (this.type === 'text' || this.type === 'number') {
                clearTimeout(this._debounce);
                this._debounce = setTimeout(function() {
                    this.closest('form') ? this.closest('form').submit() : this.form.submit();
                }.bind(this), 500);
            }
        });
    });
</script>
@endpush