

<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_vendedor', [App\Http\Controllers\vendedor_controller::class, 'search_vendedor'])->name('search_vendedor'); 

Route::post('/crear_vendedor', [App\Http\Controllers\vendedor_controller::class, 'crear_vendedor'])->name('crear_vendedor'); 