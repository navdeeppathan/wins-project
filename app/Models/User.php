<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name','monthly_salary', 'email','state','designation', 'password', 'parent_id', 'role', 'phone', 'status','gst_number','auth_person_name','date_of_joining','date_of_leaving'
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

    public function children()
    {
        return $this->hasMany(User::class, 'parent_id', 'id');
    }
}
