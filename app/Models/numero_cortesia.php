<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class numero_cortesia extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'numero_cortesia';
    public $timestamps = true;
    public $primaryKey = 'numero_cortesia_id';
    protected $fillable = [];
    protected $guarded = [];
}
