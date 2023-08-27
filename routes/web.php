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

/* *********************** */


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('cliente', App\Http\Controllers\clienteController::class);

Route::resource('moto', App\Http\Controllers\moto_controller::class);

Route::resource('marca', App\Http\Controllers\marca_controller::class);

Route::resource('producto', App\Http\Controllers\producto_controller::class);

Route::resource('marca_producto', App\Http\Controllers\marca_producto_controller::class);

Route::resource('accesorios', App\Http\Controllers\accesorios_controller::class);

Route::resource('inventario_moto', App\Http\Controllers\inventario_moto_controller::class);

Route::resource('autorizaciones', App\Http\Controllers\autorizaciones_controller::class);

Route::resource('servicios', App\Http\Controllers\servicios_controller::class);

Route::resource('cotizaciones', App\Http\Controllers\cotizacion_controller::class); 



Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
