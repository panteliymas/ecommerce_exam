<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            if (auth()->attempt($request->only('email', 'password'),true))
            {
                $token = $request->user()->createToken('api-token')->plainTextToken;

                return response()->json(['token' => $token]);
            }
            return response()->json([ 'status' => false, 'errors' => ['Sorry, User not found']]);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }
}
