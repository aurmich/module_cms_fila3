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
    'class' => 'bg-[#272C4D] min-h-36 text-white flex justify-center items-center' . ($section['attributes']['class'] ?? '') . ' ' . $class,
    'id' => ($section['attributes']['id'] ?? '')
]) }}>
    <div class="flex flex-row justify-center md:flex-col">
        <div class="flex flex-col md:flex-row justify-center items-center">
            <!-- Colonna Logo e Descrizione -->
            <div class="flex justify-center">
                <div class="text-center m-6 md:text-right space-x-4">
                    <a href="/it/pages/privacy-policy" class="text-white text-sm transition-colors">Privacy Policy</a>
                    <a href="/it/pages/termini-condizioni" class="text-white text-sm transition-colors">Termini e Condizioni</a>
                    <a href="/it/pages/cookie-policy-salute-ora" class="text-white text-sm transition-colors">Cookie Policy</a>
                </div>
            </div>
            <div class="flex justify-center">
                <img src="/img/saluteOra-new-logo.png" alt="{{ config('app.name') }}" class="h-24 w-auto">
            </div>
            <div class="flex justify-center">
                <div class="text-center m-6 md:text-right">
                    <a href="/it" class="text-white text-sm m-1">Home</a>
                    <a href="/it/pages/progetto" class="text-white text-sm m-1">Progetto</a>
                    <a href="/it/pages/partners" class="text-white text-sm m-1">Partners</a>
                    <a href="/it/pages/faqs" class="text-white text-sm">FAQ'S</a>
                </div>
            </div>          
            </div>
        </div>

        <!-- Copyright e Link Legali -->

    </div>
</footer>