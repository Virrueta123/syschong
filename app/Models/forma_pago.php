<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class forma_pago extends Model
{ 
    use HasFactory,SoftDeletes;
    protected $table = 'forma_pago';
    public $timestamps = true;
    public $primaryKey = 'forma_pago_id';
    protected $fillable = [ ];
    protected $guarded = [];
}
