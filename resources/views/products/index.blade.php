@extends('layouts.admin')

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
                            <th width="20%">Details</th>  <!-- Fixed width for details column -->
                            <th>Image</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Category</th>
                            <th>Price (₹)</th>
                            <th class="text-center">Actions</th>  <!-- Centered actions column -->
                        </tr>
                    </thead>

                    <tbody>
                        <!-- Loop through $products collection passed from controller -->
                        @forelse($products as $product)
                            <!-- Individual product row -->
                            <tr>
                                <!-- Product name displayed as bold text -->
                                <td class="fw-semibold">{{ $product->name }}</td>

                                <!-- Product details truncated to 60 characters with normal line wrapping -->
                                <td style="white-space: normal;">
                                    {{ Str::limit($product->details, 60) }}
                                </td>

                                <!-- SINGLE IMAGE DISPLAY with conditional rendering -->
                                <td>
                                    @if($product->image)
                                        <!-- Show product image (70px width) if image path exists -->
                                        <img src="{{ asset($product->image) }}" width="70" 
                                             class="rounded shadow-sm border">
                                    @else
                                        <!-- Fallback text when no image available -->
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>

                                <!-- Simple text fields for product attributes -->
                                <td>{{ $product->size }}</td>
                                <td>{{ $product->color }}</td>
                                <td>{{ $product->category }}</td>

                                <!-- Formatted price with Indian Rupee symbol and green color -->
                                <td class="fw-bold text-success">
                                    ₹{{ number_format($product->price) }}
                                </td>

                                <!-- Action buttons column (Edit & Delete) - centered -->
                                <td class="text-center">
                                    <!-- Edit button linking to edit form with route model binding -->
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="btn btn-warning btn-sm me-1">✏ Edit</a>

                                    <!-- Delete form using POST method with DELETE spoofing -->
                                    <form action="{{ route('products.destroy', $product) }}"
                                          method="POST" class="d-inline">
                                        @csrf  <!-- CSRF protection token -->
                                        @method('DELETE')  <!-- Laravel method spoofing for DELETE -->
                                        <!-- Delete button with JavaScript confirmation dialog -->
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this product?')">
                                            🗑 Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <!-- Empty state row when no products exist in database -->
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
