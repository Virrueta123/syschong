<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class producto_modelo extends Model
{ 
    use HasFactory,SoftDeletes;
    protected $table = 'producto_modelo';
    public $timestamps = true;
    public $primaryKey = 'producto_modelo_id';
    protected $fillable = [];
    protected $guarded = [];

    public function modelo( ){
        return $this->hasMany(modelo::class,"modelo_id");
    }
}
