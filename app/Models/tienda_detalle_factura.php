<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tienda_detalle_factura extends Model
{ 
    use HasFactory,SoftDeletes;
    protected $table = 'tienda_detalle_factura';
    public $timestamps = true;
    public $primaryKey = 'tienda_detalle_factura_id'; 
    protected $guarded = [];

    public function activaciones(){
        return $this->belongsTo(activaciones::class,'activaciones_id'); 
    }
    public function cortesias_activacion(){
        return $this->belongsTo(cortesias_activacion::class,'cortesia_activacion_id'); 
    }
}
