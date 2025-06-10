<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
public function handle(Request $request, Closure $next)
{
    $response = $next($request);

    if (method_exists($response, 'headers')) {
        // Semua pengaturan header
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('server');

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        $csp = "default-src 'self'; "
             . "script-src 'self' 'unsafe-inline'; "
             . "style-src 'self' 'unsafe-inline'; "
             . "img-src 'self' data:; "
             . "font-src 'self'; "
             . "object-src 'none'; "
             . "frame-ancestors 'self'; "
             . "form-action 'self'; "
             . "base-uri 'self';";

        $response->headers->set('Content-Security-Policy', $csp);
    }

    return $response;
}
}
