<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/generate-key', function () {
    Artisan::call('key:generate');
    return 'Clave de cifrado generada correctamente.';
});
