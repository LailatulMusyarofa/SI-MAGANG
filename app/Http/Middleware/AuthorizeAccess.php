<?php

namespace App\Http\Middleware;

use App\Helpers\AccessHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $currentUrl = $request->route()?->getName();
        // Ambil action dari route resource (misal: store, update, destroy, dll.)
        $currentAction = $request->route()->getActionMethod();
        $currentMethod = $request->method(); // Ambil metode HTTP

        // Cek apakah user memiliki akses
        if (!AccessHelper::hasAccess($currentAction, $currentUrl, $currentMethod)) return abort(403, "Anda tidak memiliki akses untuk mengakses halaman ini.");

        // Share akses ke view
        view()->share('userAccess', AccessHelper::getUserAccessByUrl($currentUrl));

        return $next($request);
    }

}
