<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'gst_number',
        'pan_number'
    ];

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }
}