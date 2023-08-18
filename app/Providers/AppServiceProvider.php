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
        setlocale(LC_TIME, 'es_ES');

        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $menu = [
                    [
                        'name' => 'Clientes',
                        'icon' => 'fa fa-user',
                        'submenu' => [['name' => 'todo los clientes', 'url' => 'cliente.index'], ['name' => 'crear un cliente', 'url' => 'cliente.create']],
                    ],
                    [
                        'name' => 'vehiculos',
                        'icon' => 'fa fa-motorcycle',
                        'submenu' => [['name' => 'todo los vehiculos', 'url' => 'moto.index'], ['name' => 'crear un vehiculos', 'url' => 'moto.create']],
                    ], 
                    [
                        'name' => 'Inventario de las motos',
                        'icon' => 'fa fa-cubes',
                        'submenu' => [['name' => 'tabla de los inventarios', 'url' => 'inventario_moto.index'], ['name' => 'nuevo inventario( moto )', 'url' => 'inventario_moto.create'],['name' => 'todo los accesorios', 'url' => 'accesorios.index'],['name' => 'crear accesorios', 'url' => 'accesorios.create'],['name' => 'todo las autorizaciones', 'url' => 'autorizaciones.index'],['name' => 'crear autorizacion', 'url' => 'autorizaciones.create']],
                    ],
                    [
                        'name' => 'Productos',
                        'icon' => 'fa fa-boxes',
                        'submenu' => [['name' => 'Todo los productos', 'url' => 'moto.index'], ['name' => 'Categoria', 'url' => 'moto.create'], ['name' => 'Marca Producto', 'url' => 'marca_producto.index'], ['name' => 'Categoria', 'url' => 'moto.create'], ['name' => 'Categoria', 'url' => 'moto.create']],
                    ],
                    [
                        'name' => 'Servicios',
                        'icon' => 'fa fa-wrench',
                        'submenu' => [['name' => 'Todo los servicios', 'url' => 'moto.index'], ['name' => 'Nuevo Servicio', 'url' => 'moto.create']],
                    ],
                ];

                view()->share([
                    'menu' => $menu,
                ]);
            } else {
                $view->with('currentUser', null);
            }
        });
    }
}
