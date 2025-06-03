@props([
    'section' => null,
    'blocks' => [],
    'class' => '',
    'componentsBlocks' => [],
    'x-data' => "{ mobileMenuOpen: false }"
])

@php
    use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
    $locale = LaravelLocalization::getCurrentLocale();
    $componentsBlocks = is_array($blocks) && isset($blocks[$locale]) ? $blocks[$locale] : $blocks;
@endphp

<header {{ $attributes->merge([
    'class' => 'bg-white dark:bg-gray-900 shadow',
    'id' => ($section['attributes']['id'] ?? ''),
    'x-data' => "{ mobileMenuOpen: false }"
]) }}>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            @foreach($componentsBlocks as $block)
                @include($block->view,$block->data)
            @endforeach
            <div class="flex md:hidden">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    aria-expanded="false">
                    <span class="sr-only">Apri menu principale</span>
                    {{-- Hamburger Icon --}}
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    {{-- Close Icon --}}
                    <svg x-show="mobileMenuOpen" class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="md:hidden">
         {{--
        <div class="space-y-1 px-2 pb-3 pt-2">
                @if($block['type'] === 'navigation')
                    <div class="flex flex-col space-y-2">
                    @includeIf('cms::blocks.navigation', ['data' => $block['data']])
                    </div>
                @elseif($block['type'] === 'actions')
                    <div class="mt-2">
                    @includeIf('cms::blocks.actions', ['data' => $block['data']])
                    </div>
                @endif
            @endforeach
        </div>
        --}}
    </div>
</header>
