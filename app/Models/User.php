<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'status'
    ];

    protected $hidden = ['password'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'created_by');
    }
}