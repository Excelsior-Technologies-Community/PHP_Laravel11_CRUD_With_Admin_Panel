<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'details',
                        'like',
                        '%' . $search . '%'
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

                $query->where(
                    'stock',
                    '>',
                    0
                );
            }

            if ($request->stock_status === 'out_of_stock') {

                $query->where(
                    'stock',
                    '<=',
                    0
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if ($request->status === 'active') {

                $query->where(
                    'is_active',
                    true
                );
            }

            if ($request->status === 'inactive') {

                $query->where(
                    'is_active',
                    false
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $sort = $request->input(
            'sort',
            'latest'
        );

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


            case 'stock_asc':

                $query->orderBy(
                    'stock',
                    'asc'
                );

                break;


            case 'stock_desc':

                $query->orderBy(
                    'stock',
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

        $products = $query
            ->paginate(5)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Product::query()
            ->distinct()
            ->pluck('category')
            ->sort();


        return view(
            'products.index',
            compact(
                'products',
                'categories'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'products.create'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'name' =>
            'required|string|max:255',

            'details' =>
            'nullable|string',

            'price' =>
            'required|numeric|min:0',

            'stock' =>
            'required|integer|min:0',

            'size' =>
            'required|string|max:255',

            'color' =>
            'required|string|max:255',

            'category' =>
            'required|string|max:255',

            'image' =>
            'required|image|mimes:jpg,jpeg,png|max:2048',

            'is_active' =>
            'nullable|boolean',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $imageName =
            time() .
            '.' .
            $request->image->extension();


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

            'name' =>
            $request->name,

            'details' =>
            $request->details,

            'price' =>
            $request->price,

            'stock' =>
            $request->stock,

            'size' =>
            $request->size,

            'color' =>
            $request->color,

            'category' =>
            $request->category,

            'image' =>
            'images/' . $imageName,

            'is_active' =>
            $request->boolean(
                'is_active'
            ),

        ]);


        return redirect()
            ->route(
                'products.index'
            )
            ->with(
                'success',
                'Product created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW PRODUCT
    |--------------------------------------------------------------------------
    */

    public function show(Product $product)
    {
        return view(
            'products.show',
            compact('product')
        );
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

    public function update(
        Request $request,
        Product $product
    ) {

        $request->validate([

            'name' =>
            'required|string|max:255',

            'details' =>
            'nullable|string',

            'price' =>
            'required|numeric|min:0',

            'stock' =>
            'required|integer|min:0',

            'size' =>
            'required|string|max:255',

            'color' =>
            'required|string|max:255',

            'category' =>
            'required|string|max:255',

            'image' =>
            'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'is_active' =>
            'nullable|boolean',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Existing Image
        |--------------------------------------------------------------------------
        */

        $imageName =
            $product->image;


        /*
        |--------------------------------------------------------------------------
        | Replace Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            if (
                $product->image &&
                file_exists(
                    public_path(
                        $product->image
                    )
                )
            ) {

                unlink(
                    public_path(
                        $product->image
                    )
                );
            }


            $newImageName =
                time() .
                '.' .
                $request->image->extension();


            $request->image->move(
                public_path('images'),
                $newImageName
            );


            $imageName =
                'images/' .
                $newImageName;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update([

            'name' =>
            $request->name,

            'details' =>
            $request->details,

            'price' =>
            $request->price,

            'stock' =>
            $request->stock,

            'size' =>
            $request->size,

            'color' =>
            $request->color,

            'category' =>
            $request->category,

            'image' =>
            $imageName,

            'is_active' =>
            $request->boolean(
                'is_active'
            ),

        ]);


        return redirect()
            ->route(
                'products.index'
            )
            ->with(
                'success',
                'Product updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MOVE PRODUCT TO TRASH
    |--------------------------------------------------------------------------
    */

    public function destroy(Product $product)
    {
        $product->delete();


        return redirect()
            ->route(
                'products.index'
            )
            ->with(
                'success',
                'Product moved to trash successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | TRASH PRODUCTS
    |--------------------------------------------------------------------------
    */

    public function trash()
    {
        $products = Product::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);


        return view(
            'products.trash',
            compact('products')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RESTORE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function restore($id)
    {
        $product = Product::onlyTrashed()
            ->findOrFail($id);


        $product->restore();


        return redirect()
            ->route(
                'products.trash'
            )
            ->with(
                'success',
                'Product restored successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | PERMANENT DELETE
    |--------------------------------------------------------------------------
    */

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Delete Physical Image
        |--------------------------------------------------------------------------
        */

        if (
            $product->image &&
            file_exists(
                public_path(
                    $product->image
                )
            )
        ) {

            unlink(
                public_path(
                    $product->image
                )
            );
        }


        $product->forceDelete();


        return redirect()
            ->route(
                'products.trash'
            )
            ->with(
                'success',
                'Product permanently deleted.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EXPORT PRODUCTS TO CSV
    |--------------------------------------------------------------------------
    */

    public function export(
        Request $request
    ): StreamedResponse {

        $query = Product::query();


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search =
                $request->search;


            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhere(
                            'details',
                            'like',
                            '%' . $search . '%'
                        );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Category
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
        | Stock Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('stock_status')) {

            if (
                $request->stock_status ===
                'in_stock'
            ) {

                $query->where(
                    'stock',
                    '>',
                    0
                );
            }


            if (
                $request->stock_status ===
                'out_of_stock'
            ) {

                $query->where(
                    'stock',
                    '<=',
                    0
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if (
                $request->status ===
                'active'
            ) {

                $query->where(
                    'is_active',
                    true
                );
            }


            if (
                $request->status ===
                'inactive'
            ) {

                $query->where(
                    'is_active',
                    false
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $sort =
            $request->input(
                'sort',
                'latest'
            );


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


            case 'stock_asc':

                $query->orderBy(
                    'stock',
                    'asc'
                );

                break;


            case 'stock_desc':

                $query->orderBy(
                    'stock',
                    'desc'
                );

                break;


            default:

                $query->latest();

                break;
        }


        $products =
            $query->get();


        /*
        |--------------------------------------------------------------------------
        | CSV Filename
        |--------------------------------------------------------------------------
        */

        $filename =
            'products_' .
            now()->format(
                'Y_m_d_H_i_s'
            ) .
            '.csv';


        /*
        |--------------------------------------------------------------------------
        | Stream CSV
        |--------------------------------------------------------------------------
        */

        return response()
            ->streamDownload(

                function () use ($products) {

                    $handle =
                        fopen(
                            'php://output',
                            'w'
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | CSV Header
                    |--------------------------------------------------------------------------
                    */

                    fputcsv(
                        $handle,
                        [
                            'ID',
                            'Name',
                            'Details',
                            'Category',
                            'Size',
                            'Color',
                            'Price',
                            'Stock',
                            'Status',
                            'Created At',
                        ]
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | CSV Data
                    |--------------------------------------------------------------------------
                    */

                    foreach (
                        $products
                        as $product
                    ) {

                        fputcsv(
                            $handle,
                            [

                                $product->id,

                                $product->name,

                                $product->details,

                                $product->category,

                                $product->size,

                                $product->color,

                                $product->price,

                                $product->stock,

                                $product->is_active
                                    ? 'Active'
                                    : 'Inactive',

                                $product->created_at
                                    ? $product
                                    ->created_at
                                    ->format(
                                        'Y-m-d H:i:s'
                                    )
                                    : '',

                            ]
                        );
                    }


                    fclose($handle);
                },

                $filename,

                [
                    'Content-Type' =>
                    'text/csv; charset=UTF-8',
                ]

            );
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCT ANALYTICS
    |--------------------------------------------------------------------------
    */

    public function analytics()
    {
        /*
        |--------------------------------------------------------------------------
        | Total Products
        |--------------------------------------------------------------------------
        */

        $totalProducts =
            Product::count();


        /*
        |--------------------------------------------------------------------------
        | Total Categories
        |--------------------------------------------------------------------------
        */

        $totalCategories =
            Product::whereNotNull(
                'category'
            )
            ->distinct(
                'category'
            )
            ->count(
                'category'
            );


        /*
        |--------------------------------------------------------------------------
        | Total Stock
        |--------------------------------------------------------------------------
        */

        $totalStock =
            Product::sum('stock');


        /*
        |--------------------------------------------------------------------------
        | Total Inventory Value
        |--------------------------------------------------------------------------
        */

        $totalValue =
            Product::sum(
                DB::raw(
                    'price * stock'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Products By Category
        |--------------------------------------------------------------------------
        */

        $productsByCategory =
            Product::select(
                'category',
                DB::raw(
                    'COUNT(*) as total'
                )
            )
            ->whereNotNull(
                'category'
            )
            ->groupBy(
                'category'
            )
            ->orderByDesc(
                'total'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return Analytics View
        |--------------------------------------------------------------------------
        */

        return view(
            'products.analytics',
            compact(
                'totalProducts',
                'totalCategories',
                'totalStock',
                'totalValue',
                'productsByCategory'
            )
        );
    }
}
