<x-layouts.main :is-landing="$isLanding ?? false">
    <x-section slug="header" />

    {{ $slot }}

    <x-section slug="footer" />
</x-layouts.main>