<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        // Clear cache on create, update, delete
        static::created(fn () => cache()->forget('owners'));
        static::updated(fn () => cache()->forget('owners'));
        static::deleted(fn () => cache()->forget('owners'));
    }
}