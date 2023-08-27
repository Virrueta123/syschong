<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class producto extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'productos';
    public $timestamps = true;
    public $primaryKey = 'prod_id';
    protected $fillable = [];
    protected $guarded = [];
  
    public function marca_producto( ){
        return $this->belongsTo(marca_producto::class,"marca_prod_id");
    }

    public function unidad( ){
        return $this->belongsTo(unidades::class,"unidades_id");
    }
}
