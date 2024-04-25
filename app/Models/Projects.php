<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $fillable = [
        'cuce',
        'type',
        'object',
        'entity',
        'ubi_entity',
        'ubi_projects',
        'date_opening',
        'date_notification',
        'reference_price',
        'state',
        'id_user',      
    ];
}
