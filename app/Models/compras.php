<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class compras extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'compra';
    public $timestamps = true;
    public $primaryKey = 'compra_id';
    protected $fillable = [];
    protected $guarded = [];

    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    } 
    public function proveedor(){
        return $this->belongsTo(proveedores::class,'proveedor_id'); 
    }
    public function detalle(){ 
        return $this->hasMany(detalle_compra::class,"compra_id");
    }
    public function pagos(){
        return $this->hasMany(pagos_ventas::class,"compra_id");
    }
}
