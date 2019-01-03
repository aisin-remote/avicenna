<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// dev-1.0, 20170821, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use View;
use Auth;

// dev-1.0, 20170821, Ferry, Declare disini jika butuh Class customizing sendiri
use App\Models\Aisya\ais_apps;

class AisyaMenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // dev-1.0, Ferry, 20170821, Supply variabel untuk layout /views/vendor/adminlte/*/sidebar.blade.php
        //                           Karena under app.blade.php sehingga tidak bisa disupply melalui controller

        View::composer('*.sidebar', function($view) {

            $user = Auth::user();
            if ($user) {    // dev-1.1.0, Ferry, 20190103, View template (sidebar) jika user dengan otentikasi
                $view->with('user', $user);

                // Aisya level 0
                $aisya_root_menu = ais_apps::select('ais_apps.*')
                                            ->join('role_has_apps', 'ais_apps.id', '=', 'role_has_apps.apps_id')
                                            ->whereIn('role_has_apps.role_id', $user->roles->pluck('id')->toArray())
                                            ->where('apps_level', 0)->distinct()->get();
                $view->with('aisya_root_menu', $aisya_root_menu);

                // Aisya level 0
                $aisya_menu_1 = ais_apps::select('ais_apps.*')
                                            ->join('role_has_apps', 'ais_apps.id', '=', 'role_has_apps.apps_id')
                                            ->whereIn('role_has_apps.role_id', $user->roles->pluck('id')->toArray())    
                                            ->where('apps_level', 1)->distinct()->get();
                $view->with('aisya_menu_1', $aisya_menu_1);
            }
            else {  // dev-1.1.0, Ferry, 20190103, View template (sidebar) jika user tanpa otentikasi
                $view->with('user', null);
                $view->with('aisya_root_menu', []);
                $view->with('aisya_menu_1', []);
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
