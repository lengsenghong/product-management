@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Product Details</h2>
    <p><strong>Name:</strong> {{ $product->name }}</p>
    <p><strong>Price:</strong> {{ $product->price }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
</div>