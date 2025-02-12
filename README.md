<<<<<<< HEAD
# product-management
=======
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
-------------------------------------------------------------------------------------------------------------------------------------------------------------------

# Step 1: Create Laravel Project
composer create-project laravel/laravel product-management
cd product-management

# Step 2: Install Authentication
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev

# Step 3: Configure Database
# Update .env file with database credentials

# Step 4: Create Product Model, Migration, and Controller
php artisan make:model Product -m
php artisan make:controller ProductController --resource

# Step 5: Define Product Table Structure
// database/migrations/YYYY_MM_DD_create_products_table.php
public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->integer('stock');
        $table->string('image')->nullable();
        $table->timestamps();
    });
}
php artisan migrate

# Step 6: Define Product Model
// app/Models/Product.php
class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'stock', 'image'];
}

# Step 7: Implement CRUD Operations in ProductController
// app/Http/Controllers/ProductController.php
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
    
    public function create() {
        return view('products.create');
    }
    
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = $request->all();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }
    
    public function show(Product $product) {
        return view('products.show', compact('product'));
    }
    
    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }
    
    public function update(Request $request, Product $product) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = $request->all();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }
    
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}

# Step 8: Define Routes
// routes/web.php
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
Route::resource('products', ProductController::class)->middleware('auth');
Auth::routes();
Route::get('/', [ProductController::class, 'index'])->name('home');

# Step 9: Create Views

## resources/views/products/index.blade.php
@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-4">Product List</h2>
    <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Add Product</a>
    <table class="table-auto w-full mt-3 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Image</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Price</th>
                <th class="border px-4 py-2">Stock</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="border">
                    <td class="border px-4 py-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover">
                    </td>
                    <td class="border px-4 py-2">{{ $product->name }}</td>
                    <td class="border px-4 py-2">{{ $product->price }}</td>
                    <td class="border px-4 py-2">{{ $product->stock }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('products.show', $product->id) }}" class="bg-green-600 hover:bg-green-800 text-white font-bold py-1 px-2 rounded">View</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-600 hover:bg-yellow-800 text-white font-bold py-1 px-2 rounded">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

# Step 10: Run Server
php artisan serve


-------------------------------------------------------------------------------------------------------------------------------------------------------------------
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
>>>>>>> 8c9100a (Initial commit)
