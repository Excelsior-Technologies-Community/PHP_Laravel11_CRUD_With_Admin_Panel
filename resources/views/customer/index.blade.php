@extends('layouts.customer')

@section('content')

<style>
    .product-card {
        height: 500px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-img {
        height: 300px;
        width: 100%;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .product-details {
        height: 160px;
        overflow: hidden;
    }

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

    #productGrid {
        transition: opacity 0.2s ease;
    }

    #productGrid.fading {
        opacity: 0.5;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    #paginationContainer {
        display: flex;
        justify-content: center;
    }

    #paginationContainer nav {
        width: 100%;
    }

    #paginationContainer .pagination {
        justify-content: center;
        margin-bottom: 0;
    }

    #paginationContainer .d-none.sm\:flex-1 {
        justify-content: center !important;
    }
</style>

<form class="filter-form mb-4 p-3 bg-white rounded shadow-sm" onsubmit="return false;">
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="searchInput">Search</label>
            <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
        </div>
        <div class="col-md-2">
            <label for="categoryFilter">Category</label>
            <select id="categoryFilter" class="form-select">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="priceMin">Min Price (₹)</label>
            <input type="number" id="priceMin" class="form-control" placeholder="Min" min="0" step="1">
        </div>
        <div class="col-md-2">
            <label for="priceMax">Max Price (₹)</label>
            <input type="number" id="priceMax" class="form-control" placeholder="Max" min="0" step="1">
        </div>
        <div class="col-md-3">
            <label for="sortSelect">Sort By</label>
            <select id="sortSelect" class="form-select">
                <option value="latest">Latest</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
                <option value="name_asc">Name: A to Z</option>
                <option value="name_desc">Name: Z to A</option>
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12 text-end">
            <button type="button" id="clearFilters" class="btn btn-outline-secondary btn-sm">Clear Filters</button>
        </div>
    </div>
</form>

<div class="d-flex justify-content-between align-items-center mb-3">
    <span id="resultCount" class="text-muted small"></span>
    <div id="loadingSpinner" class="d-none">
        <span class="spinner-border spinner-border-sm text-primary"></span> Loading...
    </div>
</div>

<div class="row" id="productGrid">
    @include('customer._products')
</div>

<div id="paginationContainer">
    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
</div>

<script>
(function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const priceMin = document.getElementById('priceMin');
    const priceMax = document.getElementById('priceMax');
    const sortSelect = document.getElementById('sortSelect');
    const clearFilters = document.getElementById('clearFilters');
    const productGrid = document.getElementById('productGrid');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const resultCount = document.getElementById('resultCount');

    let debounceTimer = null;

    function fetchProducts(pageUrl) {
        const params = new URLSearchParams();

        const search = searchInput.value.trim();
        if (search) params.set('search', search);

        const category = categoryFilter.value;
        if (category) params.set('category', category);

        const min = priceMin.value;
        if (min) params.set('price_min', min);

        const max = priceMax.value;
        if (max) params.set('price_max', max);

        const sort = sortSelect.value;
        if (sort && sort !== 'latest') params.set('sort', sort);

        if (pageUrl) {
            const urlParams = new URLSearchParams(pageUrl.split('?')[1]);
            urlParams.forEach((val, key) => params.set(key, val));
        }

        productGrid.classList.add('fading');
        loadingSpinner.classList.remove('d-none');

        fetch('?' + params.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            productGrid.innerHTML = data.html;
            document.getElementById('paginationContainer').innerHTML = data.pagination;
            resultCount.textContent = data.count + ' product(s) found';
            productGrid.classList.remove('fading');
            loadingSpinner.classList.add('d-none');

            document.querySelectorAll('#paginationContainer a').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchProducts(this.getAttribute('href'));
                });
            });
        })
        .catch(function(error) {
            console.error('Error fetching products:', error);
            productGrid.classList.remove('fading');
            loadingSpinner.classList.add('d-none');
        });
    }

    function debounceFetch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchProducts, 300);
    }

    searchInput.addEventListener('input', debounceFetch);
    categoryFilter.addEventListener('change', fetchProducts);
    priceMin.addEventListener('input', debounceFetch);
    priceMax.addEventListener('input', debounceFetch);
    sortSelect.addEventListener('change', fetchProducts);

    clearFilters.addEventListener('click', function() {
        searchInput.value = '';
        categoryFilter.value = '';
        priceMin.value = '';
        priceMax.value = '';
        sortSelect.value = 'latest';
        fetchProducts();
    });
})();
</script>

@endsection
