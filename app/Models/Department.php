<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'user_id',
        'name',
    ];

    /**
     * Relationship: A department belongs to a user (optional)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
