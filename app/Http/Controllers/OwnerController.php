<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Support\Str;
use App\Services\CachedData;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Services\RemoveFileService;

class OwnerController extends Controller
{
    /* Display a listing of the owners.
     *
     * @return \Illuminate\View\View
     */
    public function index(CachedData $cachedData)
    {
        // Get owners from cache
        $owners = $cachedData->getOwners();

        $data = [
            'title' => 'Owners',
            'subtitle' => 'Manage property owners',
            'icon' => 'bi bi-people',            
            'route_show' => 'owners.show',            
            'route_create' => 'owners.create',
            'route_edit' => 'owners.edit',
            'route_delete' => 'owners.destroy',
            'items' => $owners,
            'pagination' => false,
            'search' => true,
            'footer' => 'Total Owners: ' . $owners->count(),
            'headers' => ['ID', 'Name', 'Email', 'Properties Owned', 'Date Joined'],
            'actions' => ['view', 'edit', 'delete'],
        ];

        return view('backend.list', compact('data'));
    }

    /* Show the form for creating a new owner. */
    public function create()
    {
        return view('owners.create');
    }

    // Store a newly created owner.
    public function store(Request $request, CachedData $cachedData)
    {
        // Validate input including profile picture
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:owners,email',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // Slug generation
        $validated['slug'] = Str::slug($validated['name'], '-') . '-' . time();

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = ImageService::processAndSaveImage($request->file('profile_picture'), 'owner');
        }

        // Create the owner
        Owner::create($validated);

        // Clear cache after creating a new owner
        $cachedData::forget('owners'); 

        return redirect()->route('owners.index');
    }

    /* Display the specified owner. */
    public function show($id, CachedData $cachedData)
    {
        // Find the owner
        $owner = $cachedData->getOwners()->firstWhere('id', $id);

        // If owner not found, abort
        if (!$owner) {
            abort(404, 'Owner not found');
        }

        return view('owners.show', compact('owner'));
    }

    /* Show the form for editing an owner. */
    public function edit($id, CachedData $cachedData)
    {
        // Find the owner
        $owner = $cachedData->getOwners()->firstWhere('id', $id);

        // If owner not found, abort
        if (!$owner) {
            abort(404, 'Owner not found');
        }

        return view('owners.edit', compact('owner'));
    }

    /* Update the specified owner. */
    public function update(Request $request, $id, CachedData $cachedData)
    {
        // Find the owner
        $owner = $cachedData->getOwners()->firstWhere('id', $id);

        // If owner not found, abort
        if (!$owner) {
            abort(404, 'Owner not found');
        }
        // Validate input including profile picture
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'nullable|email|unique:owners,email,' . $owner->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // Slug generation
        $validated['slug'] = Str::slug($validated['name'], '-') . '-' . time();

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            RemoveFileService::remove('owner',$owner->profile_picture); // Remove old picture
            $validated['profile_picture_url'] = ImageService::processAndSaveImage($request->file('profile_picture'), 'owner');
        }

        // Update the owner
        $owner->update($validated);

        // Clear cache after updating an owner
        $cachedData::forget('owners');

        return redirect()->route('owners.index');
    }

    /* Remove the specified owner. */
    public function destroy($id, CachedData $cachedData)
    {
        // Find the owner
        $owner = $cachedData->getOwners()->firstWhere('id', $id);

        // If owner not found, abort
        if (!$owner) {
            abort(404, 'Owner not found');
        }

        // Delete the owner
        $owner->delete();

        // Delete profile picture if exists
        RemoveFileService::remove('owner', $owner->profile_picture);

        // Clear cache after deleting an owner
        $cachedData::forget('owners');

        return redirect()->route('owners.index');
    }
}