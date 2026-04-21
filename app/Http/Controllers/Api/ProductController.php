<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|decimal:0,3',
            'description' => 'nullable'
        ]);

        $newProduct = Product::create($data);

        return response()->json([
            'product' => $newProduct
            ]);

    }

    public function show(Product $product)
    {

        return response()->json($product);

    }


    public function update(Product $product, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|decimal:0,3',
            'description' => 'nullable',
        ]);

        $product->update($data);

        return response()->json([
            'product' => $product
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json();
    }
}