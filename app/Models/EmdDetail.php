<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmdDetail extends Model
{
    use HasFactory;

    protected $table = 'emd_details';

    protected $fillable = [
        'project_id',
        'instrument_type',
        'instrument_number',
        'instrument_date',
        'amount',
        'remarks',
        'upload',
        'isReturned',
        'isForfieted',
        'releaseDueDate'
    ];

    // Relationship: Each EMD belongs to one project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
