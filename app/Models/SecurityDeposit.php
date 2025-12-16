<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityDeposit extends Model
{
    protected $table = 'security_deposits';

    protected $fillable = [
        'project_id',
        'billing_id',
        'instrument_type',
        'instrument_number',
        'instrument_date',
        'amount',
        'upload',
        'isReturned',
        'isForfeited'
    ];

    protected $casts = [
        'instrument_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /* ================= Relationships ================= */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
