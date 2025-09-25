<?php 

namespace App\Services;
use App\Models\Property;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CachedData
{
    private $cacheTime = 7 * 24 * 60 * 60; // Cache duration in seconds (7 days)
    /**
     * Retrieve data from cache or store it if not present.
     *
     * @param string $key
     * @param \Closure $callback
     * @param int $ttl Time to live in seconds
     * @return mixed
     */
    public static function remember($key, \Closure $callback, $ttl = 3600)
    {
        return Cache::remember($key, $ttl, $callback);
    }

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

    public function getCacheTime()
    {
        return $this->cacheTime;
    }

    public function getProperties()
    {
        return Cache::remember('properties', $this->cacheTime, function () {
            return Property::with('images')->get();
        });
    }
    
    /**
     * Get all users from cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUsers()
    {
        return Cache::remember('users', $this->cacheTime, function () {
            return \App\Models\User::all();
        });
    }

    /**
     * Get all inquiries from cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getInquiries()
    {
        return Cache::remember('inquiries', $this->cacheTime, function () {
            return \App\Models\Inquiry::all();
        });
    }

    /**
     * Get all agents from cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAgents()
    {
        return Cache::remember('agents', $this->cacheTime, function () {
            return \App\Models\Agent::all();
        });
    }
    
    /**
     * Get all owners from cache or database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOwners()
    {
        return Cache::remember('owners', $this->cacheTime, function () {
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
        return Cache::remember('settings', 60 * 60, function () {
            return DB::table('settings')->first();
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

    /**
     * Get the property images cache.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPropertyImages()
    {
        return Cache::remember('property_images', $this->cacheTime, function () {
            return \App\Models\PropertyImage::all();
        });
    }
}