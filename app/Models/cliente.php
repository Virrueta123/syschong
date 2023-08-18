<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cliente extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'cliente';
    public $timestamps = true;
    public $primaryKey = 'cli_id';
    protected $fillable = [];
    protected $guarded = [];
    
}
