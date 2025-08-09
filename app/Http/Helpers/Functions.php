<?php

namespace App\Http\Helpers;

use App\Http\Helpers\AuthUser;
use App\Models\User;
class Functions
{
    public static function approverUserIds()
    {
        $auth_user = AuthUser::get();
        return User::where('approver_user', $auth_user['id'])->exists();
    }
}