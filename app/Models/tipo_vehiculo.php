<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tipo_vehiculo extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'tipo_vehiculo';
    public $timestamps = true;
    public $primaryKey = 'tipo_vehiculo_id';
    protected $fillable = [];
    protected $guarded = [];
    
}
