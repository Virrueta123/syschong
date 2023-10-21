<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_venta extends Model
{
    use HasFactory; 
    protected $table = 'detalle_venta';
    public $timestamps = false;
    public $primaryKey = 'detalle_venta_id';
    protected $fillable = [ ];
    protected $guarded = [];
}
