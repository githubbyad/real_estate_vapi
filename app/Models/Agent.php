<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'slug',
        'email',
        'phone_number',
        'license_number',
        'agency_name',
        'office_address',
        'join_date',
        'is_active',
        'profile_picture_url',
        'bio'
    ];

    /**
     * Get the properties managed by the agent.
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    protected static function booted() 
    {
        // Clear cache on create, update, delete
        static::created(fn () => cache()->forget('agents'));
        static::updated(fn () => cache()->forget('agents'));
        static::deleted(fn () => cache()->forget('agents'));
    }
}