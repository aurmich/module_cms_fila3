@props([
    'section' => null,
    'blocks' => [],
    'class' => ''
])

@php
    $locale = app()->getLocale();
    $componentsBlocks = is_array($blocks) && isset($blocks[$locale]) ? $blocks[$locale] : $blocks;
@endphp

<footer {{ $attributes->merge([
    'class' => 'bg-[#1A467F] text-white' . ($section['attributes']['class'] ?? '') . ' ' . $class,
    'id' => ($section['attributes']['id'] ?? '')
]) }}>
    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">
        <div class="w-full flex flex-col justify-center">
            <!-- Colonna Logo e Descrizione -->
           
                <div class="w-full flex justify-center">
                    <img src="/img/saluteOra-new-logo.png" alt="{{ config('app.name') }}" class="h-24 w-auto">
                </div>
                <div class="w-full flex justify-center">
                    <p class="text-medium text-white">
                        Promuoviamo la salute orale delle gestanti attraverso prevenzione e assistenza specialistica.
                    </p>
                </div>          
            </div>
        </div>

        <!-- Copyright e Link Legali -->
        <div class="border-neutral-focus">
            <div class="flex justify-center">
                <div class="text-center m-6 md:text-right space-x-4">
                    <a href="{{ url('privacy') }}" class="text-[#0D9488] text-sm hover:text-primary-400 transition-colors">Privacy Policy</a>
                    <a href="{{ url('terms') }}" class="text-[#0D9488] text-sm hover:text-primary-400 transition-colors">Termini e Condizioni</a>
                    <a href="{{ url('cookies') }}" class="text-[#0D9488] text-sm hover:text-primary-400 transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>