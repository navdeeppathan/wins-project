<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'plan_name',
        'duration_months',
        'amount',
        'transaction_number',
        'reference_number',
        'payment_screenshot',
        'payment_status',
        'subscription_status',
        'start_date',
        'expiry_date',
        'admin_notes',
        'action_by',
        'action_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'expiry_date' => 'date',
        'action_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'action_by');
    }

    /**
     * Check if this subscription is currently active and unexpired
     */
    public function isValid()
    {
        if ($this->subscription_status !== 'active') {
            return false;
        }

        if (!$this->expiry_date) {
            return false;
        }

        return Carbon::parse($this->expiry_date)->endOfDay()->isFuture();
    }

    /**
     * Remaining days until expiry
     */
    public function getDaysRemainingAttribute()
    {
        if (!$this->expiry_date) {
            return 0;
        }

        $today = Carbon::today();
        $expiry = Carbon::parse($this->expiry_date);

        if ($expiry->isPast()) {
            return 0;
        }

        return $today->diffInDays($expiry, false);
    }
}
