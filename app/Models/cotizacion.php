<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cotizacion extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'cotizacion';
    public $timestamps = true;
    public $primaryKey = 'cotizacion_id';
    protected $fillable = [];
    protected $guarded = [];

    public function inventario( ){
        return $this->belongsTo(inventario_moto::class,"inventario_moto_id")->withTrashed();
    }
    public function mecanico( ){
        return $this->belongsTo(User::class,"mecanico_id")->withTrashed();
    }

    public function detalle( ){
        return $this->hasMany(cotizacioncotizacion_detalle::class,"cotizacion_id")->withTrashed();
    }
    
}
