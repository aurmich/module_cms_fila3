# User Dropdown Component

## Panoramica
Il componente User Dropdown è un menu a tendina per la gestione dell'utente, che mostra opzioni diverse per utenti loggati e non loggati. Utilizza il componente dropdown di Filament per una migliore integrazione e consistenza con il resto dell'interfaccia.

## Implementazione

### 1. Template
```blade
@props([
    'alignment' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-gray-800'
])

@if($isLoggedIn)
    <x-filament::dropdown
        placement="{{ $alignment }}"
        width="{{ $width }}"
        :content-classes="$contentClasses"
    >
        <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                <x-filament::avatar
                    :src="$user?->profile_photo_url"
                    :alt="$user?->name"
                    size="md"
                    class="ring-2 ring-white ring-opacity-50 shadow-sm"
                />
                <div class="ml-2">{{ $user->name }}</div>
                <x-filament::icon
                    name="heroicon-o-chevron-down"
                    class="ml-1 h-4 w-4"
                />
            </button>
        </x-slot>

        <x-filament::dropdown.list>
            {{ $slot }}
        </x-filament::dropdown.list>
    </x-filament::dropdown>
@else
    <div class="flex items-center space-x-4">
        <a href="{{ route('login', ['locale' => $locale]) }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
            {{ __('auth.login') }}
        </a>
        <a href="{{ route('register', ['locale' => $locale]) }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
            {{ __('auth.register') }}
        </a>
    </div>
@endif
```

### 2. Utilizzo
```blade
<x-blocks.navigation.user-dropdown>
    <x-filament::dropdown.item
        href="/profilo"
        icon="heroicon-o-user"
    >
        {{ __('user.profile') }}
    </x-filament::dropdown.item>

    <x-filament::dropdown.separator />

    <x-filament::dropdown.item
        href="/logout"
        icon="heroicon-o-arrow-left-on-rectangle"
        color="danger"
    >
        {{ __('auth.logout') }}
    </x-filament::dropdown.item>
</x-blocks.navigation.user-dropdown>
```

## Best Practices

### 1. Traduzioni
- Utilizzare sempre le chiavi di traduzione corrette
- Non usare stringhe hardcoded
- Seguire la struttura gerarchica delle traduzioni
- Utilizzare il LangServiceProvider

### 2. Accessibilità
- Mantenere la struttura semantica
- Supportare la navigazione da tastiera
- Fornire ARIA labels appropriati

### 3. Performance
- Minimizzare le query
- Utilizzare il caching
- Ottimizzare il rendering

### 4. Sicurezza
- Sanitizzare gli URL
- Validare i permessi utente
- Proteggere le rotte sensibili

## Collegamenti
- [Documentazione Componenti](../README.md)
- [Best Practices CMS](../../../docs/best-practices.md)
- [Guida Stili](../../../docs/styling.md) 