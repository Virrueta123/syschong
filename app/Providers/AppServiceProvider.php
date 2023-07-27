<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('es');
        Carbon::setUTF8(true);
        setlocale(LC_TIME, "es_ES");


        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $menu = [
                    array(
                        "name" => "Clientes",
                        "icon" => "fa fa-user",
                        "submenu" => array(
                            array("name" => "todo los clientes", "url" => "cliente.index"),
                            array("name" => "crear un cliente", "url" => "cliente.create")
                        )
                    ),
                    array(
                        "name" => "vehiculos",
                        "icon" => "fa fa-motorcycle",
                        "submenu" => array(
                            array("name" => "todo los vehiculos", "url" => "vehiculo.index"),
                            array("name" => "crear un vehiculos", "url" => "vehiculo.create")
                        )
                    )
                ];

                view()->share([
                    'menu' => $menu
                ]);
            } else {
                $view->with('currentUser', null);
            }
        });
    }
}
