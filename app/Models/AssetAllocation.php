<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'movement_type',
        'departure_date',
        'departure_time',
        'return_date',
        'return_time',
        'missing_amount',
        'state',
        'state_create',
        'branch_id',
        'auth',
        'id_worker',
        'id_inventory'
    ];
}
