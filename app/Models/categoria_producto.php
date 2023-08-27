<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class categoria_producto extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'categoria';
    public $timestamps = true;
    public $primaryKey = 'categoria_id';
    protected $fillable = [];
    protected $guarded = [];
}
