<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class marca_producto extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'marca_producto';
    public $timestamps = true;
    public $primaryKey = 'marca_prod_id';
    protected $fillable = [];
    protected $guarded = [];
}
