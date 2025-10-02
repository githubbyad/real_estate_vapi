<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Owner extends Model
{
    use HasFactory;

    protected $primaryKey = 'owner_id';

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'profile_picture',
        'address',
        'bio'
    ];

    protected static function booted()
    {
        parent::booted();

        // Clear cache on create, update, delete
        static::created(fn () => cache()->forget('owners'));
        static::updated(fn () => cache()->forget('owners'));
        static::deleted(fn () => cache()->forget('owners'));

        // Automatically generate slug from name
        static::creating(function ($owner) {
            if (empty($owner->slug)) {
                $owner->slug = Str::slug($owner->name);
            }
        });

        // Automatically update slug if name changes
        static::updating(function ($owner) {
            if ($owner->isDirty('name')) {
                $owner->slug = Str::slug($owner->name);
            }
        });
    }
}