<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tiendas extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'tienda';
    public $timestamps = true;
    public $primaryKey = 'tienda_id'; 
    protected $guarded = [];

    public function precios(){
        return $this->hasMany(activacion_precio::class, 'tienda_id')->withTrashed();
    }
}
