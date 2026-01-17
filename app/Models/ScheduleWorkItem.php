<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleWorkItem extends Model
{
    use HasFactory;

    protected $table = 'schedule_work_items';

    protected $fillable = [
        'schedule_work_id',
        'sr_no',
        'description',
        'no_of_items',
        'length',
        'width',
        'height',
        'factor',
        'qty',
    ];

    protected $casts = [
        'no_of_items' => 'integer',
        'length'      => 'decimal:2',
        'width'       => 'decimal:2',
        'height'      => 'decimal:2',
        'factor'      => 'decimal:2',
        'qty'         => 'decimal:2',
    ];

    /**
     * Relationship: Item belongs to Schedule Work
     */
    public function scheduleWork()
    {
        return $this->belongsTo(ScheduleWork::class);
    }

    
}
