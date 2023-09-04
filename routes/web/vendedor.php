

<?php

use Illuminate\Support\Facades\Route;

Route::post('/search_vendedor', [App\Http\Controllers\vendedor_controller::class, 'search_vendedor'])->name('search_vendedor'); 