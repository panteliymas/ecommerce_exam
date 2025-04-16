<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use App\Models\Product;
use App\Http\Managers\CartManager;

use Auth;
use Cache;

class CartController extends Controller
{
    /**
     * Get user's cart.
     */
    public function cart(Request $request): JsonResponse
    {
        $cart = CartManager::getCartFromCache($request->ip());
        
        return response()->json(['status' => true, 'data' => $cart]);
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request)
    {
        $user_key = Auth::check() ? 'user_' . Auth::id() : $request->ip();

        $cart = [];
        if (Cache::has($user_key . '_cart')) {
            $cart = json_decode(base64_decode(Cache::get($user_key . '_cart')), true);
        }
        $cart = collect($cart);
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found']);
        }

        $items = $cart->reject(fn($_item) => $_item['product_id'] != $request->product_id);
        $cart = $cart->reject(fn($_item) => $_item['product_id'] == $request->product_id);
        $quantity = $items->count() ? $items->sum('quantity') : 0;
        $cart->push([
            'product_id' => $request->product_id,
            'quantity' => $quantity + $request->quantity,
        ]);
        // dd($request->all(), $quantity, $cart->toArray());
        
        // Interia::share('cart', $cart);

        Cache::put($user_key . '_cart', base64_encode(json_encode($cart->toArray())), 60 * 24 * 30); // 30 days
        
        return redirect()->back()->with('status', 'Product added to cart');
    }

    /**
     * Remove product from cart.
     */
    public function remove(Request $request)
    {
        $user_key = Auth::check() ? 'user_' . Auth::id() : $request->ip();

        $cart = [];
        if (Cache::has($user_key . '_cart')) {
            $cart = json_decode(base64_decode(Cache::get($user_key . '_cart')), true);
        } else {
            return redirect()->back()->with('status', 'Cart is empty');
        }
        $cart = collect($cart);

        $items = $cart->reject(fn($_item) => $_item['product_id'] != $request->product_id);
        if ($items->count() == 0) {
            return redirect()->back()->with(['status', 'Cart item not found']);
        }

        $cart = $cart->reject(fn($_item) => $_item['product_id'] == $request->product_id);
        
        Cache::put($user_key . '_cart', base64_encode(json_encode($cart->toArray())), 60 * 24 * 30); // 30 days
        
        return redirect()->back()->with('status', 'Product removed from cart');
    }

    /**
     * Checkout page.
     */
    public function checkoutPage(Request $request) : InertiaResponse
    {
        $cart = CartManager::getCartFromCache($request->ip());

        return Inertia::render('Cart/Checkout', [
            'cart' => $cart,
            // 'user' => Auth::user(),
        ]);
    }

    /**
     * Checkout.
     */
    public function checkout(Request $request)
    {
        dd($request->all());

        $cart = $request->cart;
        if (empty($cart)) {
            return redirect()->back()->with('status', 'Cart is empty');
        }
        $cart = collect($cart);

        $delivery_info = $request->deliveryInfo;
        if (empty($delivery_info)) {
            return redirect()->back()->with('status', 'Delivery info is empty');
        }
        $delivery_info = collect($delivery_info);

        Cache::forget($request->ip() . '_cart');
        Cache::forget('user_' . Auth::id() . '_cart');
    }
}
