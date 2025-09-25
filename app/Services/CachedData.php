<?php 

namespace App\Services;
use App\Models\Property;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CachedData
{
    private static $cacheTime = 7; // Cache duration in days
    /**
     * Retrieve data from cache or store it if not present.
     *
     * @param string $key
     * @param \Closure $callback
     * @param int $ttl Time to live in seconds
     * @return mixed
     */
    // public static function remember($key, \Closure $callback, $ttl = 3600)
    // {
    //     return Cache::remember($key, $ttl, $callback);
    // }

    /**
     * Clear a specific cache entry.
     *
     * @param string $key
     * @return void
     */
    public static function forget($key)
    {
        Cache::forget($key);
    }

    public static function getCacheTime()
    {
        return self::$cacheTime * 24 * 60 * 60;
    }

    public static function getProperties()
    {
        return Cache::remember('properties', self::getCacheTime(), function () {
            return Property::with('images')->get();
        });
    }
    
    /**
     * Get all users from cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUsers()
    {
        return Cache::remember('users', self::getCacheTime(), function () {
            return \App\Models\User::all();
        });
    }

    /**
     * Get all inquiries from cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getInquiries()
    {
        return Cache::remember('inquiries', self::getCacheTime(), function () {
            return \App\Models\Inquiry::all();
        });
    }

    /**
     * Get all agents from cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getAgents()
    {
        return Cache::remember('agents', self::getCacheTime(), function () {
            return \App\Models\Agent::all();
        });
    }
    
    /**
     * Get all owners from cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getOwners()
    {
        return Cache::remember('owners', self::getCacheTime(), function () {
            return \App\Models\Owner::all();
        });
    }

    /**
     * Get settings data from cache or database.
     *
     * @return mixed
     */
    public static function getSettings()
    {
        return Cache::remember('settings', self::getCacheTime(), function () {
            return \App\Models\Setting::first();
        });
    }

    /**
     * Clear the settings cache.
     *
     * @return void
     */
    public static function clearSettingsCache()
    {
        Cache::forget('settings');
    }
}