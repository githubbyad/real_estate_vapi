<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'user_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
    ];

    /**
     * Get the property associated with the inquiry.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user that owns the inquiry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted() 
    {
        // Clear cache on create, update, delete
        static::created(fn () => cache()->forget('inquiries'));
        static::updated(fn () => cache()->forget('inquiries'));
        static::deleted(fn () => cache()->forget('inquiries'));
    }
}