<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class autorizaciones extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'autorizaciones';
    public $timestamps = true;
    public $primaryKey = 'aut_id';
    protected $fillable = [];
    protected $guarded = [];
}
