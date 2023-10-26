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
        setlocale(LC_TIME,"es_ES");

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
                        'name' => 'activaciones',
                        'icon' => 'fa fa-handshake',
                        'submenu' => [
                            ['name' => 'todo las activaciones', 'url' => 'activaciones.index'], 
                            ['name' => 'crear una activacion', 'url' => 'activaciones.create'],
                            ['name' => 'todas las tiendas', 'url' => 'tiendas.index'],
                            ['name' => 'crear una tienda', 'url' => 'tiendas.create']
                        ],
                    ], 
                    [
                        'name' => 'Inventario de las motos',
                        'icon' => 'fa fa-cubes',
                        'submenu' => [
                            ['name' => 'tabla de los inventarios', 'url' => 'inventario_moto.index'], 
                            ['name' => 'nuevo inventario( moto )', 'url' => 'inventario_moto.create'],
                            ['name' => 'Cotizaciones', 'url' => 'cotizaciones.index'],
                            ['name' => 'todo los accesorios', 'url' => 'accesorios.index'],
                            ['name' => 'crear accesorios', 'url' => 'accesorios.create'],
                            ['name' => 'todo las autorizaciones', 'url' => 'autorizaciones.index'], 
                            ['name' => 'crear autorizacion', 'url' => 'autorizaciones.create'], 
                        ],
                    ],
                    [
                        'name' => 'Productos',
                        'icon' => 'fa fa-boxes',
                        'submenu' => [
                            ['name' => 'Todo los productos', 'url' => 'producto.index'], 
                            ['name' => 'Crear un producto', 'url' => 'producto.create'],  
                            ['name' => 'Marcas de Producto', 'url' => 'marca_producto.index'], 
                            ['name' => 'Crear marca de producto', 'url' => 'marca_producto.create'], 
                            ['name' => 'Categorias', 'url' => 'categorias.index'], 
                            ['name' => 'crear categoria', 'url' => 'categorias.create']
                        ],
                    ],
                    [
                        'name' => 'Mantenimientos',
                        'icon' => 'fa fa-cogs',
                        'submenu' => [
                            ['name' => 'Todo los mantenimientos', 'url' => 'mantenimiento.index'], 
                            ['name' => 'crear un mantenimiento', 'url' => 'mantenimiento.create'],  
                        ],
                    ],
                    [ 
                        'name' => 'Compras',
                        'icon' => 'fa fa-cart-arrow-down',
                        'submenu' => [
                            ['name' => 'Todo los compras', 'url' => 'compras.index'], 
                            ['name' => 'crear una compra', 'url' => 'compras.create'],  
                            ['name' => 'todo los proveedores', 'url' => 'proveedores.index'], 
                            ['name' => 'crear un proveedor', 'url' => 'proveedores.create'], 
                            ['name' => 'Categorias', 'url' => 'categorias.index'], 
                            ['name' => 'crear categoria', 'url' => 'categorias.create']
                        ],
                    ],
                     [ 
                        'name' => 'Ventas',
                        'icon' => 'fa fa-cart-plus',
                        'submenu' => [
                            ['name' => 'Toda las ventas', 'url' => 'ventas.index'], 
                            ['name' => 'Crear un venta', 'url' => 'pos.create'],   
                        ],
                    ],
                    
                    [
                        'name' => 'Servicios',
                        'icon' => 'fa fa-wrench',
                        'submenu' => [['name' => 'Todo los servicios', 'url' => 'servicios.index'], ['name' => 'Nuevo Servicio', 'url' => 'servicios.create']],
                    ],
                    [
                        'name' => 'Usuarios',
                        'icon' => 'fa fa-users',
                        'submenu' => [['name' => 'Todo los usuarios', 'url' => 'users.index'], ['name' => 'Nuevo Usuario', 'url' => 'users.create']],
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
