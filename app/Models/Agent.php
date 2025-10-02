<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

        // Automatically generate slug from first and last name
        static::creating(function ($agent) {
            if (empty($agent->slug)) {
                $agent->slug = Str::slug($agent->first_name . ' ' . $agent->last_name);
            }
        });

        // Automatically update slug if first or last name changes
        static::updating(function ($agent) {
            if ($agent->isDirty('first_name') || $agent->isDirty('last_name')) {
                $agent->slug = Str::slug($agent->first_name . ' ' . $agent->last_name);
            }
        });
    }
}