<?php

declare(strict_types=1);

/**
 * Bootstrap file personalizzato per PHPStan
 * Evita problemi con Livewire e componenti non esistenti.
 */

// Mock per componenti Livewire che potrebbero non esistere
if (! class_exists('Livewire\Component')) {
    class_alias('stdClass', 'Livewire\Component');
}

if (! class_exists('Livewire\Attributes\Component')) {
    class_alias('stdClass', 'Livewire\Attributes\Component');
}

// Mock per Filament se necessario
if (! class_exists('Filament\Forms\Components\Component')) {
    class_alias('stdClass', 'Filament\Forms\Components\Component');
}

// Mock per altri componenti che potrebbero causare problemi
if (! class_exists('Filament\Tables\Columns\Column')) {
    class_alias('stdClass', 'Filament\Tables\Columns\Column');
}

// Disabilita autoloading di componenti problematici
if (function_exists('spl_autoload_register')) {
    spl_autoload_register(function ($class) {
        // Ignora componenti Livewire problematici
        if (str_starts_with($class, 'Livewire\\') && ! class_exists($class)) {
            return;
        }

        // Ignora componenti Filament problematici
        if (str_starts_with($class, 'Filament\\') && ! class_exists($class)) {
            return;
        }
    });
}
