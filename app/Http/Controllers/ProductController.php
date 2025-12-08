<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /*---------------------------------------
        SHOW ALL PRODUCTS - Displays complete list of products
        Fetches products ordered by latest created first
    ----------------------------------------*/
    public function index()
    {
        // Get all products sorted by creation date (newest first)
        $products = Product::latest()->get();
        // Return products.index view with products data
        return view('products.index', compact('products'));
    }

    /*---------------------------------------
        SHOW CREATE FORM - Displays form to add new product
        Renders empty create form
    ----------------------------------------*/
    public function create()
    {
        // Simply return the create form view (no data needed)
        return view('products.create');
    }

    /*---------------------------------------
        STORE PRODUCT - Saves new product to database with image
        Handles form validation, image upload, and database creation
    ----------------------------------------*/
    public function store(Request $request)
    {
        // Validate all required form inputs with specific rules
        $request->validate([
            'name'      => 'required|string',        // Product name is mandatory
            'details'   => 'nullable|string',        // Details optional
            'price'     => 'required|numeric',       // Price must be a number
            'size'      => 'required|string',        // Size is mandatory
            'color'     => 'required|string',        // Color is mandatory
            'category'  => 'required|string',        // Category is mandatory
            'image'     => 'required|image|mimes:jpg,jpeg,png', // Image mandatory, specific formats
        ]);

        // Generate unique filename using current timestamp and move to public/images
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Create new product record in database with image path
        Product::create([
            'name'      => $request->name,
            'details'   => $request->details,
            'price'     => $request->price,
            'size'      => $request->size,
            'color'     => $request->color,
            'category'  => $request->category,
            'image'     => 'images/' . $imageName,   // Store relative path in DB
        ]);

        // Redirect to products list with success message
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    /*---------------------------------------
        SHOW EDIT FORM - Displays form with existing product data
        Loads specific product for editing
    ----------------------------------------*/
    public function edit(Product $product)
    {
        // Route model binding automatically fetches product by ID
        // Pass product data to edit view for pre-filling form
        return view('products.edit', compact('product'));
    }

    /*---------------------------------------
        UPDATE PRODUCT - Updates existing product data
        Handles form validation, old image deletion, new image upload
    ----------------------------------------*/
    public function update(Request $request, Product $product)
    {
        // Same validation rules as store (except image is now optional)
        $request->validate([
            'name'      => 'required|string',
            'details'   => 'nullable|string',
            'price'     => 'required|numeric',
            'size'      => 'required|string',
            'color'     => 'required|string',
            'category'  => 'required|string',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png', // Image now optional for updates
        ]);

        // Keep existing image path unless new one uploaded
        $imageName = $product->image;

        // If new image uploaded, replace old one
        if ($request->hasFile('image')) {
            // Delete old image file from server if it exists
            if (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Upload new image with unique name
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            // Update with new image path
            $imageName = 'images/' . $imageName;
        }

        // Update all product fields in database
        $product->update([
            'name'      => $request->name,
            'details'   => $request->details,
            'price'     => $request->price,
            'size'      => $request->size,
            'color'     => $request->color,
            'category'  => $request->category,
            'image'     => $imageName,
        ]);

        // Redirect to products list with success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /*---------------------------------------
        DELETE PRODUCT - Permanently removes product
        TODO: Add image deletion logic here (missing in current code)
    ----------------------------------------*/
    public function destroy(Product $product)
    {
        // TODO: Delete associated image file before deleting product
        // if (file_exists(public_path($product->image))) {
        //     unlink(public_path($product->image));
        // }

        // Permanently delete product from database
        $product->delete();

        // Redirect to products list with success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
