<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cuentas extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'cuentas';
    public $timestamps = true;
    public $primaryKey = 'cuentas_id';
    protected $fillable = [];
    protected $guarded = [];
}
