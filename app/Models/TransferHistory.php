<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'return_date',
        'return_time',
        'return_amount',
        'transfer_id',
        'auth'
    ];

    public function trasnfer()
    {
        return $this->hasMany(Trasnfer::class);
    }
}
