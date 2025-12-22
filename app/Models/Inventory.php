<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $fillable = [
        'project_id',
        'vendor_id',
        'item_name',
        'sku',
        'quantity',
        'remarks'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}