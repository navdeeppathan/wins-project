<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acceptance extends Model
{
    protected $fillable = [
        'project_id',
        'acceptance_letter_no',
        'acceptance_date',
        'acceptance_file',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
