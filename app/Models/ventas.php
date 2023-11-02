<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ventas extends Model
{ 
    use HasFactory,SoftDeletes;
    protected $table = 'ventas';
    public $timestamps = true;
    public $primaryKey = 'venta_id';
    protected $fillable = [];
    protected $guarded = [];

    protected $appends = ['url'];

    public function vendedor( ){
        return $this->belongsTo(User::class,"user_id")->withTrashed();
    }

    public function cliente( ){
        return $this->belongsTo(cliente::class,"cli_id")->withTrashed();
    }

    public function detalle(){ 
        return $this->hasMany(detalle_venta::class,"venta_id");
    }

    public function getUrlAttribute(){
        return encrypt_id($this->cotizacion_id);
    }
    
}
