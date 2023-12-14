<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class inventario_autorizaciones extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'inventario_autorizaciones';
    public $timestamps = false;
    public $primaryKey = 'inventario_autorizaciones_id';
    protected $fillable = [];
    protected $guarded = [];

    public function autorizaciones( ){
        return $this->belongsTo(autorizaciones::class,"aut_id")->withTrashed();
    }
}
