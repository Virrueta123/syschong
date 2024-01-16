<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pagos_ventas extends Model
{
    use HasFactory;
    protected $table = 'pagos_ventas';
    public $timestamps = true;
    public $primaryKey = 'pagos_ventas_id';
    protected $fillable = [];
    protected $guarded = [];

    public function ventas(){
        return $this->belongsTo(ventas::class, 'ventas_id'); 
    }

    public function gastos(){
        return $this->belongsTo(gastos::class, 'gastos_id'); 
    }

    public function compra(){
        return $this->belongsTo(compras::class, 'compra_id'); 
    }
    public function forma_pago(){
        return $this->belongsTo(forma_pago::class, 'forma_pago_id');  
    }

    public function img(){
        return $this->belongsTo(image_pago::class, 'pagos_ventas_id');  
    }
}
