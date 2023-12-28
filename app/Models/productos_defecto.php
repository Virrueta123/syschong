<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productos_defecto extends Model
{ 
    use HasFactory,SoftDeletes;
    protected $table = 'productos_defecto';
    public $timestamps = true;
    public $primaryKey = 'productos_defecto_id';
    protected $fillable = [];
    protected $guarded = [];

    public function producto()
    { 
        return $this->belongsTo(producto::class,'prod_id')->withTrashed();
    }
}
