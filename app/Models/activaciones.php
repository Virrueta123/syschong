<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class activaciones extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'activaciones';
    public $timestamps = true;
    public $primaryKey = 'activaciones_id';
    protected $fillable = [];
    protected $guarded = [];

    public function moto(){
        return $this->belongsTo(motos::class,'moto_id')->withTrashed();
    }

    public function cortesias(){
        return $this->hasMany(cortesias_activacion::class,'activaciones_id') ;
    }

    public function tienda(){
        return $this->belongsTo(tiendas::class,'tienda_id')->withTrashed();
    }

    public function tcobrar(){
        return $this->belongsTo(tiendas::class,'tienda_cobrar')->withTrashed();
    }


    public function vendedor(){
        return $this->belongsTo(vendedor::class,'vendedor_id')->withTrashed();
    }
}
