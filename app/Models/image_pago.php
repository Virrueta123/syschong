<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image_pago extends Model
{
    use HasFactory; 
    protected $table = 'image_pago';
    public $timestamps = false;
    public $primaryKey = 'image_pago_id';
    protected $fillable = [];
    protected $guarded = [];
}
