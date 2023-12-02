<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class gastos extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'gastos';
    public $timestamps = true;
    public $primaryKey = 'gastos_id';
    protected $fillable = [];
    protected $guarded = [];

    public function gastos_tipo(){
        return $this->belongsTo(tipo_gasto::class,'gastos_tipo_id'); 
    }
    public function pagos(){
        return $this->hasMany(pagos_ventas::class,'gastos_id');
    }
}
