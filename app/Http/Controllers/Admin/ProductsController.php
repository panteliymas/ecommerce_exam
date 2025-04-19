<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductsController extends Controller
{
    public function catalog(Request $request)
    {
        $products = Product::with('categories')->get();

        return Inertia::render('Admin/Catalog/Products', [
            'products' => $products,
        ]);
    }

    public function product(Request $request, $id = null)
    {
        $data = [];
        if ($id) {
            $data['product'] = Product::with('categories')->find($id);
            if (!$data['product']) {
                return redirect()->back()->with('error', 'Product not found');
            }
        }
        
        $data['categories'] = Category::all();

        return Inertia::render('Admin/Catalog/Product', $data);
    }

    public function saveProduct(Request $request, $id)
    {
        if ($id == 0) {
            $product = new Product;
        } else {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found');
            }
        }

        $request->validate([
            'product.name' => 'required|string',
            'product.photo' => 'required|image',
            'product.price' => 'required|gt:0',
        ]);
        
        $photo = $request->file('product.photo');
        $_product = $request->only(['product.name', 'product.description', 'product.price', 'product.stock'])['product'];
        $categories = $request->input('product.categories');
        
        if ($photo instanceof \Illuminate\Http\UploadedFile) {
            $path = $photo->store('products', 'public');
            // dd($path);
            $product->photo = 'storage/'.$path;
        }

        $product->fill($_product);
        $product->save();
        $product->categories()->sync($categories);
        $product->save();
        $product->refresh();

        return redirect()->route('admin.products.catalog');
    }

    public function deleteProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        $product->delete();

        return back()->with('error', 'Product deleted');
    }

    public function categories(Request $request)
    {
        $categories = Category::withCount('products')->get();

        return Inertia::render('Admin/Catalog/Categories', [
            'categories' => $categories,
        ]);
    }

    public function category(Request $request, $id = null)
    {
        $data = [];
        if ($id) {
            $data['category'] = Category::with('products')->find($id);
            if (!$data['category']) {
                return redirect()->back()->with('error', 'Category not found');
            }
        }

        return Inertia::render('Admin/Catalog/Category', $data);
    }

    public function saveCategory(Request $request, $id)
    {
        if ($id == 0) {
            $category = new Category;
        } else {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->back()->with('error', 'Category not found');
            }
        }

        $request->validate([
            'category.name' => 'required|string',
        ]);

        $category->name = $request->get('category')['name'];
        $category->save();

        return redirect()->route('admin.categories');
    }

    public function deleteCategory(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $category->delete();

        return back()->with('message', 'Category deleted');
    }
}