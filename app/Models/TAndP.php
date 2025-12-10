<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TAndP extends Model
{
    protected $table = 't_and_p';

    protected $fillable = [
        'project_id',
        'expense_date',
        'category',
        'description',
        'paid_to',
        'voucher_no',
        'quantity',
        'amount',
        'deduction',
        'net_payable',
        'file'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
}