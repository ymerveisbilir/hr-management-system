<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use App\Rules\StrongPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login_index()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember_me ?? false)) {
            $request->session()->regenerate();
            return ['redirect' => route('admin.index')];
        }
        throw ValidationException::withMessages([
            'email' => __('panel_login.wrong_email_or_password'),
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout(); 

        $request->session()->invalidate();  
        $request->session()->regenerateToken(); 
        return ['redirect' => route('admin.login')];
    }
}
