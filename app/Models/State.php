<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';

    protected $fillable = [
        'name',
    ];

    // If you want, you can disable timestamps manually, 
    // but since you have created_at/updated_at, it's okay to leave them.
}
