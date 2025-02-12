<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    //controller middleware
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
