<x-layouts.main :is-landing="$isLanding ?? false">
    <x-section slug="header" />
    <div style="background-image: url(/img/inmp-trasparenza-5.svg); background-size: contain; background-repeat: no-repeat; background-position: center" class="flex-1 m-5">
        {{ $slot }}
    </div>
    <x-section slug="footer" />
</x-layouts.main>