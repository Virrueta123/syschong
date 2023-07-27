<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $fillable = [];
    protected $guarded = [];
    protected $hidden = [];
    protected $dates = [];
    protected $casts = [];
    protected $appends = [];
}
