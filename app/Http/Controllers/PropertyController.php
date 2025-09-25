<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Str;
use App\Services\CachedData;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Services\RemoveFileService;

class PropertyController extends Controller
{
    /* Display a listing of the properties */
    public function index(CachedData $cachedData)
    {
        // Get properties and their images from cache
        $properties = $cachedData->getProperties();
        $propertyImages = $cachedData->getPropertyImages();

        return view('properties.index', compact('properties', 'propertyImages'));
    }

    /* Display the specified property */
    public function show($id, CachedData $cachedData)
    {
        // Find the property and its images
        $property = $cachedData->getProperties()->firstWhere('id', $id);
        $propertyImages = $cachedData->getPropertyImages();
        // If property not found, abort
        if (!$property) {
            abort(404, 'Property not found');
        }

        return view('properties.show', compact('property', 'propertyImages'));
    }

    /* Show the form for creating a new property */
    public function create()
    {
        return view('properties.create');
    }

    /* Store a newly created property */
    public function store(Request $request)
    {
        // Validate including images
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'property_type' => 'required|string|in:Residential,Commercial,Industrial,Land,Mixed-Use',
            'agent_id' => 'nullable|exists:agents,id',
            'owner_id' => 'nullable|exists:owners,id',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state_province' => 'required|string|max:100',
            'zip_postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'price' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'area_sqft' => 'nullable|numeric',
            'area_sqm' => 'nullable|numeric',
            'number_of_bedrooms' => 'nullable|integer',
            'number_of_bathrooms' => 'nullable|numeric',
            'year_built' => 'nullable|integer',
            'listing_status' => 'required|string|in:For Sale,For Rent,Sold,Leased,Pending',
            'date_listed' => 'required|date',
            'images' => 'nullable|array', // Validate images array
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate slug
        $validatedData['slug'] = Str::slug($validatedData['title'], '-') . '-' . time();

        // except images
        $validatedData = $request->except('images');
        $property = Property::create($validatedData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = ImageService::processAndSaveImage($image, 'property');
                $property->images()->create(['image_path' => $path]);
            }
        }

        // Clear cache after creating a new property
        self::clearCache();

        return redirect()->route('properties.index')->with('success', 'Property created successfully.');
    }

    /* Show the form for editing a property */
    public function edit($id, CachedData $cachedData)
    {
        // Find the property
        $property = $cachedData->getProperties()->firstWhere('id', $id);

        // If property not found, abort
        if (!$property) {
            abort(404, 'Property not found');
        }

        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, $id, CachedData $cachedData)
    {
        // Find the property
        $property = $cachedData->getProperties()->firstWhere('id', $id);

        // If property not found, abort
        if (!$property) {
            abort(404, 'Property not found');
        }

        // Validate including images
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'property_type' => 'required|string|in:Residential,Commercial,Industrial,Land,Mixed-Use',
            'agent_id' => 'nullable|exists:agents,id',
            'owner_id' => 'nullable|exists:owners,id',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state_province' => 'required|string|max:100',
            'zip_postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'price' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'area_sqft' => 'nullable|numeric',
            'area_sqm' => 'nullable|numeric',
            'number_of_bedrooms' => 'nullable|integer',
            'number_of_bathrooms' => 'nullable|numeric',
            'year_built' => 'nullable|integer',
            'listing_status' => 'required|string|in:For Sale,For Rent,Sold,Leased,Pending',
            'date_listed' => 'required|date',
            'images' => 'nullable|array', // Validate images array
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate slug
        $validatedData['slug'] = Str::slug($validatedData['title'], '-') . '-' . time();

        // Get existing images        
        $propertyImages = $cachedData->getPropertyImages()->where('property_id', $id);

        // except images
        $validatedData = $request->except('images');
        $property->update($validatedData);

        // Handle images (add new, remove old)
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($propertyImages as $image) {
                RemoveFileService::remove('property', $image->image_path);
            }
            // Add new images
            foreach ($request->file('images') as $image) {
                $path = ImageService::processAndSaveImage($image, 'property');
                $property->images()->create(['image_path' => $path]);
            }
        }

        // Clear cache after updating a property
        self::clearCache();

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }

    public function destroy($id, CachedData $cachedData)
    {
        // Find the property and its images
        $property = $cachedData->getProperties()->firstWhere('id', $id);
        $propertyImages = $cachedData->getPropertyImages()->where('property_id', $id);

        // If property not found, abort
        if (!$property) {
            abort(404, 'Property not found');
        }

        // Delete the property
        $property->delete();

        // Delete associated images from storage
        foreach ($propertyImages as $image) {
            RemoveFileService::remove('property', $image->image_path);
        }

        // Clear cache after deleting a property
        self::clearCache();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }

    public function clearCache()
    {
        cache()->forget('properties');
        cache()->forget('property_images');
    }
}
