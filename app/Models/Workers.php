<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workers extends Model
{
    use HasFactory;
    protected $table = 'workers';
    protected $fillable = [
        'ci',
        'name',
        'last_name',
        'ubication',
        'phone_number',
        'company_position',
    ];
}
