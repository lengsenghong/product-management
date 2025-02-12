@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Product List</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
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
                            <button type="submit" class="btn btn=danger hover:bg-red-1000 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection