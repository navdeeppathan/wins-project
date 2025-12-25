<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
                'user_id',
               
                'date',
                'category',
                'description',
                'delivered_to',
                'voucher',
                'quantity',
                'amount',
                'deduction',
                'net_payable',
                'upload'
    ];

    
}