<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use Spatie\Permission\Models\Role;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            // dev-1.0, Cek apakah punya role avi_pis_scan. special redirect ke url default (pis scanner)
            if (Auth::user()->hasRole('avi_pis_scan')) {

                $role = Role::findByName('avi_pis_scan');
                return redirect($role->route_redirect ? $role->route_redirect : 'home');
            }
            else {
                return redirect('home');
            }

        }

        return $next($request);
    }
}
