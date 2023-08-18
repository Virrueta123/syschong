<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider; 
use App\Models\empresa;

class EmpresaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('empresa', function () {
            return new empresa();
        });
    }
}