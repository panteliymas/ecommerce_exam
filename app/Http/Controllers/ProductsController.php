<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

use App\Models\Product;

class ProductsController extends Controller
{
    /**
     * Display catalog.
     */
    public function catalog(Request $request): Response
    {
        $products = Product::where('status', 'active')->get()->toArray();
        // dd($products);

        return Inertia::render('Products/List', [
            'status'   => session('status'),
            'products' => $products,
        ]);
    }
}
