<?php

namespace App\Http\Middleware;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use Closure;
use Auth;
use Cache;
use Schema;

// dev-1.0, 20170906, Ferry, Declare disini jika butuh Class customizing sendiri
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Avicenna\avi_mutation_type;
use App\Models\Avicenna\avi_uom;

class RoleLoaderMiddleware
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
        // dev-1.0, 20170906, Load semua variable global dari application sesuai roles
        $user = Auth::user();

        if ( $user->hasAnyRole(Role::where('name', 'like', 'avi%')->get()) ) {

            if (Schema::hasTable('avi_mutation_types')) {
                
                // Using cache to speed performance, so don't forget to FORGET the cache everytime update periods !!!
                $avi_mutation = new avi_mutation_type;
                $avi_mutation = Cache::remember('avi_mutation_types', 60, function() use ($avi_mutation)
                {
                    return $avi_mutation->pluck('code', 'name')->all();
                });

                config()->set('avi_mutation', $avi_mutation);
            }

            if (Schema::hasTable('avi_uoms')) {
                
                // Using cache to speed performance, so don't forget to FORGET the cache everytime update periods !!!
                $avi_uom = new avi_uom;
                $avi_uom = Cache::remember('avi_uoms', 60, function() use ($avi_uom)
                {
                    return $avi_uom->pluck('code', 'sname')->all();
                });

                config()->set('avi_uom', $avi_uom);
            }
        }

        return $next($request);
    }
}
