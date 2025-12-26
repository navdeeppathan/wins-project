<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PgDetail extends Model
{
    protected $table = 'pg_details';

    protected $fillable = [
        'project_id',
        'instrument_type',
        'instrument_number',
        'instrument_date',
        'amount',
        'upload',
        'isReturned',
        'isForfieted',
        'instrument_valid_upto'
    ];

    // Laravel will manage these automatically
    public $timestamps = true;

    /**
     * Relationship: PG Detail belongs to a Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
