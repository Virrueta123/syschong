<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class detalle_venta extends Model
{
    use HasFactory; 
    protected $table = 'detalle_venta';
    public $timestamps = false;
    public $primaryKey = 'detalle_venta_id';
    protected $fillable = [ ];
    protected $guarded = [];

    public function servicio( ){
        return $this->belongsTo(servicios::class,"servicios_id")->withTrashed();
    }
 
    public function producto( ){
        return $this->belongsTo(producto::class,"prod_id")->withTrashed();
    }
}
