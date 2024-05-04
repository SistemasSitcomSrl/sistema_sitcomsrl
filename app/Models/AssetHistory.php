<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'return_date',
        'return_time',       
        'return_amount',
        'id_movements',
        'auth',
        'updated_at'
    ];
}
