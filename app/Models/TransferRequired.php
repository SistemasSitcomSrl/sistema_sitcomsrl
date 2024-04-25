<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferRequired extends Model
{
    protected $fillable = [
        'receipt_number',
        'custom_id',
        'amount',
        'image_path',
        'state',
        'state_request',
        'auth',
        'message',
        'message_request',
        'debline_text',
        'id_inventory',
        'branch_id'
    ];
    use HasFactory;
}
