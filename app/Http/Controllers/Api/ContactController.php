<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    // For API: Get the latest contact information for the frontend.
    // GET /api/contact-info
    public function apiIndex()
    {
        // Fetches the MOST RECENTLY added contact record.
        return response()->json(Contact::latest()->first());
    }

    // For admin: Show a list of all contact entries.
    // GET /admin/contact
    public function index()
    {
        // Order by most recent
        $contacts = Contact::latest()->get();
        return view('admin.contact.index', compact('contacts'));
    }

    // For admin: Show the form to create a new contact entry.
    public function create()
    {
        $action = route('admin.contact.store');
        $buttonText = 'Add Contact';
        return view('admin.contact.create', compact('action', 'buttonText'));
    }

    // For admin: Store a new contact entry in the database.
    public function store(Request $request)
    {
        $data = $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'map_embed_url' => 'nullable|string',
            'social_media' => 'nullable|array'
        ]);

        try {
            Contact::create($data);
            return redirect()->route('admin.contact.index')->withSuccess('Contact information created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create contact information: ' . $e->getMessage());
            return back()->withInput()->with('persistent_error', 'An unexpected error occurred. Please try again.');
        }
    }

    // For admin: Show the form to edit an existing contact entry.
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contact.edit', compact('contact'));
    }

    // For admin: Update an existing contact entry.
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'map_embed_url' => 'nullable|string',
            'social_media' => 'nullable|array'
        ]);

        try {
            $contact = Contact::findOrFail($id);
            $contact->update($data);
            return redirect()->route('admin.contact.index')->withSuccess('Contact information updated successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to update contact information: ' . $e->getMessage());
            return back()->withInput()->with('persistent_error', 'An unexpected error occurred. Please try again.');
        }
    }

    // For admin: Delete a contact entry.
    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            return redirect()->route('admin.contact.index')->withSuccess('Contact deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to delete contact: ' . $e->getMessage());
            return back()->with('persistent_error', 'An unexpected error occurred. Please try again.');
        }
    }

    // API method to show a single resource (if needed).
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }
}
