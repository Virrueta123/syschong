<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class vendedor extends Model
{ 
    use HasFactory,SoftDeletes;
    protected $table = 'vendedor';
    public $timestamps = true;
    public $primaryKey = 'vendedor_id';
    protected $fillable = [];
    protected $guarded = [];
}
