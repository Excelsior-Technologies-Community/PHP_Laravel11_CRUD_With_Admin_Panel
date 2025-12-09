# PHP_Laravel11_CRUD_With_Admin_Panel

This guide walks you step-by-step through creating a full CRUD application in Laravel 11 for managing products, including image uploading, admin authentication, and a customer product page.

---

## Step 1: Install Laravel 11

We start with a fresh installation of Laravel 11.  
Run the following command:

```
composer create-project laravel/laravel example-app
```

---

## Step 2: MySQL Database Configuration

Laravel 11 uses SQLite by default.  
To use MySQL, update your **.env** file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your database name (blog)
DB_USERNAME=root
DB_PASSWORD=root
```

---

## Step 3: Create Migration

Create a migration file:

```
php artisan make:migration create_products_table --create=products
```

After creating the file in **database/migrations**, add the following schema:

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('details');
    $table->decimal('price', 8, 2);
    $table->string('size');
    $table->string('color');
    $table->string('category');
    $table->string('image')->nullable();
    $table->timestamps();
});
```

Run migration:

```
php artisan migrate
```

---

## Step 4: Add Resource Route

In **routes/web.php**:

```php
use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);
```

---

## Step 5: Add Controller and Model

Create a new controller and model:

```
php artisan make:controller ProductController --resource --model=Product
```

### Product Model

```php
class Product extends Model
{
    protected $fillable = [
        'name','details','price','size','color','category','image'
    ];
}
```

---

## ProductController Code

### Show all products

```php
public function index()
{
    $products = Product::latest()->paginate(10);
    return view('products.index', compact('products'));
}
```

### Show create form

```php
public function create()
{
    return view('products.create');
}
```

### Store product

```php
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'details' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'size' => 'required|string|max:50',
        'color' => 'required|string|max:50',
        'category' => 'required|string|max:100',
        'price' => 'required|numeric|min:0',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $imagePath = 'images/'.$imageName;
    }

    Product::create([
        'name' => $request->name,
        'details' => $request->details,
        'image' => $imagePath,
        'size' => $request->size,
        'color' => $request->color,
        'category' => $request->category,
        'price' => $request->price,
    ]);

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}
```

### Show a single product

```php
public function show(Product $product)
{
    return view('products.show', compact('product'));
}
```

### Edit form

```php
public function edit(Product $product)
{
    return view('products.edit', compact('product'));
}
```

### Update product

```php
public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'details' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'size' => 'required|string|max:50',
        'color' => 'required|string|max:50',
        'category' => 'required|string|max:100',
        'price' => 'required|numeric|min:0',
    ]);

    $imagePath = $product->image;

    if ($request->hasFile('image')) {

        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $image = $request->file('image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        $imagePath = 'images/'.$imageName;
    }

    $product->update([
        'name' => $request->name,
        'details' => $request->details,
        'image' => $imagePath,
        'size' => $request->size,
        'color' => $request->color,
        'category' => $request->category,
        'price' => $request->price,
    ]);

    return redirect()->route('products.index')
        ->with('success', 'Product updated successfully.');
}
```

### Delete product

```php
public function destroy(Product $product)
{
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
}
```

---

## Step 6: Create Blade Files

You must create the following:

```
resources/views/products/index.blade.php
resources/views/products/create.blade.php
resources/views/products/edit.blade.php
```

(Your file contains full code for all three views.)

---

## Layout Files Required

### layouts/app.blade.php  
### layouts/admin.blade.php  

(Exact code is same as your provided file.)

---

## Run Application

```
php artisan serve
```

Open CRUD:

```
http://localhost:8000/products
```

---

# CRUD With Admin Panel

Install Laravel Breeze for authentication:

### Step 1:

```
composer require laravel/breeze --dev
```

### Step 2:

```
php artisan breeze:install blade
```

### Step 3:

```
npm install
npm run dev
```

### Step 4:

```
php artisan migrate
```

### Step 5: Protect product routes

```php
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
});
```

### Step 6:

```
php artisan serve
```

Then login → redirect to:

```
/products
```

---


 Screenshots

<img width="1054" height="331" alt="image" src="https://github.com/user-attachments/assets/b70bf763-3c01-4918-9f70-42d9fe3db7f8" />
<img width="471" height="269" alt="image" src="https://github.com/user-attachments/assets/a3430f39-23aa-4532-bcd4-a48420bd3a12" />

 
