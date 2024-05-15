<?php

namespace CongnqNexlesoft\MaintenanceMode\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (app()->isDownForMaintenance()) {
            // Response uses JSON (required config .env)
            if (strtolower(getenv('MAINTENANCE_RESPONSE_FORMAT')) === 'json') {
                return response()->json([
                    'success' => false,
                    'error' => 'UNDER_MAINTENANCE',
                    'message' => 'UNDER_MAINTENANCE',
                ], Response::HTTP_SERVICE_UNAVAILABLE);
            }
            // Response uses view
            //    do nothing (Laravel will use the view 'resources/views/errors/503.blade.php' in maintenance mode by default)
        }
        //
        return $next($request);
    }
}
