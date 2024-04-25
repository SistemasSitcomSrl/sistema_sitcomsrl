<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = ['name','department', 'direction', 'number_phone', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
}
