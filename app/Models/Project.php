<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'nit_number',
        'department',
        'location',
        'estimated_amount',
        'time_allowed_number',
        'time_allowed_type',
        'emd_amount',
        'emd_type',
        'emd_file',
        'date_of_opening',
        'date_of_start',
        'stipulated_completion',
        'status',
        'created_by',
    ];

    // Project belongs to User
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Project has one Acceptance
    public function acceptance()
    {
        return $this->hasOne(Acceptance::class);
    }

    // Project has one Award
    public function award()
    {
        return $this->hasOne(Award::class);
    }

    // Project has one Agreement
    public function agreement()
    {
        return $this->hasOne(Agreement::class);
    }

    // Project has many Bills
    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    // Project has many Inventory Items
    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    // Project has many Tools & Plants records
    public function tAndP()
    {
        return $this->hasMany(TAndP::class);
    }

    // Attachments (polymorphic)
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
