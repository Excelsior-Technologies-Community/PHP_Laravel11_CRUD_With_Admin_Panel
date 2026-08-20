@extends('layouts.app')

@section('content')

<style>
    .product-page {
        background: #f6f8fb;
        min-height: calc(100vh - 70px);
    }

    .product-header {
        background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
        color: #fff;
        border-radius: 20px;
        padding: 28px 30px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .10);
    }

    .product-header .breadcrumb-text {
        color: rgba(255, 255, 255, .65);
        font-size: .85rem;
    }

    .product-header h2 {
        letter-spacing: -.5px;
    }

    .modern-card {
        background: #fff;
        border: 1px solid #edf0f4;
        border-radius: 18px;
        box-shadow: 0 8px 28px rgba(15, 23, 42, .06);
    }

    .image-card {
        position: relative;
        overflow: hidden;
    }

    .product-image-wrapper {
        height: 430px;
        background:
            radial-gradient(circle at 20% 20%, rgba(59, 130, 246, .08), transparent 35%),
            radial-gradient(circle at 80% 80%, rgba(99, 102, 241, .08), transparent 35%),
            #f8fafc;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 25px;
        transition: transform .35s ease;
    }

    .product-image:hover {
        transform: scale(1.04);
    }

    .no-image {
        width: 105px;
        height: 105px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        box-shadow: 0 10px 25px rgba(15, 23, 42, .08);
    }

    .product-id {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        border-radius: 8px;
        background: #f1f5f9;
        color: #64748b;
        font-size: .8rem;
        font-weight: 600;
    }

    .product-title {
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        font-weight: 800;
        letter-spacing: -.8px;
        color: #111827;
    }

    .category-text {
        color: #64748b;
        font-size: .95rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 13px;
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 700;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-inactive {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .price-box {
        background: linear-gradient(135deg, #eff6ff, #f8fafc);
        border: 1px solid #dbeafe;
        border-radius: 16px;
        padding: 20px;
    }

    .price-label {
        color: #64748b;
        font-size: .8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .price {
        color: #2563eb;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -.7px;
    }

    .info-box {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 16px;
        height: 100%;
        transition: all .2s ease;
    }

    .info-box:hover {
        border-color: #bfdbfe;
        box-shadow: 0 6px 18px rgba(37, 99, 235, .07);
        transform: translateY(-2px);
    }

    .info-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
        font-size: 1.1rem;
        margin-bottom: 12px;
    }

    .info-label {
        color: #94a3b8;
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .info-value {
        color: #1e293b;
        font-size: .95rem;
        font-weight: 700;
    }

    .stock-progress {
        height: 7px;
        border-radius: 20px;
        background: #e2e8f0;
        overflow: hidden;
        margin-top: 10px;
    }

    .stock-progress-bar {
        height: 100%;
        border-radius: 20px;
        background: linear-gradient(90deg, #22c55e, #16a34a);
    }

    .description-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 18px;
        color: #64748b;
        line-height: 1.8;
    }

    .section-title {
        color: #111827;
        font-size: 1rem;
        font-weight: 800;
        margin-bottom: 16px;
    }

    .meta-item {
        padding: 14px 16px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #edf0f4;
    }

    .meta-label {
        color: #94a3b8;
        font-size: .75rem;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .meta-value {
        color: #334155;
        font-weight: 700;
        font-size: .9rem;
    }

    .action-card {
        background: linear-gradient(135deg, #ffffff, #f8fafc);
    }

    .btn-modern {
        border-radius: 10px;
        padding: 10px 17px;
        font-weight: 600;
    }

    .btn-primary-modern {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    .btn-primary-modern:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
        color: #fff;
    }

    .btn-danger-modern {
        border: 1px solid #fecaca;
        color: #dc2626;
        background: #fff;
    }

    .btn-danger-modern:hover {
        background: #fef2f2;
        color: #b91c1c;
    }

    .top-action {
        border-radius: 10px;
        font-weight: 600;
        padding: 9px 15px;
    }

    @media (max-width: 991px) {
        .product-image-wrapper {
            height: 350px;
        }

        .product-header {
            padding: 22px;
        }
    }

    @media (max-width: 576px) {
        .product-header {
            border-radius: 14px;
        }

        .product-image-wrapper {
            height: 280px;
        }

        .price {
            font-size: 1.7rem;
        }
    }
</style>


<div class="product-page py-4">

    <div class="container-fluid">


        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="product-header mb-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>

                    <div class="breadcrumb-text mb-2">
                        Products / Details
                    </div>

                    <div class="d-flex align-items-center gap-2">

                        <span style="font-size: 1.7rem;">
                            📦
                        </span>

                        <h2 class="fw-bold mb-0">
                            Product Details
                        </h2>

                    </div>

                    <p class="mb-0 mt-2 text-white-50">
                        View complete information and manage this product.
                    </p>

                </div>


                <div class="d-flex flex-wrap gap-2">

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-light top-action">
                        ← Products
                    </a>

                    <a
                        href="{{ route('products.edit', $product) }}"
                        class="btn btn-primary top-action">
                        ✏️ Edit Product
                    </a>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- MAIN CONTENT --}}
        {{-- ========================================================= --}}

        <div class="row g-4">


            {{-- ===================================================== --}}
            {{-- LEFT: IMAGE --}}
            {{-- ===================================================== --}}

            <div class="col-xl-5 col-lg-5">

                <div class="modern-card image-card h-100">

                    <div class="p-3 p-md-4">

                        <div class="product-image-wrapper">

                            @if($product->image)

                            <img
                                src="{{ asset($product->image) }}"
                                alt="{{ $product->name }}"
                                class="product-image">

                            @else

                            <div class="text-center">

                                <div class="no-image mx-auto mb-3">
                                    📦
                                </div>

                                <h6 class="fw-bold text-dark mb-1">
                                    No Image Available
                                </h6>

                                <p class="text-muted small mb-0">
                                    This product does not have an image.
                                </p>

                            </div>

                            @endif

                        </div>


                        {{-- IMAGE FOOTER --}}

                        <div class="d-flex justify-content-between align-items-center mt-3 px-1">

                            <div>

                                <small class="text-muted">
                                    Product ID
                                </small>

                                <div class="fw-bold">
                                    #{{ $product->id }}
                                </div>

                            </div>


                            <div>

                                @if($product->is_active)

                                <span class="status-badge status-active">
                                    <span class="status-dot"></span>
                                    Active
                                </span>

                                @else

                                <span class="status-badge status-inactive">
                                    <span class="status-dot"></span>
                                    Inactive
                                </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{-- ===================================================== --}}
            {{-- RIGHT: PRODUCT INFORMATION --}}
            {{-- ===================================================== --}}

            <div class="col-xl-7 col-lg-7">

                <div class="modern-card h-100">

                    <div class="p-4 p-md-5">


                        {{-- PRODUCT TITLE --}}

                        <div class="d-flex justify-content-between align-items-start gap-3 mb-4">

                            <div>

                                <span class="product-id mb-3">
                                    Product #{{ $product->id }}
                                </span>

                                <h1 class="product-title mt-2 mb-2">
                                    {{ $product->name }}
                                </h1>

                                <div class="category-text">
                                    🗂️
                                    {{ $product->category ?? 'Uncategorized' }}
                                </div>

                            </div>

                        </div>



                        {{-- PRICE --}}

                        <div class="price-box mb-4">

                            <div class="price-label">
                                Product Price
                            </div>

                            <div class="price mt-1">
                                ₹{{ number_format($product->price, 2) }}
                            </div>

                        </div>



                        {{-- INFORMATION --}}

                        <div class="section-title">
                            Product Information
                        </div>


                        <div class="row g-3 mb-4">


                            {{-- CATEGORY --}}

                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-icon">
                                        🗂️
                                    </div>

                                    <div class="info-label">
                                        Category
                                    </div>

                                    <div class="info-value">
                                        {{ $product->category ?? '-' }}
                                    </div>

                                </div>

                            </div>



                            {{-- SIZE --}}

                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-icon">
                                        📐
                                    </div>

                                    <div class="info-label">
                                        Size
                                    </div>

                                    <div class="info-value">
                                        {{ $product->size ?? '-' }}
                                    </div>

                                </div>

                            </div>



                            {{-- COLOR --}}

                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-icon">
                                        🎨
                                    </div>

                                    <div class="info-label">
                                        Color
                                    </div>

                                    <div class="info-value">
                                        {{ $product->color ?? '-' }}
                                    </div>

                                </div>

                            </div>



                            {{-- STOCK --}}

                            <div class="col-md-6">

                                <div class="info-box">

                                    <div class="info-icon">
                                        📦
                                    </div>

                                    <div class="info-label">
                                        Stock
                                    </div>

                                    @if($product->stock > 0)

                                    <div class="info-value text-success">

                                        {{ number_format($product->stock) }}
                                        units available

                                    </div>

                                    @php
                                    $stockPercentage = min(
                                    ($product->stock / 100) * 100,
                                    100
                                    );
                                    @endphp

                                    <div class="stock-progress">

                                        <div
                                            class="stock-progress-bar"
                                            style="width: {{ $stockPercentage }}%;"></div>

                                    </div>

                                    @else

                                    <div class="info-value text-danger">
                                        Out of Stock
                                    </div>

                                    @endif

                                </div>

                            </div>

                        </div>



                        {{-- DESCRIPTION --}}

                        <div class="section-title">
                            Product Description
                        </div>

                        <div class="description-box mb-4">

                            @if($product->details)

                            {{ $product->details }}

                            @else

                            <span class="fst-italic">
                                No description available for this product.
                            </span>

                            @endif

                        </div>



                        {{-- RECORD INFORMATION --}}

                        <div class="section-title">
                            Record Information
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <div class="meta-item">

                                    <div class="meta-label">
                                        CREATED AT
                                    </div>

                                    <div class="meta-value">
                                        {{ $product->created_at?->format('d M Y, h:i A') ?? '-' }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="meta-item">

                                    <div class="meta-label">
                                        LAST UPDATED
                                    </div>

                                    <div class="meta-value">
                                        {{ $product->updated_at?->format('d M Y, h:i A') ?? '-' }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- ACTION CARD --}}
        {{-- ========================================================= --}}

        <div class="modern-card action-card mt-4">

            <div class="p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div>

                        <div class="d-flex align-items-center gap-2">

                            <span style="font-size: 1.4rem;">
                                ⚙️
                            </span>

                            <h5 class="fw-bold mb-0">
                                Manage Product
                            </h5>

                        </div>

                        <p class="text-muted mb-0 mt-1">
                            Update product information or move it to trash.
                        </p>

                    </div>


                    <div class="d-flex flex-wrap gap-2">

                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-outline-secondary btn-modern">
                            ← Back
                        </a>


                        <a
                            href="{{ route('products.edit', $product) }}"
                            class="btn btn-primary-modern btn-modern">
                            ✏️ Edit Product
                        </a>


                        <form
                            action="{{ route('products.destroy', $product) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Are you sure you want to move this product to trash?')">

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger-modern btn-modern">
                                🗑️ Move to Trash
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection