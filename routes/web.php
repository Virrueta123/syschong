<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ 

Auth::routes();

include 'web/services.php';

/* ******** mas rutas ************* */

include 'web/cliente.php';

include 'web/marca.php';

include 'web/marca_producto.php';

include 'web/zona.php';

include 'web/moto.php';

include 'web/inventario_moto.php';

include 'web/cotizacion.php';

include 'web/unidades.php';

include 'web/categoria_producto.php';

include 'web/producto.php';
 
include 'web/servicios.php';

include 'web/modelo.php';

include 'web/activaciones.php';

include 'web/tienda.php';

include 'web/vendedor.php';

include 'web/datatables_vue.php';
 
include 'web/poveedores.php';

include 'web/usuarios.php';

include 'web/mantenimiento.php';

include 'web/calendario.php';
 
include 'web/comandos.php';

include 'web/compras.php';

include 'web/ventas.php';

include 'web/reportes.php';

include 'web/forma_pago.php';

include 'web/taller.php';

include 'web/service.php';

include 'web/caja_chica.php';
/* *********************** */


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('cliente', App\Http\Controllers\clienteController::class);

Route::resource('moto', App\Http\Controllers\moto_controller::class);

Route::resource('marca', App\Http\Controllers\marca_controller::class);

Route::resource('modelo', App\Http\Controllers\modelo_controller::class);

Route::resource('zona', App\Http\Controllers\zona_controller::class);

Route::resource('producto', App\Http\Controllers\producto_controller::class);

Route::resource('marca_producto', App\Http\Controllers\marca_producto_controller::class);

Route::resource('accesorios', App\Http\Controllers\accesorios_controller::class);

Route::resource('inventario_moto', App\Http\Controllers\inventario_moto_controller::class);

Route::resource('autorizaciones', App\Http\Controllers\autorizaciones_controller::class);

Route::resource('servicios', App\Http\Controllers\servicios_controller::class);

Route::resource('cotizaciones', App\Http\Controllers\cotizacion_controller::class); 

Route::resource('activaciones', App\Http\Controllers\activaciones_controller::class); 

Route::resource('tiendas', App\Http\Controllers\tiendas_controller::class); 

Route::resource('vendedor', App\Http\Controllers\vendedor_controller::class); 

Route::resource('categorias', App\Http\Controllers\categoria_producto_controller::class); 

Route::resource('pos', App\Http\Controllers\pos_controller::class); 

Route::resource('compras', App\Http\Controllers\compras_controller::class); 

Route::resource('proveedores', App\Http\Controllers\proveedores_controller::class); 

Route::resource('mantenimiento', App\Http\Controllers\mantenimiento_controller::class);

Route::resource('calendario', App\Http\Controllers\calendario_controller::class);

Route::resource('users', App\Http\Controllers\user_controller::class);

Route::resource('ventas', App\Http\Controllers\ventas_controller::class);

Route::resource('caja', App\Http\Controllers\caja_chica_controller::class);

Route::resource('forma_pago', App\Http\Controllers\forma_pago_controller::class);

Route::resource('taller', App\Http\Controllers\taller_controller::class);

Route::resource('mecanico', App\Http\Controllers\mecanicos_controller::class);


include 'web/empresa.php';

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
