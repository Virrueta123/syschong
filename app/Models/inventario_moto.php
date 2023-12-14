<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class inventario_moto extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'inventario_moto';
    public $timestamps = true;
    public $primaryKey = 'inventario_moto_id';
    protected $fillable = [];
    protected $guarded = [];

    protected $appends = ['url'];

    public function moto(){
        return $this->belongsTo(motos::class,"mtx_id")->withTrashed();
    }

    public function inventario_autorizaciones(){
        return $this->hasMany(inventario_autorizaciones::class,"inventario_moto_id")->withTrashed();
    }

    public function accesorios_inventario(){
        return $this->hasMany(accesorios_inventario_detalle::class,"inventario_moto_id")->withTrashed();
    }

    public function cortesia(){
        return $this->hasOne(cortesias_activacion::class,"inventario_moto_id")->withTrashed();
    }

    public function cotizacion(){
        return $this->hasOne(cotizacion::class,"inventario_moto_id")->withTrashed();
    }

    public function getUrlAttribute()
    {
        return encrypt_id($this->inventario_moto_id);
    }
   
}
