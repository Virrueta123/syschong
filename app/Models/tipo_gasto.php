<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tipo_gasto extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'tipo_gasto';
    public $timestamps = true;
    public $primaryKey = 'tipo_gasto_id';
    protected $fillable = [];
    protected $guarded = [];
}
