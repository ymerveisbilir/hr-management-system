<?php

namespace App\Http\Helpers;

use App\Http\Helpers\AuthUser;
use App\Models\User;
class Functions
{
    public static function approverUserIds()
    {
        return User::whereNotNull('approver_user')->pluck('id')->toArray();
    }
}