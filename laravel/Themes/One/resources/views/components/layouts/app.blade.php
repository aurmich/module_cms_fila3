<x-layouts.main :is-landing="$isLanding ?? false">
    <x-section slug="header" />
    <div class="flex-1">
        {{ $slot }}
    </div>

    <x-section slug="footer" />
</x-layouts.main>