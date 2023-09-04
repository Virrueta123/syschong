<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class activacion_precio extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'activacion_precio';
    public $timestamps = true;
    public $primaryKey = 'activacion_precio_id';
    protected $fillable = [];
    protected $guarded = [];

    public function modelo(){
        return $this->belongsTo(modelo::class, 'modelo_id')->withTrashed();
    }

}
