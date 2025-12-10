<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillingItem extends Model
{
    protected $fillable = [
        'billing_id',
        'category',
        'description',
        'quantity',
        'amount',
        'deduction',
        'net_payable'
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
