<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withheld extends Model
{
    use HasFactory;

    protected $table = 'withheld'; // Optional if table name matches model pluralization

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'billing_id',
        'instrument_type',
        'instrument_number',
        'instrument_date',
        'amount',
        'upload',
        'isReturned',
        'isForfeited',
        'releaseDueDate'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'instrument_date' => 'date',
        'amount' => 'decimal:2',
        'isReturned' => 'boolean',
        'isForfeited' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
