<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'parent_id', 'role', 'phone', 'status','gst_number','auth_person_name'
    ];

    protected $hidden = ['password'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}