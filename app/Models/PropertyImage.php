<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'image_path',
        'sort_order'
    ];

    /**
     * Get the property that owns the image.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}