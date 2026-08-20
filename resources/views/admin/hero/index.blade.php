@extends('admin.layouts.app')

@section('content')
    <div class="mt-10 mb-6 px-6 w-full">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Hero Slides</h1>
            <a href="{{ route('admin.hero.create') }}"
               class="inline-block px-5 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition font-semibold">
                Add New Hero
            </a>
        </div>
        <div class="overflow-x-auto rounded-lg shadow bg-white p-6 mt-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-extrabold text-blue-900 uppercase tracking-wider whitespace-nowrap">Arabic Verse</th>
                        <th class="px-6 py-3 text-left text-xs font-extrabold text-blue-900 uppercase tracking-wider whitespace-nowrap">Translation</th>
                        <th class="px-6 py-3 text-left text-xs font-extrabold text-blue-900 uppercase tracking-wider whitespace-nowrap">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-extrabold text-blue-900 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-extrabold text-blue-900 uppercase tracking-wider whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($heros as $hero)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4 align-top text-gray-800 text-sm" style="direction: rtl;">{{ $hero->ar }}</td>
                            <td class="px-6 py-4 align-top text-gray-800 text-sm">{{ $hero->en }}</td>
                            <td class="px-6 py-4 align-top text-gray-800 text-sm">{{ $hero->order }}</td>
                            <td class="px-6 py-4 align-top">
                                @if($hero->is_active)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">Active</span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <a href="{{ route('admin.hero.edit', $hero->id) }}" class="inline-flex items-center justify-center mr-2 p-1 rounded hover:bg-blue-100 transition" aria-label="Edit" title="Edit">
                                    <span class="material-icons text-blue-600 text-lg align-middle">edit</span>
                                </a>
                                <div x-data="{ open: false, showAbove: false }" class="inline relative">
                                    <button type="button" @click="
                                        open = true;
                                        $nextTick(() => {
                                            const btn = $el.querySelector('button');
                                            const rect = btn.getBoundingClientRect();
                                            showAbove = (window.innerHeight - rect.bottom) < 220;
                                            const popover = $el.querySelector('.delete-popover');
                                            if (popover) {
                                                popover.scrollIntoView({ behavior: 'smooth', block: showAbove ? 'end' : 'start' });
                                            }
                                        });
                                    " class="inline-flex items-center justify-center p-1 rounded hover:bg-red-100 transition" aria-label="Delete" title="Delete">
                                        <span class="material-icons text-red-600 text-lg align-middle">delete</span>
                                    </button>
                                    <div x-show="open" x-cloak :class="showAbove ? 'absolute right-0 bottom-full mb-2' : 'absolute right-0 top-full mt-2'" class="delete-popover bg-white rounded-lg shadow-lg p-4 border border-gray-200 z-50" style="min-width: 260px;">
                                        <h2 class="text-lg font-bold mb-2 text-gray-800">Confirm Delete</h2>
                                        <p class="mb-4 text-gray-600">Are you sure you want to delete this hero?</p>
                                        <div class="flex justify-end space-x-2">
                                            <button @click="open = false" type="button" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                                            <form action="{{ route('admin.hero.destroy', $hero->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Hero Phone Images (Global)</h2>
            <p class="text-sm text-gray-500 mb-6">These 3 images will be displayed at the bottom of the Hero section while the verses above rotate.</p>
            
            <form action="{{ route('admin.hero.images.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Image 1 -->
                    <div class="p-5 border rounded bg-gray-50">
                        <label class="block font-semibold text-gray-700 mb-3 text-sm">Phone Image 1 (Left)</label>
                        @if($heroImage && $heroImage->phone_image_1 && \Illuminate\Support\Facades\Storage::disk('public')->exists($heroImage->phone_image_1))
                            <div class="mb-4 relative inline-block group">
                                <img src="{{ asset('storage/' . $heroImage->phone_image_1) }}" alt="Phone 1" class="w-24 h-36 object-cover rounded shadow border border-gray-200">
                                <button type="button" onclick="event.preventDefault(); document.getElementById('delete-img-1').submit();" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition shadow hover:bg-red-700" title="Delete Image">
                                    <span class="material-icons text-sm" style="font-size: 16px;">close</span>
                                </button>
                            </div>
                        @else
                            <div class="mb-4 w-24 h-36 bg-gray-200 rounded flex flex-col items-center justify-center text-gray-400 border border-dashed border-gray-300">
                                <span class="material-icons mb-1 text-gray-400">image_not_supported</span>
                                <span class="text-xs">No image</span>
                            </div>
                        @endif
                        <input type="file" name="phone_image_1" accept="image/*" class="w-full text-sm text-gray-600 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                    </div>

                    <!-- Image 2 -->
                    <div class="p-5 border rounded bg-gray-50">
                        <label class="block font-semibold text-gray-700 mb-3 text-sm">Phone Image 2 (Center)</label>
                        @if($heroImage && $heroImage->phone_image_2 && \Illuminate\Support\Facades\Storage::disk('public')->exists($heroImage->phone_image_2))
                            <div class="mb-4 relative inline-block group">
                                <img src="{{ asset('storage/' . $heroImage->phone_image_2) }}" alt="Phone 2" class="w-24 h-36 object-cover rounded shadow border border-gray-200">
                                <button type="button" onclick="event.preventDefault(); document.getElementById('delete-img-2').submit();" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition shadow hover:bg-red-700" title="Delete Image">
                                    <span class="material-icons text-sm" style="font-size: 16px;">close</span>
                                </button>
                            </div>
                        @else
                            <div class="mb-4 w-24 h-36 bg-gray-200 rounded flex flex-col items-center justify-center text-gray-400 border border-dashed border-gray-300">
                                <span class="material-icons mb-1 text-gray-400">image_not_supported</span>
                                <span class="text-xs">No image</span>
                            </div>
                        @endif
                        <input type="file" name="phone_image_2" accept="image/*" class="w-full text-sm text-gray-600 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                    </div>

                    <!-- Image 3 -->
                    <div class="p-5 border rounded bg-gray-50">
                        <label class="block font-semibold text-gray-700 mb-3 text-sm">Phone Image 3 (Right)</label>
                        @if($heroImage && $heroImage->phone_image_3 && \Illuminate\Support\Facades\Storage::disk('public')->exists($heroImage->phone_image_3))
                            <div class="mb-4 relative inline-block group">
                                <img src="{{ asset('storage/' . $heroImage->phone_image_3) }}" alt="Phone 3" class="w-24 h-36 object-cover rounded shadow border border-gray-200">
                                <button type="button" onclick="event.preventDefault(); document.getElementById('delete-img-3').submit();" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition shadow hover:bg-red-700" title="Delete Image">
                                    <span class="material-icons text-sm" style="font-size: 16px;">close</span>
                                </button>
                            </div>
                        @else
                            <div class="mb-4 w-24 h-36 bg-gray-200 rounded flex flex-col items-center justify-center text-gray-400 border border-dashed border-gray-300">
                                <span class="material-icons mb-1 text-gray-400">image_not_supported</span>
                                <span class="text-xs">No image</span>
                            </div>
                        @endif
                        <input type="file" name="phone_image_3" accept="image/*" class="w-full text-sm text-gray-600 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-bold rounded shadow hover:bg-blue-700 transition">Save Hero Images</button>
                </div>
            </form>
        </div>
        
        <form id="delete-img-1" action="{{ route('admin.hero.images.delete', 'phone_image_1') }}" method="POST" class="hidden">
            @csrf
        </form>
        <form id="delete-img-2" action="{{ route('admin.hero.images.delete', 'phone_image_2') }}" method="POST" class="hidden">
            @csrf
        </form>
        <form id="delete-img-3" action="{{ route('admin.hero.images.delete', 'phone_image_3') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
@endsection 