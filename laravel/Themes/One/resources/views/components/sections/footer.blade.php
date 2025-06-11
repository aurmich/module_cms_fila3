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
    'class' => 'bg-[#1A467F] h-36 text-white flex items-center' . ($section['attributes']['class'] ?? '') . ' ' . $class,
    'id' => ($section['attributes']['id'] ?? '')
]) }}>
    <div class="w-full flex justify-center">
        <div class="w-full flex flex-row justify-center items-center">
            <!-- Colonna Logo e Descrizione -->
            <div class="w-[700px] flex justify-center">
                <div class="text-center m-6 md:text-right space-x-4">
                    <a href="{{ url('privacy') }}" class="text-white text-sm transition-colors">Privacy Policy</a>
                    <a href="{{ url('terms') }}" class="text-white text-sm transition-colors">Termini e Condizioni</a>
                    <a href="{{ url('cookies') }}" class="text-white text-sm transition-colors">Cookie Policy</a>
                </div>
            </div>
            <div class="w-full flex justify-center">
                <img src="/img/saluteOra-new-logo.png" alt="{{ config('app.name') }}" class="h-24 w-auto">
            </div>
            <div class="w-[700px] flex justify-center">
                <div class="text-center m-6 md:text-right">
                    <a href="{{ url('privacy') }}" class="text-white text-sm m-1">Home</a>
                    <a href="{{ url('terms') }}" class="text-white text-sm m-1">Progetto</a>
                    <a href="{{ url('cookies') }}" class="text-white text-sm m-1">Partners</a>
                    <a href="{{ url('cookies') }}" class="text-white text-sm">FAQ'S</a>
                </div>
            </div>          
            </div>
        </div>

        <!-- Copyright e Link Legali -->

    </div>
</footer>