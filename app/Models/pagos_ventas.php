<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pagos_ventas extends Model
{
    use HasFactory;
    protected $table = 'pagos_ventas';
    public $timestamps = true;
    public $primaryKey = 'pagos_ventas_id';
    protected $fillable = [];
    protected $guarded = [];
}
