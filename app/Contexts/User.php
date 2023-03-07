<?php 

namespace App\Contexts;

use App\Models\User as UserModel;

class User 
{
    public static function register($username, $avatar, $token) 
    {
        $user =UserModel::create([
            'username' => $username,
            'avatar' => $avatar,
            'token' => $token
        ]);

        return $user->createToken('auth_token')->plainTextToken;
    }
}