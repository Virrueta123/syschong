<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cotizacion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cotizacion';
    public $timestamps = true;
    public $primaryKey = 'cotizacion_id';
    protected $fillable = [];
    protected $guarded = [];

    protected $appends = ['url',"lubricante","venta"];

    public function inventario()
    {
        return $this->belongsTo(inventario_moto::class, 'inventario_moto_id')->withTrashed();
    }
    public function mecanico()
    {
        return $this->belongsTo(User::class, 'mecanico_id')->withTrashed();
    }


    public function cotizacion_image()
    {
        return $this->hasOne(cotizacion_image::class, 'cotizacion_id');
    }

    public function detalle()
    {
        return $this->hasMany(cotizacioncotizacion_detalle::class, 'cotizacion_id');
    }

    public function getUrlAttribute()
    {
        return encrypt_id($this->cotizacion_id);
    }

     public function getLubricanteAttribute()
    {
        $text_lubricante ="";
        $lubricantes = cotizacioncotizacion_detalle::with(['servicio',
                    'producto' => function ($query) {
                        $query->with(['unidad']);
                    },])->where("cotizacion_id",$this->cotizacion_id)->where("aprobar","Y")->get();
        foreach ($lubricantes as $lb) {
            if($lb->servicios_id==0){
                if($lb->producto->unidades_id==65){
                    $text_lubricante.=$lb->Cantidad ."-".$lb->Descripcion." /";
                }
            }
        }
        return $text_lubricante;
    }

    public function ventas(){
        return $this->belongsTo(ventas::class, 'venta_id');
    }

     public function getVentaAttribute()
    {  
        return encrypt_id($this->venta_id);
    }
}
