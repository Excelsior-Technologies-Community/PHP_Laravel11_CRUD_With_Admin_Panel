<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CustomerProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('details', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

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
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $categories = Product::distinct()->pluck('category')->sort();

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('customer._products', compact('products'))->render();
            $pagination = $products->withQueryString()->links('pagination::bootstrap-5')->toHtml();
            return response()->json(['html' => $html, 'pagination' => $pagination, 'count' => $products->total()]);
        }

        return view('customer.index', compact('products', 'categories'));
    }
}
