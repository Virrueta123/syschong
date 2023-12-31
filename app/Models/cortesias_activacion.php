<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cortesias_activacion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cortesias_activacion';
    public $timestamps = true;
    public $primaryKey = 'cortesias_activacion_id';
    protected $fillable = [];
    protected $guarded = [];

    public function activaciones()
    {
        return $this->belongsTo(activaciones::class, 'activaciones_id');
    }

    public function mecanico()
    {
        return $this->belongsTo(User::class, 'mecanico_id');
    }

    public function tcobrar()
    {
        return $this->belongsTo(tiendas::class, 'tienda_cobrar');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(cotizacion::class, 'cotizacion_id');
    }
}
