<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accesorios_inventario_detalle extends Model
{
    use HasFactory;
    protected $table = 'accesorios_inventario_detalle';
    public $timestamps = false;
    public $primaryKey = 'accesorios_inventario_detalle_id';
    protected $fillable = [];
    protected $guarded = [];

    public function accesorios( ){
        return $this->belongsTo(accesorios::class,"accesorios_inventario_id");
    }
    
}
