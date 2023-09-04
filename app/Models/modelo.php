<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class modelo extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'modelo';
    public $timestamps = true;
    public $primaryKey = 'modelo_id';
    protected $fillable = [];
    protected $guarded = [];

    public function marca(){
        return $this->belongsTo(marca::class,'marca_id')->withTrashed();
    }

}
