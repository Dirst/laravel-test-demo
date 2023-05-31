<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DateRouteParameterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $birthdate = $request->route('birthdate');

        if ($birthdate) {
            $request->route()->setParameter('birthdate', new \DateTime($birthdate));
        }

        return $next($request);
    }
}
