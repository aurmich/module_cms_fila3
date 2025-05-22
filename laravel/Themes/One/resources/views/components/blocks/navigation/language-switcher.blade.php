@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

<div x-data="{ open: false }" class="relative">
    <button
        @click="open = !open"
        class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors duration-200"
        aria-label="{{ __('Select language') }}"
    >
        <x-ui-flags.{{ $currentLocale }} class="w-6 h-4" />
        <span class="text-sm font-medium text-white">{{ strtoupper($currentLocale) }}</span>
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="py-1">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a
                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $localeCode ? 'bg-gray-50' : '' }}"
                >
                    <x-ui-flags.{{ $localeCode }} class="w-6 h-4 mr-2" />
                    {{--
                    <span>{{ $properties['native'] }}</span>
                    --}}
                    @if($currentLocale === $localeCode)
                        <svg class="w-4 h-4 ml-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
