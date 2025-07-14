<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="SaluteOra - La piattaforma per la gestione della tua salute">
        <meta name="keywords" content="salute, medici, studi, appuntamenti, prenotazioni">
        <meta name="author" content="SaluteOra">

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Used to add dark mode right away, adding here prevents any flicker -->
        <script>
            if (typeof(Storage) !== "undefined") {
                if(localStorage.getItem('dark_mode') && localStorage.getItem('dark_mode') == 'true'){
                    document.documentElement.classList.add('dark');
                }
            }
        </script>

        <!-- Styles -->
        @filamentStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'],'themes/One')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <title>{{ $title ?? 'SaluteOra - La tua salute, ora' }}</title>
    </head>
    <body class="min-h-screen antialiased bg-gray-50 dark:bg-gradient-to-b dark:from-gray-950 dark:to-gray-900 font-sans">
        <div class="flex flex-col min-h-screen">
            <!-- Contenuto principale -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

           
        </div>

        {{--
        @livewire('notifications')

        --}}
        @filamentScripts
        @vite(['resources/js/app.js'],'themes/One')
    </body>
</html>
