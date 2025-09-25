<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name',
        'email',
        'phone',
        'message'
    ];

    /**
     * Get the property associated with the inquiry.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}