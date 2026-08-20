@extends('layouts.admin')

@section('content')

<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                🗑️ Product Trash
            </h2>

            <p class="text-muted mb-0">
                Restore deleted products or permanently remove them.
            </p>

        </div>

        <a
            href="{{ route('products.index') }}"
            class="btn btn-primary">
            ← Products
        </a>

    </div>


    {{-- Success --}}
    @if(session('success'))

    <div class="alert alert-success shadow-sm">
        {{ session('success') }}
    </div>

    @endif


    {{-- Trash Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>

                            <th>Product</th>

                            <th>Image</th>

                            <th>Category</th>

                            <th>Price</th>

                            <th>Deleted At</th>

                            <th class="text-center">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($products as $product)

                        <tr>

                            <td>
                                #{{ $product->id }}
                            </td>


                            <td class="fw-semibold">
                                {{ $product->name }}
                            </td>


                            <td>

                                @if($product->image)

                                <img
                                    src="{{ asset($product->image) }}"
                                    width="60"
                                    height="60"
                                    class="rounded border"
                                    style="object-fit: cover;">

                                @else

                                <span class="text-muted">
                                    No Image
                                </span>

                                @endif

                            </td>


                            <td>
                                {{ $product->category }}
                            </td>


                            <td class="fw-bold text-success">
                                ₹{{ number_format($product->price, 2) }}
                            </td>


                            <td>

                                {{ $product->deleted_at?->format(
                                        'd M Y, h:i A'
                                    ) }}

                            </td>


                            <td class="text-center">

                                {{-- Restore --}}
                                <form
                                    action="{{ route(
                                            'products.restore',
                                            $product->id
                                        ) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-success btn-sm">
                                        ♻ Restore
                                    </button>

                                </form>


                                {{-- Permanent Delete --}}
                                <form
                                    action="{{ route(
                                            'products.force-delete',
                                            $product->id
                                        ) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm(
                                                'This will permanently delete the product. Continue?'
                                            )">
                                        ❌ Permanent Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5 text-muted">

                                <h5>
                                    🗑️ Trash is empty
                                </h5>

                                <p class="mb-0">
                                    No deleted products found.
                                </p>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Pagination --}}
    <div class="mt-4">

        {{ $products->links() }}

    </div>

</div>

@endsection