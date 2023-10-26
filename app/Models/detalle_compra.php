<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_compra extends Model
{
    use HasFactory;
    protected $table = 'detalle_compra';
    public $timestamps = false;
    public $primaryKey = 'detalle_compra_id';
    protected $fillable = [ ];
    protected $guarded = [];
}
