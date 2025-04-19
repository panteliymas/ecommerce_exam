<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsApiController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image',
            'price' => 'required|numeric',
            'stock' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $product = new Product($validatedData);

        $path = $request->photo->store('products', 'public');
        $product->photo = 'storage/'.$path;

        $product->save();

        return new ProductResource($product);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'photo' => 'sometimes|required|image',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'nullable|numeric',
        ]);

        if ($request->file('photo')) {
            $path = $request->photo->store('products', 'public');
            $validatedData['photo'] = 'storage/'.$path;
        }

        $product->update($validatedData);
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }
}