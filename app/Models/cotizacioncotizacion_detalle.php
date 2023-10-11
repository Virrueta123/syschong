<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cotizacioncotizacion_detalle extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'cotizacion_detalle';
    public $timestamps = true;
    public $primaryKey = 'cotizacion_detalle_id';
    protected $fillable = [];
    protected $guarded = [];

    public function servicio( ){
        return $this->belongsTo(servicios::class,"servicios_id")->withTrashed();
    }

    public function getAprobarAttribute($value)
    {
        
        // Modifica el valor del atributo 'name' antes de que se retorne
        if ($value == "Y") {
            return true;
        } else { 
            return false;
        }
        
         // En este ejemplo, se convierte a mayúsculas
    }


    public function producto( ){
        return $this->belongsTo(producto::class,"prod_id")->withTrashed();
    }
 
}
