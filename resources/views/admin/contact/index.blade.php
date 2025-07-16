@extends('admin.layouts.app')

@section('content')
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif
    <div class="mt-10 mb-6 px-6 w-full">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Contact Information</h1>
            <a href="{{ route('admin.contact.create') }}"
               class="inline-block px-5 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition font-semibold">
                Add New Contact
            </a>
        </div>
        <x-admin.table :items="$contacts" :fields="['address', 'phone', 'email', 'website']" editRoute="admin.contact.edit" deleteRoute="admin.contact.destroy" />
    </div>

    <!-- Embedded Google Map -->
    <div class="px-6 pb-10">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3939.743749299887!2d38.763611!3d9.030833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x164b853c6d7e2e7b%3A0x7e1e2b6e7e2e7b!2sAddis%20Ababa%2C%20Ethiopia!5e0!3m2!1sen!2set!4v1710000000000!5m2!1sen!2set"
            width="100%"
            height="350"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
@endsection
