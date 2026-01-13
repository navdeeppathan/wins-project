<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'project_id',
        'bill_number',
        'bill_type',
        'bill_date',
        'mb_number',
        'page_number',
        'gross_amount',
        'total_recovery',
        'net_payable',
        'status',
        'approved_by',
        'approved_at',
        'bill_file',
        'remarks',
        'completion_date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(BillingItem::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class,'location','id');
    }

    public function recoveries()
    {
        return $this->hasMany(Recovery::class);
    }


    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function securityDeposits()
    {
        return $this->hasMany(SecurityDeposit::class);
    }

    public function withhelds()
    {
        return $this->hasMany(Withheld::class);
    }

}
