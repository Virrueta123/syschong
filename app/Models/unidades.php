<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class unidades extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'unidades';
    public $timestamps = true;
    public $primaryKey = 'unidades_id';
    protected $fillable = [];
    protected $guarded = [];
}
