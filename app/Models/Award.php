<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = [
        'project_id',
        'award_letter_no',
        'award_date',
        'awarded_amount',
        'award_file'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}