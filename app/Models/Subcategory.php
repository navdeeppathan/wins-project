<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'subcategories';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship: Subcategory belongs to category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}