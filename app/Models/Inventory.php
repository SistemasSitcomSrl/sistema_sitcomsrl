<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'branch_id',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
