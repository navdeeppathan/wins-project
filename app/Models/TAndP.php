<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TAndP extends Model
{
    protected $table = 't_and_p';

    protected $fillable = [
       
         'project_id',
    'date',
    'category',
    'description',
    'paid_to',
    'voucher',
    'quantity',
    'amount',
    'deduction',
    'net_payable',
    'upload',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
}