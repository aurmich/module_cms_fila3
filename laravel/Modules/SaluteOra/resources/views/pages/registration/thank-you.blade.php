@php
$locale = app()->getLocale();
@endphp

@extends('saluteora::layouts.app')

@section('content')
<div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-blue-900 text-white p-4 flex justify-between items-center">
        <div class="text-2xl font-light">
            <span class="font-bold">{{ config('app.name') }}</span>
        </div>
        <button class="text-3xl">☰</button>
    </header>

    <!-- Main Content -->
    <main class="flex-1 container mx-auto p-4 max-w-md md:max-w-2xl lg:max-w-4xl">
        <div class="p-8 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-blue-900 mb-4">Ti ringraziamo per esserti iscritta al portale</h2>
            <p class="text-gray-600 mb-6">Esamineremo i dati e i documenti che ci hai inviato e, se il tuo profilo risponde ai requisiti, riceverai una mail di conferma e potrai accedere al servizio.</p>
            <div class="mt-8">
                <a href="/{{ $locale }}" class="inline-block bg-blue-900 text-white text-lg font-medium py-3 px-6 rounded-full hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-opacity-50 shadow-sm hover:shadow-md transition-all duration-200">
                    TORNA ALLA HOME
                </a>
            </div>
        </div>
    </main>
</div>
@endsection
