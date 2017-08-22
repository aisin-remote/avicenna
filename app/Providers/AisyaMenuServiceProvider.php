<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// dev-1.0, 20170821, Ferry, Declare disini jika butuh Class bawaan laravel yang tidak auto-generated
use View;

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

            // Aisya level 0
            $aisya_root_menu = ais_apps::where('apps_level', 0)->get();
            $view->with('aisya_root_menu', $aisya_root_menu);

            // Aisya level 0
            $aisya_menu_1 = ais_apps::where('apps_level', 1)->get();
            $view->with('aisya_menu_1', $aisya_menu_1);
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
