<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ventas extends Model
{ 
    use HasFactory,SoftDeletes;
    protected $table = 'ventas';
    public $timestamps = true;
    public $primaryKey = 'venta_id';
    protected $fillable = [ ];
    protected $guarded = [];
}
