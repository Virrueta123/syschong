<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalle_compra extends Model
{
    use HasFactory;
    protected $table = 'detalle_compra';
    public $timestamps = true;
    public $primaryKey = 'detalle_compra_id';
    protected $fillable = [ ];
    protected $guarded = [];

    public function producto(){
        return $this->belongsTo(producto::class,"prod_id")->withTrashed();
    }
    public function zona(){
        return $this->belongsTo(zona::class,"zona_id")->withTrashed();
    }
    public function compra(){
        return $this->belongsTo(compras::class,"compra_id")->withTrashed();
    }
}
