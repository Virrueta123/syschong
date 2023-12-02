<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tipo_cliente extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'tipo_cliente';
    public $timestamps = true;
    public $primaryKey = 'tipo_cliente_id';
    protected $fillable = [];
    protected $guarded = [];

    public function cliente(){
        return $this->hasMany(cliente::class,'tipo_cliente_id');
    }
}
