<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'return_date',
        'return_time',
        'category',
        'return_amount',
        'id_movements',
        'auth',
        'updated_at'
    ];
}
