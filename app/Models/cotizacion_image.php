<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cotizacion_image extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cotizacion_image';
    public $timestamps = true;
    public $primaryKey = 'cotizacion_image_id';
    protected $fillable = [];
    protected $guarded = [];
}
