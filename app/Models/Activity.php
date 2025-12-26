<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'project_id',
        'activity_name',
        'from_date',
        'to_date',
        'weightage',
        'progress',
        'user_id'
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date'   => 'date',
        'weightage' => 'integer',
        'progress'  => 'integer',
    ];
}
