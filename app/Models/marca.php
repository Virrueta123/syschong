<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class marca extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'marca';
    public $timestamps = true;
    public $primaryKey = 'marca_id';
    protected $fillable = [];
    protected $guarded = [];
}
