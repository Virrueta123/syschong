<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class zona extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'zona';
    public $timestamps = true;
    public $primaryKey = 'zona_id';
    protected $fillable = [];
    protected $guarded = [];
}
