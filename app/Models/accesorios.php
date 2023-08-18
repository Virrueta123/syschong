<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class accesorios extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'accesorios';
    public $timestamps = true;
    public $primaryKey = 'accesorios_id';
    protected $fillable = [];
    protected $guarded = [];
}
