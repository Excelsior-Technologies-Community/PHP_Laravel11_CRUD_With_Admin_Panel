<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Basic Statistics
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $activeProducts = Product::where(
            'is_active',
            true
        )->count();

        $inactiveProducts = Product::where(
            'is_active',
            false
        )->count();

        $inStockProducts = Product::where(
            'stock',
            '>',
            0
        )->count();

        $outOfStockProducts = Product::where(
            'stock',
            '<=',
            0
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Trash
        |--------------------------------------------------------------------------
        */

        $trashedProducts = Product::onlyTrashed()->count();


        /*
        |--------------------------------------------------------------------------
        | Total Inventory
        |--------------------------------------------------------------------------
        */

        $totalStock = Product::sum('stock');


        /*
        |--------------------------------------------------------------------------
        | Inventory Value
        |--------------------------------------------------------------------------
        */

        $inventoryValue = Product::query()
            ->selectRaw(
                'COALESCE(SUM(price * stock), 0) as total'
            )
            ->value('total');


        /*
        |--------------------------------------------------------------------------
        | Average Product Price
        |--------------------------------------------------------------------------
        */

        $averagePrice = Product::avg('price');


        /*
        |--------------------------------------------------------------------------
        | Category Statistics
        |--------------------------------------------------------------------------
        */

        $categoryStats = Product::query()
            ->selectRaw(
                'category, COUNT(*) as total'
            )
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Latest Products
        |--------------------------------------------------------------------------
        */

        $latestProducts = Product::latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Low Stock Products
        |--------------------------------------------------------------------------
        */

        $lowStockProducts = Product::query()
            ->where('stock', '>', 0)
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(5)
            ->get();


        return view(
            'dashboard',
            compact(
                'totalProducts',
                'activeProducts',
                'inactiveProducts',
                'inStockProducts',
                'outOfStockProducts',
                'trashedProducts',
                'totalStock',
                'inventoryValue',
                'averagePrice',
                'categoryStats',
                'latestProducts',
                'lowStockProducts'
            )
        );
    }
}
