<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marca extends Model
{
    use HasFactory;
    protected $table = 'marca';
    public $timestamps = true;
    public $primaryKey = 'marca_id';
    protected $fillable = [];
    protected $guarded = [];
}
