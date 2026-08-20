@extends('layouts.app')

@section('content')

<style>
    .analytics-page {
        background: #f6f8fb;
        min-height: calc(100vh - 70px);
    }

    .analytics-header {
        background: linear-gradient(135deg, #111827, #1f2937);
        border-radius: 20px;
        padding: 30px;
        color: #fff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
    }

    .analytics-header h2 {
        font-size: 28px;
        letter-spacing: -0.5px;
    }

    .analytics-header p {
        color: rgba(255, 255, 255, 0.7);
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        border: 0;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        transition: all 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.10);
    }

    .stat-card::after {
        content: "";
        position: absolute;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        right: -35px;
        top: -35px;
        background: rgba(255, 255, 255, 0.08);
    }

    .stat-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 27px;
        flex-shrink: 0;
    }

    .icon-blue {
        background: #e8f1ff;
    }

    .icon-purple {
        background: #f0eaff;
    }

    .icon-orange {
        background: #fff1df;
    }

    .icon-green {
        background: #e4f8ed;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .stat-value {
        font-size: 27px;
        font-weight: 800;
        color: #111827;
        margin-top: 5px;
    }

    .analytics-card {
        border: 0;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .analytics-card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #eef0f4;
        background: #fff;
    }

    .analytics-card-header h5 {
        font-weight: 800;
        color: #111827;
        margin-bottom: 4px;
    }

    .analytics-card-header small {
        color: #8a94a6;
    }

    .category-row {
        transition: background .2s ease;
    }

    .category-row:hover {
        background: #f8fafc;
    }

    .category-number {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #475569;
    }

    .category-name {
        font-weight: 700;
        color: #1f2937;
    }

    .category-count {
        min-width: 48px;
        padding: 7px 12px;
        border-radius: 30px;
        background: #eef4ff;
        color: #2563eb;
        font-weight: 700;
        display: inline-block;
        text-align: center;
    }

    .progress {
        background: #edf0f4;
        border-radius: 50px;
        overflow: hidden;
    }

    .progress-bar {
        border-radius: 50px;
        background: linear-gradient(90deg, #2563eb, #6366f1);
    }

    .percentage-text {
        min-width: 48px;
        text-align: right;
        font-weight: 600;
        color: #64748b;
    }

    .empty-state {
        padding: 60px 20px;
    }

    .empty-icon {
        width: 75px;
        height: 75px;
        margin: 0 auto 15px;
        border-radius: 20px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 35px;
    }

    .btn-modern {
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 600;
        transition: .2s ease;
    }

    .btn-modern:hover {
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {

        .analytics-header {
            padding: 22px;
        }

        .analytics-header h2 {
            font-size: 23px;
        }

        .header-actions {
            margin-top: 18px;
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
        }

        .stat-value {
            font-size: 24px;
        }

        .table th,
        .table td {
            white-space: nowrap;
        }
    }
</style>


<div class="analytics-page">

    <div class="container-fluid py-4">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="analytics-header mb-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                <div>

                    <div class="d-flex align-items-center gap-2 mb-2">

                        <span style="font-size: 28px;">
                            📊
                        </span>

                        <h2 class="fw-bold mb-0">
                            Product Analytics
                        </h2>

                    </div>

                    <p class="mb-0">
                        Track your inventory, products, categories and
                        overall stock performance.
                    </p>

                </div>


                <div class="d-flex gap-2 header-actions">

                    <a
                        href="{{ route('products.index') }}"
                        class="btn btn-light btn-modern">

                        ← Products

                    </a>

                    <a
                        href="{{ route('products.export') }}"
                        class="btn btn-success btn-modern">

                        📥 Export CSV

                    </a>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- STATISTICS --}}
        {{-- ========================================================= --}}

        <div class="row g-4 mb-4">

            {{-- TOTAL PRODUCTS --}}
            <div class="col-xl-3 col-md-6">

                <div class="stat-card h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-label">
                                    Total Products
                                </div>

                                <div class="stat-value">

                                    {{ number_format($totalProducts) }}

                                </div>

                                <small class="text-muted">
                                    All active inventory
                                </small>

                            </div>

                            <div class="stat-icon icon-blue">
                                📦
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TOTAL CATEGORIES --}}
            <div class="col-xl-3 col-md-6">

                <div class="stat-card h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-label">
                                    Categories
                                </div>

                                <div class="stat-value">

                                    {{ number_format($totalCategories) }}

                                </div>

                                <small class="text-muted">
                                    Product categories
                                </small>

                            </div>

                            <div class="stat-icon icon-purple">
                                🗂️
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TOTAL STOCK --}}
            <div class="col-xl-3 col-md-6">

                <div class="stat-card h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-label">
                                    Total Stock
                                </div>

                                <div class="stat-value">

                                    {{ number_format($totalStock) }}

                                </div>

                                <small class="text-muted">
                                    Units available
                                </small>

                            </div>

                            <div class="stat-icon icon-orange">
                                📊
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- INVENTORY VALUE --}}
            <div class="col-xl-3 col-md-6">

                <div class="stat-card h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-label">
                                    Inventory Value
                                </div>

                                <div class="stat-value">

                                    ₹{{ number_format($totalValue, 2) }}

                                </div>

                                <small class="text-muted">
                                    Total stock value
                                </small>

                            </div>

                            <div class="stat-icon icon-green">
                                💰
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- CATEGORY ANALYTICS --}}
        {{-- ========================================================= --}}

        <div class="analytics-card">

            <div class="analytics-card-header">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                    <div>

                        <h5>
                            Products by Category
                        </h5>

                        <small>
                            Category-wise product distribution
                        </small>

                    </div>


                    <div class="mt-2 mt-md-0">

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">

                            {{ $productsByCategory->count() }}
                            Categories

                        </span>

                    </div>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4 py-3">
                                #
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Products
                            </th>

                            <th style="min-width: 280px;">
                                Distribution
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($productsByCategory as $index => $category)

                        @php

                        $percentage =
                        $totalProducts > 0
                        ? ($category->total / $totalProducts) * 100
                        : 0;

                        @endphp


                        <tr class="category-row">

                            {{-- NUMBER --}}
                            <td class="px-4">

                                <div class="category-number">

                                    {{ $index + 1 }}

                                </div>

                            </td>


                            {{-- CATEGORY --}}
                            <td>

                                <div class="category-name">

                                    {{ $category->category }}

                                </div>

                            </td>


                            {{-- COUNT --}}
                            <td>

                                <span class="category-count">

                                    {{ number_format($category->total) }}

                                </span>

                            </td>


                            {{-- PROGRESS --}}
                            <td>

                                <div class="d-flex align-items-center gap-3">

                                    <div
                                        class="progress flex-grow-1"
                                        style="height: 9px;">

                                        <div
                                            class="progress-bar"
                                            role="progressbar"
                                            style="width: {{ min($percentage, 100) }}%;">

                                        </div>

                                    </div>


                                    <span class="percentage-text">

                                        {{ number_format($percentage, 1) }}%

                                    </span>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="4"
                                class="text-center">

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        📦
                                    </div>

                                    <h5 class="fw-bold">
                                        No Category Data
                                    </h5>

                                    <p class="text-muted mb-0">
                                        There are currently no products
                                        available for analytics.
                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FOOTER INFORMATION --}}
        {{-- ========================================================= --}}

        <div class="row mt-4">

            <div class="col-12">

                <div class="analytics-card">

                    <div class="card-body p-4">

                        <div class="row align-items-center">

                            <div class="col-md-8">

                                <h6 class="fw-bold mb-1">
                                    📈 Inventory Overview
                                </h6>

                                <p class="text-muted mb-0">

                                    Your inventory currently contains

                                    <strong>
                                        {{ number_format($totalStock) }}
                                    </strong>

                                    units across

                                    <strong>
                                        {{ number_format($totalCategories) }}
                                    </strong>

                                    categories.

                                </p>

                            </div>


                            <div class="col-md-4 text-md-end mt-3 mt-md-0">

                                <a
                                    href="{{ route('products.index') }}"
                                    class="btn btn-primary btn-modern">

                                    Manage Products →

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection