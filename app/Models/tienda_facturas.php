<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tienda_facturas extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'tienda_facturas';
    public $timestamps = true;
    public $primaryKey = 'tienda_facturas_id'; 
    protected $fillable = [];
    protected $guarded = [];

    public function venta()
    {
        return $this->belongsTo(ventas::class, 'venta_id')->withTrashed();
    }

    public function tienda_detalle_factura()
    {
        return $this->hasMany(tienda_detalle_factura::class, 'tienda_facturas_id')->withTrashed();
    }
}
