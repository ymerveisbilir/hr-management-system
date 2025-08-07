<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Helpers\AuthUser;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $authUser = AuthUser::get();

        if (!$authUser || $authUser->is_superadmin != 1) {
            abort(403, 'Yetkisiz erişim.');
        }

        return $next($request);
    }
}
