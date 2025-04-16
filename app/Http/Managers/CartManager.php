<?php

namespace App\Http\Managers;

use Illuminate\Support\Manager;
use App\Models\Product;

use Auth;
use Cache;

class CartManager extends Manager
{
    /**
     * Get user's cart.
     */
    public static function getCartFromCache($ip) : array
    {
        $cart = [];
        if (Cache::has($ip . '_cart')) {
            $cart = json_decode(base64_decode(Cache::get($ip . '_cart')), true);
        }
        $cart = collect($cart);

        $_cart = [];
        if (Auth::check() && Cache::has('user_' . Auth::id() . '_cart')) {
            $_cart = array_merge($cart->toArray(), json_decode(base64_decode(Cache::get('user_' . Auth::id() . '_cart')), true));
        }
        $_cart = collect($_cart);

        $cart = $_cart->concat($cart);
        $product_ids = $cart->pluck('product_id')->unique();
        $cart = self::getCartFull($cart);

        return $cart;
    }

    /**
     * Get cart full details.
     */
    public static function getCartFull($_cart) 
    {
        $product_ids = $_cart->pluck('product_id')->unique();
        $cart = $product_ids->map(function($product_id) use ($_cart) {
            $product = Product::find($product_id);
            if (!$product) {
                return null;
            }
            $quantity = $_cart->where('product_id', $product_id)->sum('quantity');
            return [
                'id' => $product->getKey(),
                'photo' => $product->photo,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $quantity,
                'total' => $product->price * $quantity,
                'stock' => $product->stock,
            ];
        })->values()->toArray();

        return $cart;
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return '';
    }
}