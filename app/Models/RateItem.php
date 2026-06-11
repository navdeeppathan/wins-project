<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateItem extends Model
{
    use HasFactory;

    protected $table = 'rate_items';

    protected $fillable = [
        'rate_types',
        'department',
        'category_name',
        'code_no',
        'description',
        'unit',
        'basic_rate',
        'effective_date',
    ];

    protected $casts = [
        'basic_rate' => 'decimal:2',
        'effective_date' => 'date',
    ];
}