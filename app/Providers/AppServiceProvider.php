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
                        'name' => 'VENTAS',
                        'icon' => 'fa fa-cart-plus',
                        'submenu' => [
                            [
                                'name' => 'LISTADO DE COMPROBANTES',
                                'url' => 'ventas.index',
                            ],
                            [
                                'name' => 'NOTA DE VENTA ',
                                'url' => 'ventas.notas_venta',
                            ],
                            [
                                'name' => 'OPORTUNIDADES DE VENTA',
                                'url' => 'cliente.create',
                            ],
                            [
                                'name' => 'COTIZACION',
                                'url' => 'cliente.create',
                            ]
                        ],
                    ],

                    [
                        'name' => 'ACTIVACIONES',
                        'icon' => 'fa fa-cart-plus',
                        'submenu' => [
                            [
                                'name' => 'NUEVA ACTIVACION',
                                'url' => 'activaciones.create',
                            ],
                            [
                                'name' => 'LISTADO',
                                'url' => 'cliente.create',
                            ],
                            [
                                'name' => 'CASAS COMERCIALES',
                                'url' => 'cliente.create',
                            ], 
                        ],
                    ],

                     [
                        'name' => 'TALLER',
                        'icon' => 'fa fa-hammer',
                        'submenu' => [
                            [
                                'name' => 'TODA LAS ACTIVACIONES',
                                'url' => 'activaciones.index',
                            ],
                            [
                                'name' => 'NUEVA ACTIVACION',
                                'url' => 'activaciones.create',
                            ],
                            [
                                'name' => 'MANTENIMIENTO PARTICULAR',
                                'url' => 'mantenimiento.create',
                            ],
                            [
                                'name' => 'MECANICOS',
                                'url' => 'cliente.create',
                            ],
                            [
                                'name' => 'TALLER',
                                'url' => 'cliente.create',
                            ]
                        ],
                    ], 
                    [
                        'name' => 'PRODUCTOS/SERVICIOS',
                        'icon' => 'fa fa-box',
                        'submenu' => [
                            [
                                'name' => 'PRODUCTOS',
                                'url' => 'producto.index',
                            ],
                            [
                                'name' => 'SERVICIOS',
                                'url' => 'servicios.index',
                            ],
                            [
                                'name' => 'CATEGORIAS',
                                'url' => 'categorias.index',
                            ],
                            [
                                'name' => 'MARCAS',
                                'url' => 'marca_producto.index',
                            ]
                        ],
                    ],
                    [
                        'name' => 'CLIENTES',
                        'icon' => 'fa fa-users',
                        'submenu' => [
                            [
                                'name' => 'CLIENTES',
                                'url' => 'cliente.index',
                            ],
                            [
                                'name' => 'TIPO',
                                'url' => 'cliente.create',
                            ], 
                        ],
                    ],
                    [
                        'name' => 'VEHICULOS',
                        'icon' => 'fa fa-motorcycle',
                        'submenu' => [ 
                            [
                                'name' => 'VEHICULOS',
                                'url' => 'moto.index',
                            ],
                            [
                                'name' => 'NUEVO VEHICULO',
                                'url' => 'moto.create',
                            ],
                            [
                                'name' => 'MARCA VEHICULO',
                                'url' => 'marca.index',
                            ], 
                            [
                                'name' => 'MODELO VEHICULO',
                                'url' => 'modelo.index',
                            ], 
                        ],
                    ], 
                    [
                        'name' => 'COMPRAS',
                        'icon' => 'fa fa-cart-plus',
                        'submenu' => [
                            [
                                'name' => 'LISTADO',
                                'url' => 'cliente.index',
                            ],
                            [
                                'name' => 'NUEVA COMPRA',
                                'url' => 'cliente.create',
                            ], 
                            [
                                'name' => 'LISTADO DE COMPRAS',
                                'url' => 'cliente.create',
                            ], 
                            [
                                'name' => 'PROVEEDORES',
                                'url' => 'cliente.create',
                            ], 
                        ],
                    ],
                 
            
                    [
                        'name' => 'INVENTARIO',
                        'icon' => 'fa fa-box-open',
                        'submenu' => [
                            [
                                'name' => 'MOVIMIENTOS',
                                'url' => 'cliente.index',
                            ],
                            [
                                'name' => 'DEVOLUCION A PROVEEDOR',
                                'url' => 'cliente.create',
                            ],  
                        ],
                    ],
                    [
                        'name' => 'CAJA',
                        'icon' => 'fa fa-cash-register',
                        'submenu' => [['name' => 'PUNTO DE VENTA', 'url' => 'pos.create'], ['name' => 'cajas', 'url' => 'caja.index'], ['name' => 'FORMA DE PAGO', 'url' => 'forma_pago.index'], ['name' => 'CREAR FORMA DE VENTA', 'url' => 'forma_pago.create']],
                    ],
                    [
                        'name' => 'USUARIOS',
                        'icon' => 'fa fa-users',
                        'submenu' => [['name' => 'USUARIOS', 'url' => 'users.index'], ['name' => 'NUEVO USUARIO', 'url' => 'users.create']],
                    ],

                    [
                        'name' => 'REPORTES',
                        'icon' => 'fa fa-chart-pie',
                        'submenu' => [['name' => 'PUNTO DE VENTA', 'url' => 'pos.create'], ['name' => 'cajas', 'url' => 'caja.index'], ['name' => 'FORMA DE PAGO', 'url' => 'forma_pago.index'], ['name' => 'CREAR FORMA DE VENTA', 'url' => 'forma_pago.create']],
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
