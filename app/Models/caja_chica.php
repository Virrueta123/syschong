<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class caja_chica extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'caja_chica';
    public $timestamps = true;
    public $primaryKey = 'caja_chica_id';
    protected $fillable = [];
    protected $guarded = [];

    public function usuario( ){
        return $this->belongsTo(User::class,"user_id"); 
    }
    public function pagos()
    {
        return $this->hasMany(pagos_ventas::class,"caja_chica_id");
    }
    
    public function compras()
    {
        return $this->hasMany(compras::class,"caja_chica_id");
    }

    public function ventas()
    {
        return $this->hasMany(ventas::class,"caja_chica_id");
    }
    public function gastos()
    {
        return $this->hasMany(gastos::class,"caja_chica_id");
    }
}
