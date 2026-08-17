<?php

namespace App\Http\Middleware;

use App\Models\Config;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $config = Config::find(1);

        $active = $config?->maintenance_mode
            && ($config->maintenance_until === null || $config->maintenance_until->isFuture());

        if (! $active) {
            return $next($request);
        }

        if ($request->routeIs('web.manutencao')) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->hasRole(['super admin', 'admin', 'pastor', 'lider'])) {
            return $next($request);
        }

        return redirect()->route('web.manutencao');
    }
}