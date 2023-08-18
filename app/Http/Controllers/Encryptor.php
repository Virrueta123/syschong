<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class Encryptor extends Controller
{
    public static function method()
    {
        return Config::get('app.cipher');
    }

    public static function hash_key()
    {
        return hash('sha256', Str::substr(Config::get('app.key'), 7));
    }
 
    public static function iv()
    {
        $secret_iv = Str::substr(Config::get('app.key'), 7);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        return $iv;
    } 
  

}
