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
    'class' => 'bg-neutral text-neutral-content ' . ($section['attributes']['class'] ?? '') . ' ' . $class,
    'id' => ($section['attributes']['id'] ?? '')
]) }}>
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Colonna Logo e Descrizione -->
            <div class="flex justify-center">
                <div class="text-center m-1 lg:m-6 md:text-right space-x-4">
                <a href="{{ route('home') }}" class="text-white text-md m-1">@lang('pub_theme::navigation.main_menu.home.label')</a>
                <a href="/{{ $lang }}/pages/progetto" class="text-white text-md m-1">@lang('pub_theme::navigation.main_menu.project.label')</a>
                </div>
            </div>
            <a href="{{ route('home') }}">
                <div class="flex justify-center">
                    <img src="/img/saluteOra-new-logo.png" alt="{{ config('app.name') }}" class="h-16 lg:h-24 w-auto">
                </div>
            </a>
            <div class="flex justify-center">
                <div class="text-center m-1 lg:m-6 md:text-right space-x-4">
                    <a href="/{{ $lang }}/pages/partners" class="text-white text-md m-1">@lang('pub_theme::navigation.main_menu.partners.label')</a>
                    <a href="/{{ $lang }}/pages/faqs" class="text-white text-md">@lang('pub_theme::navigation.main_menu.faqs.label')</a>
                    <a href="/img/trattamento-dati-odonoiatra.pdf" target="_blank" class="text-white text-md">Trattamento Dati</a>
                </div>
            </div>           (.)
            </div>
        </div>

        <!-- Copyright e Link Legali -->
        <div class="mt-12 pt-8 border-t border-neutral-focus">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-center md:text-left">
                    <p class="text-sm opacity-90">&copy; {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.</p>
                </div>
                <div class="text-center md:text-right space-x-4">
                    <a href="{{ url('privacy') }}" class="text-sm hover:text-primary-400 transition-colors">Privacy Policy</a>
                    <a href="{{ url('terms') }}" class="text-sm hover:text-primary-400 transition-colors">Termini e Condizioni</a>
                    <a href="{{ url('cookies') }}" class="text-sm hover:text-primary-400 transition-colors">Cookie Policy</a>
                </div>
            </div>
        </div>
    </div>
</footer>
