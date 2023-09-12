<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class compras extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'compra';
    public $timestamps = true;
    public $primaryKey = 'compra_id';
    protected $fillable = [];
    protected $guarded = [];
}
