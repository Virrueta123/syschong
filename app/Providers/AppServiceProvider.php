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
                        'name' => 'Ventas',
                        'icon' => 'fa fa-cart-plus',
                        'submenu' => [
                            [
                                'name' => 'Listado de comprobantes',
                                'url' => 'ventas.index',
                            ],
                            [
                                'name' => 'Nota de venta',
                                'url' => 'ventas.notas_venta',
                            ],
                            [
                                'name' => 'Oportunidades de venta',
                                'url' => 'cliente.create',
                            ],
                            [
                                'name' => 'Cotizacion',
                                'url' => 'cliente.create',
                            ],
                        ],
                    ],

                    [
                        'name' => 'Activaciones',
                        'icon' => 'fa fa-cart-plus',
                        'submenu' => [
                            [
                                'name' => 'Nueva activacion',
                                'url' => 'activaciones.create',
                            ],
                            [
                                'name' => 'Listado',
                                'url' => 'activaciones.index',
                            ],
                            [
                                'name' => 'Casas comerciales',
                                'url' => 'tiendas.index',
                            ],
                            [
                                'name' => 'Vendedores por casa comerciales',
                                'url' => 'vendedor.index',
                            ],
                        ],
                    ],

                    [
                        'name' => 'Taller',
                        'icon' => 'fa fa-hammer',
                        'submenu' => [
                            [
                                'name' => 'Servicio de cortesía',
                                'url' => 'activaciones.create',
                            ],
                            [
                                'name' => 'Mantenimiento particular',
                                'url' => 'mantenimiento.create',
                            ],
                            [
                                'name' => 'Mecanicos',
                                'url' => 'mecanico.index',
                            ],
                            [
                                'name' => 'Taller',
                                'url' => 'taller.index',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Productos/Servicios',
                        'icon' => 'fa fa-box',
                        'submenu' => [
                            [
                                'name' => 'Productos',
                                'url' => 'producto.index',
                            ],
                            [
                                'name' => 'Servicios',
                                'url' => 'servicios.index',
                            ],
                            [
                                'name' => 'Categorias',
                                'url' => 'categorias.index',
                            ],
                            [
                                'name' => 'Marcas',
                                'url' => 'marca_producto.index',
                            ],
                            [
                                'name' => 'Zona',
                                'url' => 'zona.index',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Clientes',
                        'icon' => 'fa fa-users',
                        'submenu' => [
                            [
                                'name' => 'Clientes',
                                'url' => 'cliente.index',
                            ],
                            [
                                'name' => 'Tipo',
                                'url' => 'cliente.create',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Vehiculos',
                        'icon' => 'fa fa-motorcycle',
                        'submenu' => [
                            [
                                'name' => 'Vehiculos',
                                'url' => 'moto.index',
                            ],
                            [
                                'name' => 'Nuevo vehiculo',
                                'url' => 'moto.create',
                            ],
                            [
                                'name' => 'Marca Vehiculo',
                                'url' => 'marca.index',
                            ],
                            [
                                'name' => 'Modelo Vehiculo',
                                'url' => 'modelo.index',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Compras',
                        'icon' => 'fa fa-cart-plus',
                        'submenu' => [
                            [
                                'name' => 'Listado',
                                'url' => 'compras.index',
                            ],
                            [
                                'name' => 'Nueva Compra',
                                'url' => 'compras.create',
                            ],
                            [
                                'name' => 'Listado de compras',
                                'url' => 'compras.index',
                            ],
                            [
                                'name' => 'Proveedores',
                                'url' => 'proveedores.index',
                            ],
                        ],
                    ],

                    [
                        'name' => 'Inventario',
                        'icon' => 'fa fa-box-open',
                        'submenu' => [
                            [
                                'name' => 'Movimientos',
                                'url' => 'cliente.index',
                            ],
                            [
                                'name' => 'Devolucion a proveedor',
                                'url' => 'cliente.create',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Caja',
                        'icon' => 'fa fa-cash-register',
                        'submenu' => [
                            ['name' => 'Punto de venta', 'url' => 'pos.create'],
                         ['name' => 'Cajas', 'url' => 'caja.index'], 
                         ['name' => 'Forma de pago', 'url' => 'forma_pago.index'], 
                         ['name' => 'Crear forma de venta', 'url' => 'forma_pago.create']],
                    ],
                    [
                        'name' => 'Usuarios',
                        'icon' => 'fa fa-users',
                        'submenu' => [['name' => 'Usuarios', 'url' => 'users.index'], 
                        ['name' => 'Nuevo usuario', 'url' => 'users.create']],
                    ],

                    [
                        'name' => 'Reportes',
                        'icon' => 'fa fa-chart-pie',
                        'submenu' => [
                            ['name' => 'Punto de venta', 'url' => 'pos.create']],
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
