<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class producto extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'productos';
    public $timestamps = true;
    public $primaryKey = 'prod_id';
    protected $fillable = [];
    protected $guarded = [];
    protected $appends = ['stock'];
  
    public function marca_producto( ){
        return $this->belongsTo(marca_producto::class,"marca_id")->withTrashed();
    }

    public function unidad( ){
        return $this->belongsTo(unidades::class,"unidades_id")->withTrashed();
    }

    public function categoria( ){
        return $this->belongsTo(categoria_producto::class,"categoria_id")->withTrashed(); 
    }

    public function marca( ){
        return $this->belongsTo(marca_producto::class,"marca_id")->withTrashed(); 
    }

    public function zona( ){
        return $this->belongsTo(zona::class,"zona_id")->withTrashed(); 
    }

    public function producto_marcas( ){
        return $this->hasMany(producto_marcas::class,"prod_id");
    }

    public function usuario( ){
        return $this->belongsTo(User::class,"user_id"); 
    }

    public function imagen( ){
        return $this->hasOne(imagen_producto::class,"prod_id")->withTrashed();
    }

    public function getStockAttribute( ){
        $compras = detalle_compra::where('prod_id', $this->prod_id)->sum('cantidad');
        $ventas = detalle_venta::where('prod_id', $this->prod_id)->where('tipo', "p")->sum('Cantidad');
        $stock = $this->prod_stock_inicial + $compras - $ventas   ;
        return $stock; 
    }
}
