<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class HttpRequestLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user(appGuard());
        $message = 'WEB INCOMING REQUEST';
        if ($request->is('api/*')) {
            $message = 'API INCOMING REQUEST';
        }

        Log::channel('requests')
            ->log('debug',$message,[
                'url'  => $request->route()->uri,
                'params' => $request->is('api/v1/auth/*') ? [] : $request->all(),
                'app_version' => $request->headers->get('app-version'),
                'device_platform' => $request->headers->get('device-platform'),
                'device_id' => $request->headers->get('device-id'),
                'language' => $request->headers->get('accept-language'),
                'ip_address' => $request->ip(),
                'auth_user' => $user ? get_class($user) . '.' . $user->id : null,
            ]);
        Log::channel('requests')->alert('\n');

        return $next($request);
    }
}
