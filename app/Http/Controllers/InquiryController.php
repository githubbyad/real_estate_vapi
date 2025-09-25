<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Inquiry::create($request->all());

        return redirect()->back()->with('success', 'Inquiry sent successfully!');
    }
}