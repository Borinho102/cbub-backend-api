<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateDeviceInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($user = $request->user('api')) {
            if ($request->headers->has('device-token')) {
                $user->device_token = $request->header('device-token');
            }

            if ($request->headers->has('device-platform')) {
                $user->device_platform = $request->header('device-platform');
            }

            if ($request->headers->has('accept-language')) {
                $user->language = $request->header('accept-language');
            }

            $user->ip_address = $request->ip();
            $user->update();
        }
        
        return $next($request);
    }
}
