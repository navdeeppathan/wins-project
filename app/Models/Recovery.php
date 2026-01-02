<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recovery extends Model
{
    protected $fillable = [
        'billing_id',
        'security',
        'income_tax',
        'labour_cess',
        'water_charges',
        'license_fee',
        'cgst',
        'sgst',
        'withheld_1',
        'withheld_2',
        'total',
        'recovery'
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'id');
    }
    
}
