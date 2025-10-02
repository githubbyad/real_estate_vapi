<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = \App\Models\Setting::first();

        $data = [
            'title' => 'Site Settings',
            'icon' => 'bi bi-gear',
            'subtitle' => 'Manage your site settings',
            'form_action' => route('settings.update'),            
            'form_method' => 'PUT',                        
            'form_fields' => [
                ['label' => 'Site Name', 'name' => 'site_name', 'type' => 'text', 'value' => $settings->site_name ?? '', 'required' => true, 'attributes' => ['maxlength' => 255]],
                ['label' => 'Contact Email', 'name' => 'contact_email', 'type' => 'email', 'value' => $settings->contact_email ?? '', 'required' => true, 'attributes' => ['maxlength' => 255]],
                ['label' => 'Contact Phone', 'name' => 'contact_phone', 'type' => 'text', 'value' => $settings->contact_phone ?? '', 'required' => true, 'attributes' => ['maxlength' => 20]],
                ['label' => 'Address', 'name' => 'address', 'type' => 'textarea', 'value' => $settings->address ?? '', 'required' => true, 'attributes' => ['maxlength' => 500]],
            ],
            'button_text' => 'Update Settings',
            'cancel' => [
                'text' => 'Cancel',
                'url' => route('dashboard'),
            ],
        ];

        return view('backend.form', compact('data'));
    }   

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $settings = \App\Models\Setting::first();
        if (!$settings) {
            $settings = new \App\Models\Setting();
        }

        $settings->update($validatedData);

        // Clear cache after updating settings
        cache()->forget('settings');

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
