<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ubigeo extends Model
{
    use HasFactory;
    protected $table = 'ubigeo';
    public $timestamps = true;
    public $primaryKey = 'ubigeo_id';
    protected $fillable = [];
    protected $guarded = [];
}
