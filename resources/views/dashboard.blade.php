<x-app-layout>

    <x-slot name="header">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    📊 Admin Dashboard
                </h2>

                <p class="text-muted mb-0">
                    Product inventory and business overview.
                </p>

            </div>

            <a
                href="{{ route('products.index') }}"
                class="btn btn-primary">
                📦 Manage Products
            </a>

        </div>

    </x-slot>


    <div class="py-5">

        <div class="container-fluid px-4">


            {{-- Statistics Cards --}}
            <div class="row g-4 mb-4">


                {{-- Total Products --}}
                <div class="col-xl-3 col-md-6">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <p class="text-muted mb-1">
                                        Total Products
                                    </p>

                                    <h2 class="fw-bold mb-0">
                                        {{ $totalProducts }}
                                    </h2>

                                </div>

                                <div class="fs-1">
                                    📦
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Active --}}
                <div class="col-xl-3 col-md-6">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <p class="text-muted mb-1">
                                        Active Products
                                    </p>

                                    <h2 class="fw-bold text-success mb-0">
                                        {{ $activeProducts }}
                                    </h2>

                                </div>

                                <div class="fs-1">
                                    ✅
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Out of Stock --}}
                <div class="col-xl-3 col-md-6">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <p class="text-muted mb-1">
                                        Out of Stock
                                    </p>

                                    <h2 class="fw-bold text-danger mb-0">
                                        {{ $outOfStockProducts }}
                                    </h2>

                                </div>

                                <div class="fs-1">
                                    ⚠️
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Trash --}}
                <div class="col-xl-3 col-md-6">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <p class="text-muted mb-1">
                                        Trash
                                    </p>

                                    <h2 class="fw-bold text-danger mb-0">
                                        {{ $trashedProducts }}
                                    </h2>

                                </div>

                                <div class="fs-1">
                                    🗑️
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Inventory Stats --}}
            <div class="row g-4 mb-4">


                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <p class="text-muted mb-1">
                                Total Stock
                            </p>

                            <h3 class="fw-bold">
                                {{ number_format($totalStock) }}
                            </h3>

                            <small class="text-muted">
                                Total available units
                            </small>

                        </div>

                    </div>

                </div>


                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <p class="text-muted mb-1">
                                Inventory Value
                            </p>

                            <h3 class="fw-bold text-success">
                                ₹{{ number_format($inventoryValue, 2) }}
                            </h3>

                            <small class="text-muted">
                                Price × stock
                            </small>

                        </div>

                    </div>

                </div>


                <div class="col-lg-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-body">

                            <p class="text-muted mb-1">
                                Average Product Price
                            </p>

                            <h3 class="fw-bold">
                                ₹{{ number_format($averagePrice ?? 0, 2) }}
                            </h3>

                            <small class="text-muted">
                                Average selling price
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            <div class="row g-4">


                {{-- Category Analytics --}}
                <div class="col-lg-6">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white py-3">

                            <h5 class="fw-bold mb-0">
                                📊 Products by Category
                            </h5>

                        </div>

                        <div class="card-body">

                            @forelse($categoryStats as $category)

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <span class="fw-semibold">
                                    {{ $category->category }}
                                </span>

                                <span class="badge bg-primary">
                                    {{ $category->total }}
                                </span>

                            </div>

                            @empty

                            <p class="text-muted mb-0">
                                No category data available.
                            </p>

                            @endforelse

                        </div>

                    </div>

                </div>


                {{-- Low Stock --}}
                <div class="col-lg-6">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white py-3">

                            <h5 class="fw-bold mb-0">
                                ⚠️ Low Stock Products
                            </h5>

                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table table-hover mb-0">

                                    <thead>

                                        <tr>

                                            <th>
                                                Product
                                            </th>

                                            <th>
                                                Stock
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse($lowStockProducts as $product)

                                        <tr>

                                            <td>

                                                <a
                                                    href="{{ route(
                                                            'products.show',
                                                            $product
                                                        ) }}"
                                                    class="text-decoration-none fw-semibold">
                                                    {{ $product->name }}
                                                </a>

                                            </td>

                                            <td>

                                                <span class="badge bg-warning text-dark">

                                                    {{ $product->stock }}

                                                </span>

                                            </td>

                                        </tr>

                                        @empty

                                        <tr>

                                            <td
                                                colspan="2"
                                                class="text-center text-muted py-4">
                                                No low stock products.
                                            </td>

                                        </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Latest Products --}}
                <div class="col-12">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white py-3">

                            <div class="d-flex justify-content-between align-items-center">

                                <h5 class="fw-bold mb-0">
                                    🆕 Latest Products
                                </h5>

                                <a
                                    href="{{ route('products.index') }}"
                                    class="btn btn-sm btn-outline-primary">
                                    View All
                                </a>

                            </div>

                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table table-hover align-middle mb-0">

                                    <thead>

                                        <tr>

                                            <th>
                                                Product
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

                                            <th>
                                                Action
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse($latestProducts as $product)

                                        <tr>

                                            <td class="fw-semibold">
                                                {{ $product->name }}
                                            </td>

                                            <td>
                                                {{ $product->category }}
                                            </td>

                                            <td class="text-success fw-bold">
                                                ₹{{ number_format(
                                                        $product->price,
                                                        2
                                                    ) }}
                                            </td>

                                            <td>

                                                @if($product->stock > 0)

                                                <span class="badge bg-success">
                                                    {{ $product->stock }}
                                                </span>

                                                @else

                                                <span class="badge bg-danger">
                                                    Out of Stock
                                                </span>

                                                @endif

                                            </td>

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

                                            <td>

                                                <a
                                                    href="{{ route(
                                                            'products.show',
                                                            $product
                                                        ) }}"
                                                    class="btn btn-sm btn-info text-white">
                                                    👁 View
                                                </a>

                                            </td>

                                        </tr>

                                        @empty

                                        <tr>

                                            <td
                                                colspan="6"
                                                class="text-center text-muted py-4">
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

            </div>

        </div>

    </div>

</x-app-layout>