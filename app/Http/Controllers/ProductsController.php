<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use App\Models\Product;
use App\Models\Category;
use App\Http\Managers\CartManager;

class ProductsController extends Controller
{
    /**
     * Display catalog.
     */
    public function catalog(Request $request): InertiaResponse
    {
        $filter = $request->input('filter', []);

        $products = Product::where('status', 'active')
            ->withFilters($filter)
            ->paginate(20)
            ->appends(['filter' => $filter]);

        $categories = Category::withCount([
            'products' => fn($query) => $query->withFilters($filter)
        ])->get();

        return Inertia::render('Products/List', [
            'filters' => $filter,
            'products' => $products,
            'categories' => $categories,
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
