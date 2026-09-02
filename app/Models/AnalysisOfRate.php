<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisOfRate extends Model
{
    use HasFactory;

    protected $table = 'analysis_of_rates';

    protected $fillable = [
        'user_id',
        'item_code',
        'description',
        'unit',
        'material_cost',
        'labour_cost',
        'carriage_cost',
        'machinery_cost',
        'water_charges_percent',
        'contractor_profit_percent',
        'gst_percent',
        'total_rate',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
