<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CustomerProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                )
                ->orWhere(
                    'details',
                    'like',
                    '%' . $request->search . '%'
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $query->where(
                'category',
                $request->category
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Minimum Price
        |--------------------------------------------------------------------------
        */

        if ($request->filled('price_min')) {

            $query->where(
                'price',
                '>=',
                $request->price_min
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Maximum Price
        |--------------------------------------------------------------------------
        */

        if ($request->filled('price_max')) {

            $query->where(
                'price',
                '<=',
                $request->price_max
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Stock Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('stock_status')) {

            if ($request->stock_status === 'in_stock') {

                $query->where('stock', '>', 0);

            } elseif ($request->stock_status === 'out_of_stock') {

                $query->where('stock', '<=', 0);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Active / Inactive Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if ($request->status === 'active') {

                $query->where('is_active', true);

            } elseif ($request->status === 'inactive') {

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

                $query->orderBy(
                    'price',
                    'asc'
                );

                break;


            case 'price_desc':

                $query->orderBy(
                    'price',
                    'desc'
                );

                break;


            case 'name_asc':

                $query->orderBy(
                    'name',
                    'asc'
                );

                break;


            case 'name_desc':

                $query->orderBy(
                    'name',
                    'desc'
                );

                break;


            default:

                $query->latest();

                break;

        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $products = $query->paginate(12);


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Product::distinct()
            ->pluck('category')
            ->sort();


        /*
        |--------------------------------------------------------------------------
        | AJAX Response
        |--------------------------------------------------------------------------
        */

        if ($request->ajax() || $request->wantsJson()) {

            $html = view(
                'customer._products',
                compact('products')
            )->render();

            $pagination = $products
                ->withQueryString()
                ->links('pagination::bootstrap-5')
                ->toHtml();

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
                'count' => $products->total(),
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Normal Page Response
        |--------------------------------------------------------------------------
        */

        return view(
            'customer.index',
            compact(
                'products',
                'categories'
            )
        );
    }
}