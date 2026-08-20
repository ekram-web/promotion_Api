<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function apiIndex()
    {
        $verses = Hero::where('is_active', true)->orderBy('order')->get();
        $images = \App\Models\HeroImage::first();
        
        $verses->transform(function ($verse) use ($images) {
            $verse->phone_image_1 = $images ? $images->phone_image_1 : null;
            $verse->phone_image_2 = $images ? $images->phone_image_2 : null;
            $verse->phone_image_3 = $images ? $images->phone_image_3 : null;
            return $verse;
        });

        return response()->json($verses);
    }

    // For admin: GET /admin/hero
    public function index()
    {
        $heros = Hero::all();
        $heroImage = \App\Models\HeroImage::first();
        return view('admin.hero.index', compact('heros', 'heroImage'));
    }

    public function updateImages(Request $request)
    {
        $request->validate([
            'phone_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'phone_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
            'phone_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        $heroImage = \App\Models\HeroImage::first() ?? new \App\Models\HeroImage();

        foreach (['phone_image_1', 'phone_image_2', 'phone_image_3'] as $field) {
            if ($request->hasFile($field)) {
                if ($heroImage->$field && Storage::disk('public')->exists($heroImage->$field)) {
                    Storage::disk('public')->delete($heroImage->$field);
                }
                $heroImage->$field = $request->file($field)->store('hero-images', 'public');
            }
        }

        $heroImage->save();

        return redirect()->route('admin.hero.index')->with('persistent_success', 'Hero images updated successfully!');
    }

    public function deleteImage($field)
    {
        if (in_array($field, ['phone_image_1', 'phone_image_2', 'phone_image_3'])) {
            $heroImage = \App\Models\HeroImage::first();
            if ($heroImage && $heroImage->$field) {
                if (Storage::disk('public')->exists($heroImage->$field)) {
                    Storage::disk('public')->delete($heroImage->$field);
                }
                $heroImage->$field = null;
                $heroImage->save();
            }
        }
        return redirect()->route('admin.hero.index')->with('persistent_success', 'Image removed successfully!');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ar' => 'required|string|max:255',
            'en' => 'required|string|max:255',
            'ref' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        try {
            Hero::create($data);
            return redirect()->route('admin.hero.index')->with('persistent_success', 'Hero created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('persistent_error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function show($id)
    {
        $hero = Hero::findOrFail($id);
        return response()->json($hero);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'ar' => 'required|string|max:255',
            'en' => 'required|string|max:255',
            'ref' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        try {
            $hero = Hero::findOrFail($id);

            $hero->update($data);
            return redirect()->route('admin.hero.index')->with('persistent_success', 'Hero updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('persistent_error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $hero = Hero::findOrFail($id);
            $hero->delete();
            return redirect()->route('admin.hero.index')->withSuccess('Hero deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('persistent_error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function create()
    {
        $action = route('admin.hero.store');
        $buttonText = 'Add Hero';
        return view('admin.hero.create', compact('action', 'buttonText'));
    }

    public function edit($id)
    {
        $hero = Hero::findOrFail($id);
        $action = route('admin.hero.update', $hero->id);
        $buttonText = 'Update Hero';
        return view('admin.hero.edit', compact('hero', 'action', 'buttonText'));
    }
} 