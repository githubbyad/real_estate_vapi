<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'price',
        'bedrooms',
        'bathrooms',
        'square_feet',
        'lot_size',
        'property_type',
        'status',
        'year_built',
        'agent_id',
        'owner_id'
    ];

    /**
     * Get the images for the property, ordered by sort_order.
     */
    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }
}