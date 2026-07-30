@if($products->isEmpty())
    <div class="col-12">
        <div class="text-center py-5 text-muted">
            <h5>No products found.</h5>
        </div>
    </div>
@else
    @foreach($products as $product)
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0 product-card">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" class="product-img">
                @else
                    <img src="https://via.placeholder.com/300x220" class="product-img">
                @endif
                <div class="card-body product-details">
                    <h5 class="card-title fw-bold">
                        <strong>Name:</strong> {{ $product->name }}
                    </h5>
                    <p class="text-muted small">
                        <strong>Details:</strong>
                        {{ Str::limit($product->details, 70) }}
                    </p>
                    <ul class="list-unstyled mb-1">
                        <li><strong>Category:</strong> {{ $product->category }}</li>
                        <li><strong>Size:</strong> {{ $product->size }}</li>
                        <li><strong>Color:</strong> {{ $product->color }}</li>
                        <li><strong>Price:</strong> ₹{{ number_format($product->price) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
@endif