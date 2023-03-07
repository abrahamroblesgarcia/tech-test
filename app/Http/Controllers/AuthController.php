<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\Contexts\User as UserContext;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request) 
    {
        $token = UserContext::register($request->username, $request->avatar, $request->token);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer' 
        ]);
    }
}
