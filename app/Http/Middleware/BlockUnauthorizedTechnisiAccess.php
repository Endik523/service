<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockUnauthorizedTechnisiAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = filament()->auth()->user();

        // Hanya proses jika role teknisi
        if ($user && $user->role === 'teknisi') {
            // Allow dashboard & order resource only
            $allowedPaths = [
                'admin',                  // Dashboard
                'admin/orders',           // Order resource index
                'admin/orders/',          // for show/edit/create
                'admin/logout',           // logout
            ];

            $currentPath = trim($request->path(), '/');

            foreach ($allowedPaths as $allowed) {
                if (str_starts_with($currentPath, $allowed)) {
                    return $next($request);
                }
            }

            return redirect('/admin')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}
