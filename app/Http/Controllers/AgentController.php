<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Support\Str;
use App\Services\CachedData;
use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Services\RemoveFileService;

class AgentController extends Controller
{
    /* Display a listing of the agents. */
    public function index(CachedData $cachedData)
    {
        // Use cached data to get agents
        $agents = $cachedData->getAgents();

        $data = [
            'title' => 'Agents',
            'subtitle' => 'Manage your agents',
            'icon' => 'bi bi-person-badge',            
            'route_show' => 'agents.show',            
            'route_create' => 'agents.create',
            'route_edit' => 'agents.edit',
            'route_delete' => 'agents.destroy',
            'items' => $agents,
            'pagination' => false,
            'search' => true,
            'footer' => 'Total Agents: ' . $agents->count(),
            'headers' => ['ID', 'Name', 'Email', 'Phone', 'License', 'Agency', 'Status', 'Join Date'],
            'actions' => ['view', 'edit', 'delete'],
        ];

        return view('backend.list', compact('data'));
    }

    /* Show the form for creating a new agent. */
    public function create()
    {
        return view('agents.create');
    }

    /* Store a newly created agent. */
    public function store(Request $request, CachedData $cachedData)
    {
        // Validate input including profile picture
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',            
            'email' => 'required|email|unique:agents,email',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:50',
            'agency_name' => 'nullable|string|max:100',
            'office_address' => 'nullable|string|max:255',
            'join_date' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
        ]);

        // Slug generation
        $validated['slug'] = Str::slug($validated['first_name'] . ' ' . $validated['last_name'], '-') . '-' . time();

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture_url'] = ImageService::processAndSaveImage($request->file('profile_picture'), 'agent');
        }

        // Create the agent
        Agent::create($validated);

        // Clear cache after creating a new agent
        $cachedData::forget('agents');

        return redirect()->route('agents.index');
    }

    /* Display the specified agent. */
    public function show($id, CachedData $cachedData)
    {
        // Find the agent using cached data
        $agent = $cachedData->getAgents()->firstWhere('id', $id);

        if (!$agent) {
            abort(404, 'Agent not found');
        }

        // Return the view with the agent data
        return view('agents.show', compact('agent'));
    }

    /* Show the form for editing the specified agent. */
    public function edit($id, CachedData $cachedData)
    {
        // Find the agent using cached data
        $agent = $cachedData->getAgents()->firstWhere('id', $id);

        if (!$agent) {
            abort(404, 'Agent not found');
        }

        return view('agents.edit', compact('agent'));
    }

    /* Update the specified agent. */
    public function update(Request $request, $id, CachedData $cachedData)
    {
        // Find the agent using cached data
        $agent = $cachedData->getAgents()->firstWhere('id', $id);

        if (!$agent) {
            abort(404, 'Agent not found');
        }

        // Validate input including profile picture
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:50',
            'agency_name' => 'nullable|string|max:100',
            'office_address' => 'nullable|string|max:255',
            'join_date' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
        ]);

        // Slug generation
        $validated['slug'] = Str::slug($validated['first_name'] . ' ' . $validated['last_name'], '-') . '-' . time();

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($agent->profile_picture_url) {
                RemoveFileService::remove('agent', $agent->profile_picture_url);
            }
            $validated['profile_picture_url'] = ImageService::processAndSaveImage($request->file('profile_picture'), 'agent');
        }

        // Update the agent
        $agent->update($validated);

        // Clear cache after updating an agent
        $cachedData::forget('agents');

        return redirect()->route('agents.index');
    }

    /* Remove the specified agent. */
    public function destroy($id, CachedData $cachedData)
    {
        // Find the agent using cached data
        $agent = $cachedData->getAgents()->firstWhere('id', $id);

        if (!$agent) {
            abort(404, 'Agent not found');
        }

        // Delete the agent
        $agent->delete();

        // Delete associated profile picture if exists
        if ($agent->profile_picture_url) {
            RemoveFileService::remove('agent', $agent->profile_picture_url);
        }

        // Clear cache after deleting an agent
        $cachedData::forget('agents');

        return redirect()->route('agents.index');
    }
}