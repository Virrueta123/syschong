<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class imagen_producto extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'imagen_producto';
    public $timestamps = true;
    public $primaryKey = 'imagen_producto_id';
    protected $fillable = [];
    protected $guarded = [];
}
