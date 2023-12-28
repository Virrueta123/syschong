<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class servicios_defecto extends Model
{ 
    use HasFactory,SoftDeletes;
    protected $table = 'servicios_defecto';
    public $timestamps = true;
    public $primaryKey = 'servicios_defecto_id';
    protected $fillable = [];
    protected $guarded = [];

    public function servicio()
    { 
        return $this->belongsTo(servicios::class,'servicios_id')->withTrashed();
    }
}
