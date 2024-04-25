<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trasnfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'receipt_number',
        'branch_from_id',
        'branch_to_id',
        'user_from_id',
        'user_to_id',
        'departure_date',
        'departure_time',
        'return_date',
        'retur_time',
        'missing_amount',
        'state',
        'id_inventory',     
    ];

    public function trasnferHistory()
    {
        return $this->hasMany(TransferHistory::class);
    }
}
