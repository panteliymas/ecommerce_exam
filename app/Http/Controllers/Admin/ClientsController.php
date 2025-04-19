<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ClientsController extends Controller
{
    public function members()
    {
        return response()->json([
            'message' => 'Hello from API ProductsController'
        ]);
    }

    public function member()
    {
        return response()->json([
            'message' => 'Hello from API ProductsController'
        ]);
    }

    public function saveMember()
    {
        return response()->json([
            'message' => 'Hello from API ProductsController'
        ]);
    }
    public function deleteMember()
    {
        return response()->json([
            'message' => 'Hello from API ProductsController'
        ]);
    }

    public function orders()
    {
        return response()->json([
            'message' => 'Hello from API ProductsController'
        ]);
    }

    public function order()
    {
        return response()->json([
            'message' => 'Hello from API ProductsController'
        ]);
    }

    public function orderStatus()
    {
        return response()->json([
            'message' => 'Hello from API ProductsController'
        ]);
    }

    public function deleteOrder()
    {
        return response()->json([
            'message' => 'Hello from API ProductsController'
        ]);
    }
}