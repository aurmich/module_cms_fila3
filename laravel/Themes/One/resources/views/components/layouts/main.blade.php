<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        {{--
            Policy: il layout DEVE includere @livewireStyles e @livewireScripts per evitare errori 419 Page Expired nei widget Filament/Livewire.
            Vedi docs/widget-deleting-method-error.md e docs/rules/filament_best_practices.md
        --}}

        {!! $_theme->metatags() !!}
        <!-- Used to add dark mode right away, adding here prevents any flicker -->
        <script>
            if (typeof(Storage) !== "undefined") {
                if(localStorage.getItem('dark_mode') && localStorage.getItem('dark_mode') == 'true'){
                    document.documentElement.classList.add('dark');
                }
            }
        </script>
        <style>
			[x-cloak] {
			display: none !important;
			}
		</style>
		@filamentStyles
        @livewireStyles

        @vite(['resources/css/app.css'],'themes/One')


    </head>
    <body class="min-h-screen flex flex-col bg-[#E6EBF7]">
        {{ $slot }}
        {{--
        <livewire:toast />
        --}}
        @livewire('notifications')
		@filamentScripts
        @livewireScripts
        @vite(['resources/js/app.js'],'themes/One')
        <link rel="stylesheet" type="text/css" href="{{asset("vendor/cookie-consent/css/cookie-consent.css")}}">
    </body>
</html>
