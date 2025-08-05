<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn (Request $request) => route('admin.login')); // auth middlewarein yönlendireceği rota
        $middleware->redirectUsersTo(fn (Request $request) => route('admin.index')); // guest middlewarein yönlendireceği rota
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
