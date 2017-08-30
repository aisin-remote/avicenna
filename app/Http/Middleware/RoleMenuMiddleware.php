<?php

namespace App\Http\Middleware;

use Closure;

// dev-1.0, 20170824, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use Auth;
use Session;

// dev-1.0, 20170824, Ferry, Declare disini jika butuh Class customizing sendiri
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleMenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dev-1.0, Ferry, 20170824, Jika tidak punya role sama sekali maka autologout
        $user = Auth::user();

        if (! $user->hasAnyRole(Role::all()) || Role::count() <= 0 ) {
            Session::flush();
            Auth::logout();
            Session::regenerate();
            return redirect('login')->with('message', array('type' => 'danger', 'text' => __('aisya/alert.role_not_exist')));
        }
        else {
            return $next($request);
        }
    }
}
