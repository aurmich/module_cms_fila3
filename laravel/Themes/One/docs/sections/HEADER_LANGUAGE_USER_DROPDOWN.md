# Implementazione del Selettore di Lingua e Dropdown Utente nell'Header

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Documentazione sezioni](/docs/sections.md)
- [Sezioni CMS](/laravel/Modules/Cms/docs/sections.md)
- [Sezioni Tema One](/laravel/Themes/One/docs/sections.md)
- [Implementazione Logout](/laravel/Modules/User/docs/LOGOUT_BLADE_IMPLEMENTATION.md)
- [Analisi Errore Logout](/laravel/Modules/User/docs/LOGOUT_BLADE_ERROR_ANALYSIS.md)
- [Errore Eventi Logout](/laravel/Modules/User/docs/LOGOUT_EVENT_ERROR.md)

## Panoramica

Questo documento descrive l'implementazione di due nuovi componenti nell'header principale del tema One:

1. **Selettore di Lingua**: Permette all'utente di cambiare la lingua dell'interfaccia
2. **Dropdown Utente**: Mostra l'avatar dell'utente autenticato e contiene un menu con opzioni, incluso il logout

## Struttura JSON dell'Header

L'header è definito nel file JSON `/config/local/saluteora/database/content/sections/1.json` e segue questa struttura:

```json
{
    "id": "1",
    "name": {
        "it": "Header Principale",
        "en": "Main Header"
    },
    "slug": "header",
    "blocks": {"it":[
        // Blocchi esistenti (logo, navigazione, azioni)
    ]},
    "attributes": {
        // Attributi dell'header
    }
}
```

## Nuovi Blocchi da Aggiungere

### 1. Selettore di Lingua

```json
{
    "name": {
        "it": "Selettore Lingua",
        "en": "Language Selector"
    },
    "type": "language-selector",
    "data": {
        "view": "pub_theme::components.blocks.language-selector",
        "languages": [
            {
                "code": "it",
                "name": "Italiano",
                "flag": "it"
            },
            {
                "code": "en",
                "name": "English",
                "flag": "gb"
            }
        ]
    }
}
```

### 2. Dropdown Utente con Logout

```json
{
    "name": {
        "it": "Dropdown Utente",
        "en": "User Dropdown"
    },
    "type": "user-dropdown",
    "data": {
        "view": "pub_theme::components.blocks.user-dropdown",
        "guest_view": "pub_theme::components.blocks.login-buttons",
        "menu_items": [
            {
                "label": "Profilo",
                "url": "/profilo",
                "icon": "heroicon-o-user"
            },
            {
                "label": "Impostazioni",
                "url": "/impostazioni",
                "icon": "heroicon-o-cog-6-tooth"
            },
            {
                "type": "divider"
            },
            {
                "label": "Logout",
                "url": "/logout",
                "icon": "heroicon-o-arrow-left-on-rectangle",
                "method": "get"
            }
        ]
    }
}
```

## Implementazione dei Componenti Blade

### 1. Componente Selettore di Lingua

File: `/laravel/Themes/One/resources/views/components/blocks/language-selector.blade.php`

```blade
@props(['languages' => []])

<div class="relative" x-data="{ open: false }">
    <button 
        @click="open = !open" 
        @click.away="open = false"
        class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-primary-500"
    >
        @php
            $currentLocale = app()->getLocale();
            $currentFlag = $currentLocale === 'en' ? 'gb' : $currentLocale;
        @endphp
        
        <div class="flex items-center justify-center w-6 h-6 overflow-hidden rounded-full border border-gray-200">
            <x-dynamic-component :component="'ui-flags.' . $currentFlag" class="w-7 h-7 object-cover" />
        </div>
        
        <span class="hidden md:inline">{{ $languages[$currentLocale]['name'] ?? ucfirst($currentLocale) }}</span>
        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
    
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-100" 
        x-transition:enter-start="transform opacity-0 scale-95" 
        x-transition:enter-end="transform opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-75" 
        x-transition:leave-start="transform opacity-100 scale-100" 
        x-transition:leave-end="transform opacity-0 scale-95" 
        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 divide-y divide-gray-100"
    >
        <div class="py-1">
            @foreach($languages as $code => $language)
                @php
                    $flag = $code === 'en' ? 'gb' : $code;
                @endphp
                <a 
                    href="{{ url($code . substr(request()->getRequestUri(), 3)) }}" 
                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                    <div class="flex items-center justify-center w-6 h-6 overflow-hidden rounded-full border border-gray-200">
                        <x-dynamic-component :component="'ui-flags.' . $flag" class="w-7 h-7 object-cover" />
                    </div>
                    {{ $language['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>
```

### 2. Componente Dropdown Utente

File: `/laravel/Themes/One/resources/views/components/blocks/user-dropdown.blade.php`

```blade
@props(['menu_items' => [], 'guest_view' => ''])

@auth
    <div class="relative" x-data="{ open: false }">
        <button 
            @click="open = !open" 
            @click.away="open = false"
            class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none"
        >
            <img 
                src="{{ auth()->user()->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                alt="{{ auth()->user()->name }}" 
                class="h-8 w-8 rounded-full object-cover"
            >
            <span class="ml-2 hidden md:inline">{{ auth()->user()->name }}</span>
            <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        
        <div 
            x-show="open" 
            x-transition:enter="transition ease-out duration-100" 
            x-transition:enter-start="transform opacity-0 scale-95" 
            x-transition:enter-end="transform opacity-100 scale-100" 
            x-transition:leave="transition ease-in duration-75" 
            x-transition:leave-start="transform opacity-100 scale-100" 
            x-transition:leave-end="transform opacity-0 scale-95" 
            class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
        >
            <div class="py-1">
                @foreach($menu_items as $item)
                    @if(isset($item['type']) && $item['type'] === 'divider')
                        <div class="border-t border-gray-200 my-1"></div>
                    @else
                        <a 
                            href="{{ $item['url'] }}" 
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            @if(isset($item['method']) && $item['method'] !== 'get')
                                onclick="event.preventDefault(); document.getElementById('{{ Str::slug($item['label']) }}-form').submit();"
                            @endif
                        >
                            @if(isset($item['icon']))
                                <x-dynamic-component :component="$item['icon']" class="mr-2 h-5 w-5 text-gray-500" />
                            @endif
                            {{ __($item['label']) }}
                        </a>
                        
                        @if(isset($item['method']) && $item['method'] !== 'get')
                            <form id="{{ Str::slug($item['label']) }}-form" action="{{ $item['url'] }}" method="{{ $item['method'] }}" class="hidden">
                                @csrf
                            </form>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@else
    @include($guest_view)
@endauth
```

### 3. Componente Pulsanti di Login (per utenti non autenticati)

File: `/laravel/Themes/One/resources/views/components/blocks/login-buttons.blade.php`

```blade
<div class="flex items-center space-x-4">
    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">
        {{ __('auth.login.button.label') }}
    </a>
    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        {{ __('auth.register.button.label') }}
    </a>
</div>
```

## Integrazione con il Logout

Il componente Dropdown Utente include un'opzione di logout che utilizza il file `logout.blade.php` corretto. È importante assicurarsi che il file di logout sia implementato correttamente come descritto in [LOGOUT_EVENT_ERROR.md](/laravel/Modules/User/docs/LOGOUT_EVENT_ERROR.md) per evitare errori con gli eventi di logout.

### Utilizzo dei Componenti SVG delle Bandiere

Per rendere il selettore di lingue più accattivante e visibile, utilizziamo i componenti SVG delle bandiere forniti dal modulo UI di SaluteOra. Questi componenti sono autoregistrati e possono essere facilmente integrati nell'header.

#### Vantaggi dei Componenti SVG

1. **Qualità Visiva**: Gli SVG sono vettoriali e mantengono la qualità a qualsiasi dimensione
2. **Personalizzazione**: Facile da personalizzare con classi CSS
3. **Prestazioni**: Gli SVG sono leggeri e non richiedono richieste HTTP aggiuntive
4. **Accessibilità**: Possibilità di aggiungere attributi di accessibilità
5. **Coerenza**: Utilizzo di componenti nativi di SaluteOra

#### Sintassi di Utilizzo

```blade
<x-ui-flags.it class="h-5 w-5" />
<x-ui-flags.gb class="h-5 w-5" />
<x-ui-flags.fr class="h-5 w-5" />
```

Dove:
- `ui` è il prefisso del modulo (in minuscolo)
- `flags` è la sottodirectory all'interno della cartella `svg`
- `it`, `gb`, `fr` sono i codici ISO dei paesi

Per maggiori dettagli, consultare la [documentazione sui componenti SVG delle bandiere](/laravel/Modules/UI/docs/FLAGS_COMPONENTS.md).

## Considerazioni sulla Localizzazione degli URL

Seguendo le convenzioni di SaluteOra per la localizzazione degli URL, il selettore di lingua mantiene la struttura `/{locale}/{sezione}/{risorsa}` quando si cambia lingua, preservando il percorso corrente.

## Implementazione nel JSON dell'Header

Per implementare queste modifiche, è necessario aggiungere i nuovi blocchi al file JSON dell'header. Ecco come dovrebbe apparire la sezione `blocks` aggiornata:

```json
"blocks": {"it":[
    // Blocco Logo esistente
    {
        "name": {
            "it": "Logo",
            "en": "Logo"
        },
        "type": "logo",
        "data": {
            "view": "pub_theme::components.blocks.logo",
            "src": "patient::images/logo.svg",
            "alt":  "Logo SaluteOra",
            "width": 150,
            "height": 32
        }
    },
    // Blocco Navigazione esistente
    {
        "name": {
            "it": "Menu di Navigazione",
            "en": "Navigation Menu"
        },
        "type": "navigation",
        "data": {
            "view": "pub_theme::components.blocks.navigation",
            "items": [
                // Voci di menu esistenti
            ],
            "alignment": "start",
            "orientation": "horizontal"
        }
    },
    // Nuovo blocco Selettore Lingua
    {
        "name": {
            "it": "Selettore di Lingua",
            "en": "Language Selector"
        },
        "type": "language-selector",
        "data": {
            "view": "pub_theme::components.blocks.language-selector",
            "languages": {
                "it": {
                    "name": "Italiano",
                    "flag": "it"
                },
                "en": {
                    "name": "English",
                    "flag": "gb"
                },
                "fr": {
                    "name": "Français",
                    "flag": "fr"
                },
                "de": {
                    "name": "Deutsch",
                    "flag": "de"
                },
                "es": {
                    "name": "Español",
                    "flag": "es"
                }
            }
        }
    },
    // Nuovo blocco Dropdown Utente
    {
        "name": {
            "it": "Dropdown Utente",
            "en": "User Dropdown"
        },
        "type": "user-dropdown",
        "data": {
            "view": "pub_theme::components.blocks.user-dropdown",
            "guest_view": "pub_theme::components.blocks.login-buttons",
            "menu_items": [
                {
                    "label": "auth.profile.link.label",
                    "url": "/profilo",
                    "icon": "heroicon-o-user"
                },
                {
                    "label": "auth.settings.link.label",
                    "url": "/impostazioni",
                    "icon": "heroicon-o-cog-6-tooth"
                },
                {
                    "type": "divider"
                },
                {
                    "label": "auth.logout.button.label",
                    "url": "/logout",
                    "icon": "heroicon-o-arrow-left-on-rectangle",
                    "method": "get"
                }
            ]
        }
    },
    // Blocco Azioni esistente (opzionale, può essere rimosso se sostituito dal dropdown utente)
    {
        "name": {
            "it": "Azioni",
            "en": "Actions"
        },
        "type": "actions",
        "data": {
            "view": "pub_theme::components.blocks.actions",
            "items": [
                // Azioni esistenti
            ]
        }
    }
]}
```

## Conclusione

L'implementazione del selettore di lingua e del dropdown utente nell'header migliorerà significativamente l'esperienza utente, consentendo un facile cambio di lingua e un accesso rapido alle funzionalità relative all'utente, incluso il logout.

Questa implementazione segue le convenzioni di SaluteOra per:
- Localizzazione degli URL con prefisso della lingua
- Struttura dei componenti e dei blocchi
- Gestione dei contenuti statici tramite file JSON
- Integrazione con il sistema di autenticazione

# Header: Lingua e Utente

## Selettore di Lingua

### Implementazione Corretta
```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::icon-button
            :icon="'ui-flags.' . $flagCode"
            class="h-5 w-5"
            :label="$flagCode"
            aria-hidden="true"
        />
    </x-slot>

    <x-filament::dropdown.list>
        @foreach($languages as $code => $language)
            <x-filament::dropdown.list.item>
                <x-filament::icon
                    :icon="'ui-flags.' . $code"
                    class="h-5 w-5 text-gray-500 dark:text-gray-400"
                    :label="$code"
                />
                <span>{{ $language['name'] }}</span>
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

### Vantaggi
1. **Coerenza**: Usa i componenti nativi di Filament
2. **Tema Scuro**: Supporto automatico
3. **Accessibilità**: Componenti ottimizzati
4. **Manutenibilità**: Codice pulito e standardizzato
