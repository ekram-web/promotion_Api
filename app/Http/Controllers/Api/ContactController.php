<?php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // For API: GET /api/contact-info
    public function apiIndex()
    {
        $contact = Contact::first();
        if (!$contact) {
            return response()->json(null);
        }
        // Return mapUrl for frontend compatibility
        return response()->json([
            'address' => $contact->address,
            'phone' => $contact->phone,
            'email' => $contact->email,
            'website' => $contact->website,
            'mapUrl' => $contact->map_embed_url,
            'social_media' => $contact->social_media,
            'working_hours' => $contact->working_hours,
        ]);
    }

    // For admin: GET /admin/contact
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contact.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'map_embed_url' => 'nullable|string',
            'social_media' => 'nullable|array',
            'working_hours' => 'nullable|array',
        ]);
        try {
            Contact::create($data);
            return redirect()->route('admin.contact.index')->withSuccess('Contact information created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('persistent_error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'map_embed_url' => 'nullable|string',
            'social_media' => 'nullable|array',
            'working_hours' => 'nullable|array',
        ]);
        try {
            $contact = Contact::findOrFail($id);
            $contact->update($data);
            return redirect()->route('admin.contact.index')->withSuccess('Contact information updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('persistent_error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return redirect()->route('admin.contact.index')->withSuccess('Contact deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('persistent_error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function create()
    {
        $action = route('admin.contact.store');
        $buttonText = 'Add Contact';
        return view('admin.contact.create', compact('action', 'buttonText'));
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contact.edit', compact('contact'));
    }
}
