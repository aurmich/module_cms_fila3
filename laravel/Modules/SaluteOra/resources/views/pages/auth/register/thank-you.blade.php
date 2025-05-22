<?php

use function Laravel\Folio\{name};

name('auth.register.thank-you');

?>

<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12">
        <!-- Logo e intestazione -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <x-ui.logo class="h-12 text-blue-900" />
            </div>
            <h1 class="text-3xl font-light text-blue-900">Grazie per la registrazione</h1>
        </div>

        <!-- Card contenente il messaggio -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8">
                <h2 class="text-2xl font-bold text-blue-900 mb-4">
                    Ti ringraziamo per esserti iscritta al portale Salute Ora
                </h2>

                <p class="text-gray-600 text-lg mb-8">
                    Esamineremo i dati e i documenti che ci hai inviato e, se il tuo profilo risponde ai requisiti richiesti, 
                    riceverai una email di conferma e potrai accedere al servizio.
                </p>

                <div class="mt-8">
                    <a href="{{ url('/') }}" 
                       class="inline-block w-full md:w-auto bg-blue-900 text-white text-lg font-medium py-3 px-8 rounded-full hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-opacity-50 shadow-sm hover:shadow-md transition-all duration-200">
                        Torna alla Home
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer con informazioni aggiuntive -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Hai bisogno di assistenza? <a href="#" class="text-blue-800 hover:underline">Contattaci</a></p>
        </div>
    </div>
</x-layouts.app> 