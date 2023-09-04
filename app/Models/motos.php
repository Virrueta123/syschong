<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class motos extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'motos';
    public $timestamps = true;
    public $primaryKey = 'mtx_id';
    protected $fillable = [];
    protected $guarded = [];

    public function marca( ){
        return $this->belongsTo(marca::class,"marca_id")->withTrashed();
    }

    public function modelo( ){
        return $this->belongsTo(modelo::class,"modelo_id")->withTrashed();
    }
    
    public function cliente(){
        return $this->belongsTo(cliente::class,"cli_id")->withTrashed();
    }
}
