<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleWork extends Model
{
    use HasFactory;

    // Specify table name if not following Laravel naming convention
    protected $table = 'schedule_work';

    // Specify the primary key if different from 'id' (optional)
    protected $primaryKey = 'id';

    // Allow mass assignment for these fields
    protected $fillable = [
        'project_id',
        'description',
        'quantity',
        'unit',
        'rate',
        'amount',
        'section_name',
        'measured_quantity',
        'category',
        'inventory_id',
        'dismantals'
    ];

    // If you want to disable timestamps
    // public $timestamps = false;

    // If you want to cast some fields
    protected $casts = [
        'quantity' => 'decimal:2',
        'rate' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    
}
