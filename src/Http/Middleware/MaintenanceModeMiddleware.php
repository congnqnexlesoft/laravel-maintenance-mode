<?php

namespace CongnqNexlesoft\MaintenanceMode\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
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
        // except URIs
        if ($this->inExceptArray($request)) {
            return $next($request);
        }
        // handle
        if (app()->isDownForMaintenance()) {
            // Response uses JSON (required config .env)
            if (strtolower(getenv('MAINTENANCE_RESPONSE_FORMAT')) === 'json') {
                return response()->json([
                    'success' => false,
                    'error' => 'UNDER_MAINTENANCE',
                    'message' => 'UNDER_MAINTENANCE',
                ], Response::HTTP_SERVICE_UNAVAILABLE); // END
            }
            // Response uses view
            //    Laravel will use the view 'resources/views/errors/503.blade.php' in maintenance mode by default
            throw new MaintenanceModeException((new \DateTime())->getTimestamp()); // END
        }
        //
        return $next($request);
    }


    /**
     * Need an ENV: EXCEPT_URIS
     * Determine if the request has a URI that should be accessible in maintenance mode.
     * @param Request $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        $exceptURIs = explode(',', getenv('EXCEPT_URIS'));
        foreach ($exceptURIs as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }
        return false;
    }
}
