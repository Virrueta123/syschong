<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class servicios extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'servicios';
    public $timestamps = true;
    public $primaryKey = 'servicios_id';
    protected $fillable = [];
    protected $guarded = [];
}
