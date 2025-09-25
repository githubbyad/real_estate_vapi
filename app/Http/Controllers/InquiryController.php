<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;
use App\Services\CachedData;

class InquiryController extends Controller
{
    public function index(CachedData $cachedData)
    {
        $inquiries = $cachedData->getInquiries();
        return view('inquiries.index', compact('inquiries'));
    }

    public function show($id, CachedData $cachedData)
    {
        $inquiry = $cachedData->getInquiries()->firstWhere('id', $id);

        if (!$inquiry) {
            abort(404, 'Inquiry not found');
        }

        return view('inquiries.show', compact('inquiry'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Inquiry::create($validatedData);

        // Clear cache after creating a new inquiry
        cache()->forget('inquiries');

        return redirect()->back()->with('success', 'Inquiry submitted successfully.');
    }

    public function edit($id, CachedData $cachedData)
    {
        $inquiry = $cachedData->getInquiries()->firstWhere('id', $id);

        if (!$inquiry) {
            abort(404, 'Inquiry not found');
        }

        return view('inquiries.edit', compact('inquiry'));
    }

    public function update(Request $request, $id, CachedData $cachedData)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:New,In Progress,Closed',
        ]);

        $inquiry = $cachedData->getInquiries()->firstWhere('id', $id);

        if (!$inquiry) {
            abort(404, 'Inquiry not found');
        }

        $inquiry->update($validatedData);

        // Clear cache after updating an inquiry
        cache()->forget('inquiries');

        return redirect()->route('inquiries.index')->with('success', 'Inquiry updated successfully.');
    }
}