🛒 Laravel 11 Product CRUD + Admin Panel + Customer Products








⭐ Overview

This project demonstrates how to build a complete Product CRUD System with:

Laravel 11

Admin Panel (Bootstrap UI)

Customer Product Page

Authentication (Laravel Breeze)

Image Upload System

Reusable Layouts (Admin + Customer)

⭐ Features

Product CRUD

Image Upload

Admin Authentication

Pagination

Separate Customer Product View

Clean Blade Layout System

📂 Folder Structure
LARAVEL_PRODUCT_CRUD/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProductController.php
│   │   │   ├── CustomerProductsController.php
│   ├── Models/
│   │   └── Product.php
│
├── database/
│   ├── migrations/
│   │   └── create_products_table.php
│
├── public/
│   └── images/
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── admin.blade.php
│   │   │   ├── customer.blade.php
│   │   ├── products/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   └── customer/
│   │       └── index.blade.php
│
├── routes/
│   └── web.php
│
└── README.md

🛠 Installation
composer create-project laravel/laravel product-crud
cd product-crud

🌎 Environment Setup

Update .env:

DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=root

🧱 Migration
php artisan make:migration create_products_table --create=products


Migration fields:

name

details

price

size

color

category

image

Run migration:

php artisan migrate

📦 Model
class Product extends Model
{
    protected $fillable = [
        'name', 'details', 'price',
        'size', 'color', 'category', 'image'
    ];
}

🚏 Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
});

Route::get('/customer/products', [CustomerProductsController::class, 'index'])
    ->name('customer.products');

🧠 Controller (Important Methods)
📌 Display Products
public function index() {
    $products = Product::latest()->paginate(10);
    return view('products.index', compact('products'));
}

📌 Store Product
public function store(Request $request)
{
    $imageName = time() . '_' . $request->image->getClientOriginalName();
    $request->image->move(public_path('images'), $imageName);

    Product::create([
        'name'=>$request->name,
        'details'=>$request->details,
        'price'=>$request->price,
        'size'=>$request->size,
        'color'=>$request->color,
        'category'=>$request->category,
        'image'=>'images/'.$imageName
    ]);
}

🎨 Blade Layout System
1️⃣ Admin Layout (admin.blade.php)
<!DOCTYPE html>
<html>
<head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

 @include('layouts.navigation')

 <div class="container py-4">
     @yield('content')
 </div>

</body>
</html>

2️⃣ Customer Layout

Same as screenshot style.

📄 Blade Pages
✔ index.blade.php

Product listing table.

✔ create.blade.php

Product form.

✔ edit.blade.php

Edit page.

▶ Run Application
php artisan serve


Visit:

http://127.0.0.1:8000/products
<img width="676" height="213" alt="image" src="https://github.com/user-attachments/assets/ae71636f-dadf-454c-b516-0dd0a373ea9d" />


Customer:

http://127.0.0.1:8000/customer/products
<img width="471" height="269" alt="image" src="https://github.com/user-attachments/assets/b88ed207-176e-4e56-abef-f3898ab95d31" />
