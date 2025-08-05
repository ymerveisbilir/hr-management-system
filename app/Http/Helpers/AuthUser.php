<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthUser
{
    public static function get()
    {
        if(!Auth::check()) return null;
        
        $user = Auth::user();

        return $user;
    }
}