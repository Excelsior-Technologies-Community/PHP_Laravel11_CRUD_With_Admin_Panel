<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW ALL PRODUCTS
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Product::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('details', 'like', '%' . $search . '%');
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        /*
        |--------------------------------------------------------------------------
        | Minimum Price
        |--------------------------------------------------------------------------
        */
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        /*
        |--------------------------------------------------------------------------
        | Maximum Price
        |--------------------------------------------------------------------------
        */
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        /*
        |--------------------------------------------------------------------------
        | Stock Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('stock_status')) {

            if ($request->stock_status === 'in_stock') {
                $query->where('stock', '>', 0);
            }

            if ($request->stock_status === 'out_of_stock') {
                $query->where('stock', 0);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {

            if ($request->status === 'active') {
                $query->where('is_active', true);
            }

            if ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */
        $sort = $request->input('sort', 'latest');

        switch ($sort) {

            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;

            case 'stock_asc':
                $query->orderBy('stock', 'asc');
                break;

            case 'stock_desc':
                $query->orderBy('stock', 'desc');
                break;

            default:
                $query->latest();
                break;
        }

        $products = $query
            ->paginate(10)
            ->withQueryString();

        $categories = Product::distinct()
            ->pluck('category')
            ->sort();

        return view(
            'products.index',
            compact('products', 'categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('products.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'details' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'stock' => 'required|integer|min:0',

            'size' => 'required|string|max:255',

            'color' => 'required|string|max:255',

            'category' => 'required|string|max:255',

            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',

            'is_active' => 'nullable|boolean',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(
            public_path('images'),
            $imageName
        );

        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */

        Product::create([
            'name' => $request->name,

            'details' => $request->details,

            'price' => $request->price,

            'stock' => $request->stock,

            'size' => $request->size,

            'color' => $request->color,

            'category' => $request->category,

            'image' => 'images/' . $imageName,

            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT PRODUCT
    |--------------------------------------------------------------------------
    */
    public function edit(Product $product)
    {
        return view(
            'products.edit',
            compact('product')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'details' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'stock' => 'required|integer|min:0',

            'size' => 'required|string|max:255',

            'color' => 'required|string|max:255',

            'category' => 'required|string|max:255',

            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'is_active' => 'nullable|boolean',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Keep Existing Image
        |--------------------------------------------------------------------------
        */

        $imageName = $product->image;

        /*
        |--------------------------------------------------------------------------
        | Replace Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            if (
                $product->image &&
                file_exists(public_path($product->image))
            ) {
                unlink(public_path($product->image));
            }

            $newImageName =
                time() . '.' .
                $request->image->extension();

            $request->image->move(
                public_path('images'),
                $newImageName
            );

            $imageName = 'images/' . $newImageName;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update([
            'name' => $request->name,

            'details' => $request->details,

            'price' => $request->price,

            'stock' => $request->stock,

            'size' => $request->size,

            'color' => $request->color,

            'category' => $request->category,

            'image' => $imageName,

            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function destroy(Product $product)
    {
        if (
            $product->image &&
            file_exists(public_path($product->image))
        ) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}