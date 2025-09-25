<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    protected static function booted() 
    {
        // Clear cache on create, update, delete
        static::created(fn () => cache()->forget('settings'));
        static::updated(fn () => cache()->forget('settings'));
        static::deleted(fn () => cache()->forget('settings'));
    }
}