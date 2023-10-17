<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa';
    public $timestamps = false;
    public $primaryKey = 'empresa_id';
    protected $fillable = [];
    protected $guarded = [];

    public function ruc()
    {
        return $this::where('active', "A")->first()->ruc;
    }

    public function celular()
    {
        return $this::where('active', "A")->first()->celular;
    }

    public function razon_social()
    {
        return $this::where('active', "A")->first()->razon_social;
    }

    public function direccion()
    {
        return $this::where('active', "A")->first()->direccion;
    } 

    public function declaracion()
    {
        return $this::where('active', "A")->first()->declaracion;
    } 

    public function token_whatsapps_api(){
        return $this::where('active', "A")->first()->token_whatsapps_api;
    }

    public function codigo_telefono(){
        return $this::where('active', "A")->first()->codigo_telefono;
    }
}
