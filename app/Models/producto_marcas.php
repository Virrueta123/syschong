<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class producto_marcas extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'producto_marcas';
    public $timestamps = true;
    public $primaryKey = 'productos_marcas_id';
    protected $fillable = [];
    protected $guarded = [];
}
