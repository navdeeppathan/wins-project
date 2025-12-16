<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'nit_number',
        'name',
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
        'isQualified',
        'isReturned',
        'acceptance_upload',
        'tendered_amount',
        'acceptance_letter_no',
        'date',
        'award_letter_no',
        'award_date',
        'award_upload',
        'agreement_upload',
        'agreement_start_date',
        'agreement_no',
        'stipulated_date_ofcompletion',
        'isForfitted',
        'total_work_done',
        'total_work_tobe_done'
        
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

    public function emds()
    {
        return $this->hasMany(EmdDetail::class);
    }

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class,'location','id');
    }

    public function pgDetails()
    {
        return $this->hasMany(PgDetail::class, 'project_id');
    }

    public function securityDeposits()
{
    return $this->hasMany(SecurityDeposit::class);
}


}
