<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = [
        'project_id',
        'agreement_no',
        'agreement_date',
        'start_date',
        'time_allowed_number',
        'time_allowed_type',
        'agreement_file'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
