<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use App\Models\Product;
use App\Http\Managers\CartManager;

class ProductsController extends Controller
{
    /**
     * Display catalog.
     */
    public function catalog(Request $request): InertiaResponse
    {
        $products = Product::where('status', 'active')->paginate(20);

        return Inertia::render('Products/List', [
            'status'   => session('status'),
            'products' => $products,
        ]);
    }

    /**
     * Display product.
     */
    public function product(Request $request, $id): InertiaResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return Redirect::route('products.catalog')->with('status', 'Product not found');
        }

        $cart = CartManager::getCartFromCache($request->ip());
        $is_in_cart = collect($cart)->where('id', $id)->first();

        return Inertia::render('Products/Product', [
            'product'    => $product,
            'cart'       => $cart,
            'is_in_cart' => $is_in_cart,
        ]);
    }
}
