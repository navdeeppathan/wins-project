<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlinthAreaRate extends Model
{
    use HasFactory;

    protected $table = 'plinth_area_rates';

    protected $fillable = [
        'user_id',
        'category',
        'building_type',
        'no_of_storeys',
        'plinth_area',
        'unit',
        'basic_rate',
        'cost_index',
        'effective_rate',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
