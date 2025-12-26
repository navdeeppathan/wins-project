<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correspondence extends Model
{
    protected $table = 'correspondences';

    protected $fillable = [
        'project_id',
        'letter_subject',
        'letter_date',
        'upload',
    ];

    protected $casts = [
        'letter_date' => 'date',
    ];

    /**
     * Relation: Correspondence belongs to Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
