<div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded shadow">
<x-admin.form :action="$action" :edit="isset($hero)" :buttonText="$buttonText ?? null" :hasFileUpload="true">
    <div class="mb-4">
        <label class="block font-medium mb-1">Arabic Verse</label>
        <input type="text" name="ar" value="{{ old('ar', $hero->ar ?? '') }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required dir="rtl">
    </div>
    <div class="mb-4">
        <label class="block font-medium mb-1">English Translation</label>
        <input type="text" name="en" value="{{ old('en', $hero->en ?? '') }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>
    <div class="mb-4">
        <label class="block font-medium mb-1">Reference</label>
        <input type="text" name="ref" value="{{ old('ref', $hero->ref ?? '') }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>

    <div class="mb-4">
        <label class="block font-medium mb-1">Order</label>
        <input type="number" name="order" value="{{ old('order', $hero->order ?? '') }}" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div class="mb-4 flex items-center">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $hero->is_active ?? false) ? 'checked' : '' }} class="mr-2">
        <label class="font-medium">Active</label>
    </div>
</x-admin.form>
</div> 