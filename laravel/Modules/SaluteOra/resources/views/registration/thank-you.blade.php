<x-app-layout>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <!-- Header -->
        <header class="bg-blue-900 text-white p-4 flex justify-between items-center">
            <div class="text-3xl font-light">
                <span class="font-normal">SALUTE</span> ORA<span class="italic font-light text-2xl">le</span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 container mx-auto px-4 py-8 max-w-4xl">
            <div class="bg-white rounded-lg shadow-sm p-8 md:p-12">
                <h1 class="text-2xl md:text-3xl font-bold text-blue-900 mb-6">
                    Ti ringraziamo per esserti iscritta al portale Salute Ora
                </h1>

                <p class="text-gray-600 text-lg mb-8">
                    Esamineremo i dati e i documenti che ci hai inviato e, se il tuo profilo risponde ai requisiti richiesti, 
                    riceverai una email di conferma e potrai accedere al servizio.
                </p>

                <div class="mt-8 md:mt-12">
                    <a href="{{ route('home') }}" 
                       class="inline-block w-full md:w-auto bg-blue-900 text-white text-lg font-medium py-3 px-8 rounded-full hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-opacity-50 shadow-sm hover:shadow-md transition-all duration-200">
                        Torna alla Home
                    </a>
                </div>
            </div>
        </main>
    </div>

    @push('styles')
    <style>
        .floating-blob {
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
    @endpush
</x-app-layout> 