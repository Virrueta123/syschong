<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class proveedores extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'proveedor';
    public $timestamps = true;
    public $primaryKey = 'proveedor_id';
    protected $fillable = [];
    protected $guarded = [];

    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }    
}
