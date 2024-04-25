<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransfersInventories extends Model
{
    protected $fillable = [
        'id_inventory',
        'custom_id',
        'receipt_number',
        'name_equipment',
        'bar_Code',
        'brand',
        'color',
        'amount',
        'location',
        'unit_measure',
        'price',
        'type',
        'image_path',
        'departure_date',
        'departure_time',
        'state',
        'state_exist',
        'state_create',
        'branch_id',
        'auth',
        'updated_at'
    ];
    use HasFactory;
}
