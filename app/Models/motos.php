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
        protected $appends = ["cortesia"];

    public function marca( ){
        return $this->belongsTo(marca::class,"marca_id")->withTrashed();
    }
    public function getCortesiaAttribute( ){
        
        $get = cortesias_activacion::where('mtx_id', $this->mtx_id)->get();

        if ($get) {
          $maximo = cortesias_activacion::where('mtx_id', $this->mtx_id)->max('numero_corterisa');
          return $maximo;
        } else { 
            return 1;
        }  
    }

    public function modelo( ){
        return $this->belongsTo(modelo::class,"modelo_id")->withTrashed();
    }
    
    public function cliente(){
        return $this->belongsTo(cliente::class,"cli_id")->withTrashed();
    }
}
