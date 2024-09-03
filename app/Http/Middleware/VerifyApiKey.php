<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('cbub-settings.is_api_key_enable')) {
            if (!$request->headers->has('x-cbub-key') || $request->header('x-cbub-key') !== config('cbub-settings.api_key')) {
                abort(403, __('Unauthorized'));
            }
        }
        return $next($request);
    }
}
