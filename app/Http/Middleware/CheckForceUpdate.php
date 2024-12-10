<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ForceUpdate;
use Illuminate\Http\Request;

class CheckForceUpdate
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
        $platform = $request->header('Platform');
        $version = $request->header('App-Version');

        if (!$platform || !$version) {
            return response()->json([
                'status' => false,
                'message' => 'Platform and App-Version headers are required',
                'needs_update' => false
            ], 400);
        }

        $forceUpdate = ForceUpdate::where('platform', strtolower($platform))
            ->latest()
            ->first();

        if ($forceUpdate) {
            $needsUpdate = version_compare($version, $forceUpdate->version_number, '<');
            
            if ($needsUpdate && $forceUpdate->is_force_update) {
                return response()->json([
                    'status' => false,
                    'message' => 'App update required',
                    'needs_update' => true,
                    'is_force_update' => true,
                    'latest_version' => $forceUpdate->version_number
                ], 426); // 426 Upgrade Required
            }
        }

        return $next($request);
    }
}
