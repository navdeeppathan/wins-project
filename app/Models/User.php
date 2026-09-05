<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name','monthly_salary','isDefault', 'email','state','designation', 'password', 'parent_id', 'role', 'phone', 'status','gst_number','auth_person_name','date_of_joining','date_of_leaving',
        'plan_id', 'plan_status', 'plan_expires_at'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'plan_expires_at' => 'date',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id')->latest();
    }

    public function currentPlan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    /**
     * Get the active subscription instance for this user or their parent
     */
    public function activeSubscription()
    {
        // If staff, resolve through parent admin
        $targetUserId = ($this->parent_id && in_array($this->role, ['staff', 'employee', 'user'])) ? $this->parent_id : $this->id;

        return Subscription::where('user_id', $targetUserId)
            ->where('subscription_status', 'active')
            ->where('payment_status', 'approved')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '>=', \Carbon\Carbon::today()->toDateString())
            ->latest('expiry_date')
            ->first();
    }

    /**
     * Check if user currently has an active, valid subscription or is superadmin
     */
    public function hasActivePlan(): bool
    {
        if (in_array($this->role, ['super_admin', 'superadmin'])) {
            return true;
        }

        $activeSub = $this->activeSubscription();
        return $activeSub !== null;
    }
}
