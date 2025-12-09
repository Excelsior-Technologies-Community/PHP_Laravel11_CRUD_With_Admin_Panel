 Laravel 11 Product CRUD + Admin Panel + Customer Products

![Laravel](https://img.shields.io/badge/Laravel-11-orange)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple)
![MySQL](https://img.shields.io/badge/Database-MySQL-yellow)

---

 Overview

This project demonstrates a complete **Product CRUD + Admin Panel + Customer Product Listing** built using Laravel 11 and Bootstrap UI.

It includes:
- Product CRUD  
- Image Upload  
- Admin Authentication (Laravel Breeze)  
- Bootstrap Admin Panel  
- Customer Product Page  
- Fully Responsive Layouts  
- Modern Folder Structure  

---

 Features

- Add / Edit / Delete Products  
- Upload Product Images  
- Pagination  
- Admin-only Access  
- Customer Product Page  
- Separate Admin & Customer Layouts  
- Clean UI  

---

 Folder Structure

```
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
```

---

 Installation

```bash
composer create-project laravel/laravel product-crud
cd product-crud
```

---

 Environment Setup

Update `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=root
```

---

 Migration

Create migration:

```bash
php artisan make:migration create_products_table --create=products
```

Fields:
- name  
- details  
- price  
- size  
- color  
- category  
- image  

Run migration:

```bash
php artisan migrate
```

---

 Model (Product)

```php
class Product extends Model
{
    protected $fillable = [
        'name',
        'details',
        'price',
        'size',
        'color',
        'category',
        'image',
    ];
}
```

---

 Routes

```php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerProductsController;

Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
});

Route::get('/customer/products', [CustomerProductsController::class, 'index'])
    ->name('customer.products');
```

---

 Controller (Important Methods)

 Display Products  
```php
public function index() {
    $products = Product::latest()->paginate(10);
    return view('products.index', compact('products'));
}
```

 Store Product  
```php
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'details' => 'required',
        'price' => 'required',
        'image' => 'nullable|image|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $imageName = time().'_'.$request->image->getClientOriginalName();
        $request->image->move(public_path('images'), $imageName);
        $imagePath = 'images/'.$imageName;
    }

    Product::create([
        'name' => $request->name,
        'details' => $request->details,
        'price' => $request->price,
        'size' => $request->size,
        'color' => $request->color,
        'category' => $request->category,
        'image' => $imagePath ?? null,
    ]);
}
```

---

 Blade Layout System

 Admin Layout (`admin.blade.php`)

```blade
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

 @include('layouts.navigation')

 <div class="container py-4">
     @yield('content')
 </div>

</body>
</html>
```

---

 Customer Layout (`customer.blade.php`)

Simple customer view with product grid.

---

 Blade Pages

`products/index.blade.php`  
Admin product listing.

 `products/create.blade.php`  
Admin product create form.

`products/edit.blade.php`  
Admin edit form.

 `customer/index.blade.php`  
Customer product grid view.

---

 Run Application

```
php artisan serve
```

Admin Panel:
```
http://127.0.0.1:8000/products
```

Customer Page:
```
http://127.0.0.1:8000/customer/products
```

---

 Screenshots

<img width="1054" height="331" alt="image" src="https://github.com/user-attachments/assets/b70bf763-3c01-4918-9f70-42d9fe3db7f8" />
<img width="471" height="269" alt="image" src="https://github.com/user-attachments/assets/a3430f39-23aa-4532-bcd4-a48420bd3a12" />

 
