<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyNote extends Model
{
    use HasFactory;

    // Table name (optional if following Laravel naming convention)
    protected $table = 'daily_notes';

    // The attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'note_date',
        'note_text',
        'amount',
        'paid_to',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'note_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // If you want updated_at to auto-update
    public $timestamps = true;
}
