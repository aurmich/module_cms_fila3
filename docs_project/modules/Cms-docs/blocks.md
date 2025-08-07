# Blocchi di Contenuto 

## Indice
1. [Introduzione](#introduzione)
2. [Struttura dei Blocchi](#struttura-dei-blocchi)
3. [Tipi di Blocchi](#tipi-di-blocchi)
4. [Integrazione con le Sezioni](#integrazione-con-le-sezioni)
5. [Best Practices](#best-practices)

## Introduzione

I blocchi di contenuto sono i componenti fondamentali per la costruzione delle pagine . Ogni blocco è un'unità modulare di contenuto che può essere riutilizzata e configurata.

## Struttura dei Blocchi

### Configurazione JSON
I blocchi sono definiti in file JSON nella directory `/laravel/config/local/saluteora/database/content/sections/`. Ogni blocco ha questa struttura:

```json
{
    "name": {
        "it": "Nome Blocco",
        "en": "Block Name"
    },
    "type": "tipo_blocco",
    "data": {
        "view": "percorso.vista",
        // Altri dati specifici del blocco
    }
}
```

### Componenti Blade
I blocchi sono renderizzati usando componenti Blade in `/laravel/Themes/One/resources/views/components/blocks/`:

```blade
<!-- /components/blocks/logo.blade.php -->
<div class="logo-block">
    <img src="{{ $src }}" alt="{{ $alt }}" width="{{ $width }}" height="{{ $height }}">
</div>
```

## Tipi di Blocchi

### 1. Logo
- **Tipo**: `logo`
- **Dati**:
  - `view`: `pub_theme::components.blocks.logo`
  - `src`: Percorso immagine
  - `alt`: Testo alternativo
  - `width`: Larghezza
  - `height`: Altezza

### 2. Menu di Navigazione
- **Tipo**: `navigation`
- **Dati**:
  - `view`: `pub_theme::components.blocks.navigation`
  - `items`: Array di voci di menu
  - `alignment`: Allineamento
  - `orientation`: Orientamento

### 3. Selettore Lingua
- **Tipo**: `language-selector`
- **Dati**:
  - `view`: `pub_theme::components.blocks.language-selector`

### 4. Dropdown Utente
- **Tipo**: `user-dropdown`
- **Dati**:
  - `view`: `pub_theme::components.blocks.navigation.user-dropdown`
  - `guest_view`: Vista per utenti non autenticati
  - `menu_items`: Voci del menu

### User Dropdown Block
- **Type**: `user-dropdown`
- **Classe**: `Modules\Cms\Filament\Blocks\UserDropdownBlock`
- **Scopo**: gestire il menu utente nell'header con supporto per stati autenticati e non autenticati.
- **[Documentazione dettagliata](blocks/user-dropdown.md)**

## Integrazione con le Sezioni

### Esempio di Sezione con Blocchi
```json
{
    "id": "1",
    "name": {
        "it": "Header Principale",
        "en": "Main Header"
    },
    "blocks": {
        "it": [
            {
                "name": {
                    "it": "Logo",
                    "en": "Logo"
                },
                "type": "logo",
                "data": {
                    "view": "pub_theme::components.blocks.logo",
                    "src": "patient::images/logo.svg",
                    "alt": "Logo SaluteOra",
                    "width": 150,
                    "height": 32
                }
            },
            {
                "name": {
                    "it": "Menu di Navigazione",
                    "en": "Navigation Menu"
                },
                "type": "navigation",
                "data": {
                    "view": "pub_theme::components.blocks.navigation",
                    "items": [
                        {
                            "label": "Home",
                            "url": "/",
                            "type": "link"
                        }
                    ]
                }
            }
        ]
    }
}
```

## Best Practices

### 1. Struttura dei Blocchi
- Mantenere i blocchi modulari e riutilizzabili
- Documentare tutti i props e le opzioni
- Supportare la localizzazione

### 2. Performance
- Lazy loading per blocchi pesanti
- Caching dei contenuti statici
- Ottimizzazione delle immagini

### 3. Accessibilità
- Includere attributi ARIA
- Fornire testi alternativi
- Supportare la navigazione da tastiera

### 4. Responsive Design
- Usare classi Tailwind responsive
- Testare su diversi dispositivi
- Mantenere la coerenza visiva

## Collegamenti
- [Flusso Frontoffice](./frontoffice-flow.md)
- [Layout e Componenti](./struttura-layout-componenti-blade-saluteora.md)
- [Best Practices UI/UX](./guida-implementazione-ux.md)

# Blocchi di Contenuto

Questo documento descrive i blocchi disponibili per la gestione delle sezioni tramite `SectionResource`.

## Panoramica di SectionResource

Il `SectionResource` utilizza un campo `blocks` per consentire la creazione e l'organizzazione di blocchi di contenuto:

```php
// SectionResource.php
'blocks' => Forms\Components\Section::make('Content')
    ->schema([
        SectionBuilder::make('blocks')->columnSpanFull(),
    ]),
```

Il builder carica dinamicamente tutte le classi di blocco presenti in:
- `Modules/Cms/app/Filament/Blocks`
- `Modules/UI/app/Filament/Blocks`

## SectionBuilder

- Recupera le classi dei blocchi tramite `GetAllBlocksAction`.
- Invoca `BlockClass::make(string $context)` per ogni blocco.
- Restituisce un `Builder` con tutti i blocchi registrati.

## Blocchi Disponibili

### NavigationBlock

- **Type**: `navigation`
- **Classe**: `Modules\Cms\Filament\Blocks\NavigationBlock`
- **Scopo**: gestire le voci del menu di navigazione.
- **[Documentazione dettagliata](blocks/navigation.md)**

### HeroBlock

- **Type**: `hero`
- **Classe**: `Modules\Cms\Filament\Blocks\HeroBlock`
- **Scopo**: creare sezioni hero con immagine di sfondo e call-to-action.
- **[Documentazione dettagliata](blocks/hero.md)**

### ParagraphBlock

- **Type**: `paragraph`
- **Classe**: `Modules\Cms\Filament\Blocks\ParagraphBlock`
- **Scopo**: gestire contenuti testuali formattati.
- **[Documentazione dettagliata](blocks/paragraph.md)**

### FeatureSectionsBlock

- **Type**: `feature_sections`
- **Classe**: `Modules\Cms\Filament\Blocks\FeatureSectionsBlock`
- **Scopo**: presentare caratteristiche con icone e descrizioni.
- **[Documentazione dettagliata](blocks/feature-sections.md)**

### StatsBlock

- **Type**: `stats`
- **Classe**: `Modules\Cms\Filament\Blocks\StatsBlock`
- **Scopo**: visualizzare statistiche e metriche chiave.
- **[Documentazione dettagliata](blocks/stats.md)**

### CtaBlock

- **Type**: `cta`
- **Classe**: `Modules\Cms\Filament\Blocks\CtaBlock`
- **Scopo**: creare sezioni di chiamata all'azione.
- **[Documentazione dettagliata](blocks/cta.md)**

### FooterInfoBlock

- **Type**: `footer.info`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterInfoBlock`
- **Scopo**: gestire le informazioni principali del footer.
- **[Documentazione dettagliata](blocks/footer-info.md)**

### FooterLinksBlock

- **Type**: `footer.links`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterLinksBlock`
- **Scopo**: gestire i link di navigazione nel footer.
- **[Documentazione dettagliata](blocks/footer-links.md)**

### FooterSocialBlock

- **Type**: `footer.social`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterSocialBlock`
- **Scopo**: gestire i link ai social media nel footer.
- **[Documentazione dettagliata](blocks/footer-social.md)**

### FooterContactBlock

- **Type**: `footer.contact`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterContactBlock`
- **Scopo**: gestire le informazioni di contatto nel footer.
- **[Documentazione dettagliata](blocks/footer-contact.md)**

### FooterNewsletterBlock

- **Type**: `footer.newsletter`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterNewsletterBlock`
- **Scopo**: gestire il form di iscrizione alla newsletter nel footer.
- **[Documentazione dettagliata](blocks/footer-newsletter.md)**

### FooterQuickLinksBlock

- **Type**: `footer.quick-links`
- **Classe**: `Modules\Cms\Filament\Blocks\FooterQuickLinksBlock`
- **Scopo**: gestire i link rapidi nel footer.
- **[Documentazione dettagliata](blocks/footer-quick-links.md)**

### Language Switcher Block
Il blocco per il selettore delle lingue supporta l'utilizzo di flag SVG come componenti Blade.

#### Struttura
```php
'language-switcher' => [
    'view' => 'pub_theme::components.blocks.language-switcher',
    'data' => [
        'languages' => [
            [
                'code' => 'it',
                'name' => 'Italiano',
                'flag' => '<x-ui-flags.it class="w-5 h-5" />',
                'short_name' => 'IT',
                'animation' => 'bounce',
                'tooltip' => 'Passa a Italiano',
                'style' => [
                    'hover_effect' => 'scale',
                    'transition' => 'all 0.3s ease',
                    'active_color' => 'primary-600',
                    'inactive_color' => 'gray-400'
                ]
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'flag' => '<x-ui-flags.gb class="w-5 h-5" />',
                'short_name' => 'EN',
                'animation' => 'pulse',
                'tooltip' => 'Switch to English',
                'style' => [
                    'hover_effect' => 'scale',
                    'transition' => 'all 0.3s ease',
                    'active_color' => 'primary-600',
                    'inactive_color' => 'gray-400'
                ]
            ]
        ],
        'current' => 'it',
        'alignment' => 'end',
        'display' => [
            'type' => 'button',
            'show_flag' => true,
            'show_name' => true,
            'show_short_name' => true,
            'tooltip_position' => 'bottom',
            'tooltip_animation' => 'fade'
        ],
        'interactions' => [
            'hover_effect' => true,
            'click_animation' => true,
            'ripple_effect' => true,
            'sound_effect' => false
        ]
    ]
]
```

#### Flag SVG
I flag sono implementati come componenti Blade SVG e sono disponibili nella directory `laravel/Modules/UI/resources/svg/flags/`. Per utilizzarli:

1. **Componente Blade**:
```blade
<x-ui-flags.it class="w-5 h-5" />  {{-- Bandiera italiana --}}
<x-ui-flags.gb class="w-5 h-5" />  {{-- Bandiera inglese --}}
```

2. **Classi Tailwind**:
- `w-5 h-5`: dimensioni standard (20x20px)
- `text-current`: eredita il colore dal contesto
- `hover:scale-110`: effetto hover di ingrandimento
- `transition-transform`: transizione fluida

3. **Best Practices**:
- Mantenere le dimensioni consistenti
- Utilizzare classi Tailwind per lo styling
- Evitare dimensioni fisse in pixel
- Supportare il tema dark/light

## Aggiungere un Nuovo Blocco

1. Creare `Modules/Cms/app/Filament/Blocks/YourBlock.php`.
2. Definire una classe con `public static function make(string $context): Block`.
3. Restituire `Block::make('<type>')` con `label()` e `schema()` appropriati.
4. Aggiungere le traduzioni in `lang/<locale>/blocks.php`.
5. Creare la documentazione in `docs/blocks/your-block.md`.

## Best Practices

1. **Naming**:
   - Utilizzare nomi descrittivi per i blocchi
   - Seguire le convenzioni di naming Laravel
   - Mantenere coerenza con gli altri blocchi

2. **Struttura**:
   - Estendere `XotBaseBlock`
   - Implementare `getBlockSchema()`
   - Documentare tutti i campi

3. **Validazione**:
   - Definire regole di validazione appropriate
   - Utilizzare messaggi di errore chiari
   - Gestire correttamente i campi obbligatori

4. **Documentazione**:
   - Mantenere la documentazione aggiornata
   - Includere esempi di utilizzo
   - Specificare best practices

## Collegamenti

- [Filament Forms](filament-forms.md)
- [UI Components](ui/components.md)
- [Content Management](content.md)
- [Best Practices](best-practices/index.md)

# Blocchi CMS

## Panoramica
I blocchi sono componenti riutilizzabili che possono essere utilizzati nelle sezioni del CMS. Ogni blocco ha una vista Blade associata e può ricevere dati tramite JSON.

## Best Practices per le Traduzioni

### 1. Chiavi di Traduzione
- Utilizzare SEMPRE chiavi in inglese
- Seguire la convenzione `namespace.key` (es: `auth.login`, `navigation.home`)
- Evitare hardcoding di stringhe in qualsiasi lingua
- Mantenere le chiavi in lowercase con underscore

### 2. File di Traduzione
- Definire tutte le traduzioni in `lang/{locale}/` 
- Organizzare le traduzioni per namespace
- Mantenere la coerenza tra le diverse lingue

### 3. Esempi Corretti
```php
// ❌ NON FARE
__('Accedi')
__('Benvenuto')

// ✅ FARE
__('auth.login')
__('welcome.message')
```

### 4. Struttura dei File di Lingua
```php
// lang/it/auth.php
return [
    'login' => 'Accedi',
    'register' => 'Registrati',
    'logout' => 'Esci'
];

// lang/en/auth.php
return [
    'login' => 'Login',
    'register' => 'Register',
    'logout' => 'Logout'
];
```

### 5. Best Practices
- Mantenere le chiavi semantiche e descrittive
- Utilizzare namespace per organizzare le traduzioni
- Evitare duplicazione di chiavi
- Documentare le chiavi di traduzione
- Testare la presenza di tutte le traduzioni

## Blocchi Disponibili

### Logo Block
```php
'logo' => [
    'view' => 'pub_theme::components.blocks.logo',
    'data' => [
        'src' => '/images/logo.svg',
        'alt' => 'Logo',
        'width' => 150,
        'height' => 32
    ]
]
```

### Navigation Block
```php
'navigation' => [
    'view' => 'pub_theme::components.blocks.navigation',
    'data' => [
        'items' => [
            [
                'label' => 'Home',
                'url' => '/',
                'type' => 'link'
            ]
        ]
    ]
]
```

### Language Switcher Block
```php
'language-switcher' => [
    'view' => 'pub_theme::components.blocks.language-switcher',
    'data' => [
        'languages' => [
            [
                'code' => 'it',
                'name' => 'Italiano',
                'flag' => '<x-ui-flags.it class="w-5 h-5" />',
                'short_name' => 'IT',
                'animation' => 'bounce',
                'tooltip' => 'Passa a Italiano',
                'style' => [
                    'hover_effect' => 'scale',
                    'transition' => 'all 0.3s ease',
                    'active_color' => 'primary-600',
                    'inactive_color' => 'gray-400'
                ]
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'flag' => '<x-ui-flags.gb class="w-5 h-5" />',
                'short_name' => 'EN',
                'animation' => 'pulse',
                'tooltip' => 'Switch to English',
                'style' => [
                    'hover_effect' => 'scale',
                    'transition' => 'all 0.3s ease',
                    'active_color' => 'primary-600',
                    'inactive_color' => 'gray-400'
                ]
            ]
        ],
        'current' => 'it',
        'alignment' => 'end',
        'display' => [
            'type' => 'button',
            'show_flag' => true,
            'show_name' => true,
            'show_short_name' => true,
            'tooltip_position' => 'bottom',
            'tooltip_animation' => 'fade'
        ],
        'interactions' => [
            'hover_effect' => true,
            'click_animation' => true,
            'ripple_effect' => true,
            'sound_effect' => false
        ]
    ]
]
```

### Caratteristiche del Language Switcher

1. **Visualizzazione**:
   - Bandiere delle lingue
   - Nomi completi e abbreviazioni
   - Indicatore della lingua attiva
   - Tooltip informativi

2. **Interattività**:
   - Effetti hover personalizzati
   - Animazioni al click
   - Effetto ripple
   - Transizioni fluide

3. **Personalizzazione**:
   - Stili configurabili per ogni lingua
   - Posizionamento flessibile
   - Opzioni di display multiple
   - Effetti animazione personalizzabili

4. **Accessibilità**:
   - Supporto per screen reader
   - Navigazione da tastiera
   - Contrasto adeguato
   - Focus visibile

### User Menu Block
```php
'user-menu' => [
    'view' => 'pub_theme::components.blocks.user-menu',
    'data' => [
        'avatar' => [
            'src' => '/images/avatar.png',
            'alt' => 'User Avatar'
        ],
        'items' => [
            [
                'label' => 'Profilo',
                'url' => '/profile',
                'icon' => 'user'
            ],
            [
                'label' => 'Impostazioni',
                'url' => '/settings',
                'icon' => 'cog'
            ],
            [
                'label' => 'Logout',
                'url' => '/logout',
                'icon' => 'logout',
                'method' => 'post'
            ]
        ],
        'alignment' => 'end'
    ]
]
```

## Utilizzo dei Blocchi

I blocchi possono essere utilizzati in due modi:

1. **Direttamente nelle sezioni**:
```php
Section::create([
    'blocks' => [
        [
            'type' => 'logo',
            'data' => [...]
        ]
    ]
]);
```

2. **Come componenti Blade**:
```blade
<x-cms::block type="logo" :data="$data" />
```

## Best Practices

1. Mantenere i blocchi piccoli e focalizzati
2. Riutilizzare i blocchi quando possibile
3. Documentare i dati richiesti per ogni blocco
4. Implementare la validazione dei dati
5. Gestire correttamente le traduzioni
6. Assicurare l'accessibilità
7. Implementare la responsività
8. Gestire correttamente gli stati di caricamento

## Collegamenti
- [Documentazione Sezioni](sections.md)
- [Documentazione Frontoffice](frontoffice.md)
- [Documentazione Navigation](navigation.md)

## Struttura dei Blocchi

Ogni blocco nel CMS segue una struttura comune:

```php
[
    "name" => [
        "it" => "Nome Blocco",
        "en" => "Block Name"
    ],
    "type" => "tipo_blocco",
    "data" => [
        // Dati specifici del blocco
    ]
]
```

## Best Practices

### 1. Internazionalizzazione

- Tutti i testi devono supportare la traduzione
- Utilizzare array associativi per le traduzioni:
```php
"label" => [
    "it" => "Etichetta",
    "en" => "Label"
]
```
- Gestire i fallback per le traduzioni mancanti:
```php
$label = is_array($item['label']) ? ($item['label'][$locale] ?? '') : ($item['label'] ?? '');
```

### 2. Gestione URL

- Gli URL possono essere sia stringhe che array tradotti
- Implementare la stessa logica di fallback degli altri campi:
```php
$url = is_array($item['url']) ? ($item['url'][$locale] ?? '#') : ($item['url'] ?? '#');
```

### 3. Stili e Classi

- Definire array di classi per ogni variante di stile
- Utilizzare classi base comuni per tutti gli elementi dello stesso tipo
- Organizzare le classi per funzionalità:
```php
$buttonClasses = [
    'primary' => 'border-transparent text-white bg-primary-600 hover:bg-primary-700',
    'secondary' => 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50',
    'outline' => 'border-primary-600 text-primary-600 bg-transparent hover:bg-primary-50',
    'link' => 'text-primary-600 hover:text-primary-900 underline'
];
```

### 4. Layout e Spaziatura

- Utilizzare sistemi di spaziatura coerenti
- Supportare diverse configurazioni di allineamento
- Definire valori predefiniti sensati:
```php
$gapClasses = [
    2 => 'space-x-2',
    3 => 'space-x-3',
    4 => 'space-x-4', // default
    5 => 'space-x-5',
    6 => 'space-x-6',
    8 => 'space-x-8'
];
```

### 5. Accessibilità

- Includere sempre stati di focus visibili
- Aggiungere attributi ARIA quando necessario
- Utilizzare target appropriati per i link
- Mantenere un contrasto adeguato nei colori

## Tipi di Blocchi

### 1. Navigation Block
- Supporta menu multilivello
- Gestisce orientamento orizzontale/verticale
- Supporta dropdown per sottomenu
- Configurazione flessibile dell'allineamento

### 2. Actions Block
- Supporta multiple varianti di pulsanti
- Integrazione con icone
- Spaziatura configurabile
- Allineamento flessibile

### 3. Logo Block
- Supporta sia immagini che testo
- Gestisce dimensioni configurabili
- Supporta link personalizzati
- Gestisce alt text multilingua

## Validazione

Ogni blocco dovrebbe implementare:
1. Valori predefiniti per tutti i parametri opzionali
2. Controlli di tipo per i dati in ingresso
3. Fallback per dati mancanti o non validi

## Performance

- Minimizzare le chiamate al database
- Utilizzare cache per i dati statici
- Ottimizzare le query per i contenuti dinamici
- Lazy loading per le immagini quando appropriato

## Sicurezza

- Sanitizzare tutti gli input
- Escape corretto dell'output HTML
- Validazione degli URL
- Controllo dei permessi quando necessario

## Manutenibilità

1. Separare la logica in componenti riutilizzabili
2. Mantenere una struttura coerente tra i blocchi
3. Documentare le opzioni di configurazione
4. Utilizzare costanti per valori comuni

## Testing

Ogni blocco dovrebbe avere test per:
1. Rendering corretto
2. Gestione delle traduzioni
3. Comportamento responsive
4. Gestione degli errori
5. Accessibilità

## Collegamenti tra versioni di blocks.md
* [blocks.md](laravel/Modules/Xot/docs/blocks.md)
* [blocks.md](laravel/Modules/User/resources/views/docs/blocks.md)
* [blocks.md](laravel/Modules/UI/docs/blocks.md)
* [blocks.md](laravel/Modules/Cms/docs/blocks.md)
* [blocks.md](laravel/Themes/One/docs/blocks.md)
* [blocks.md](laravel/Themes/One/docs/components/blocks.md)

## Blocco Estetico (Aesthetic Block)
Per creare componenti di tipo blocco eleganti e armoniosi, segui queste linee guida:

- **Design minimalista**: utilizza spazi bianchi generosi, tipografia pulita e palette colori soft.
- **Effetti di profondità**: applica ombre delicate e glassmorphism per favorire gerarchia visiva.
- **Animazioni sottili**: introduce micro-interazioni (fade-in, slide, hover) per un’esperienza dinamica ma non distraente.
- **Accessibilità**: garantisci contrasto sufficiente, focus visibili e supporto nav da tastiera.
- **Composizione modulare**: ogni blocco deve essere un componente riutilizzabile, con prop clear e callbacks.
- **Localizzazione**: estrai testi in file JSON/locale e rispetta le convenzioni di traduzione (nessun `.navigation`).

### Esempio di Aesthetic Hero Block
```blade
<x-cms::blocks.aesthetic-hero
    :title="__('cms::blocks.hero.title')"
    :subtitle="__('cms::blocks.hero.subtitle')"
    image="/img/hero-bg.jpg"
/>
```

### File di Blade: resources/views/blocks/aesthetic-hero.blade.php
```blade
<div class="relative bg-white/70 backdrop-blur-md rounded-lg overflow-hidden p-8 shadow-lg">
    <img src="{{ $image }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-20" />
    <div class="relative z-10 text-center">
        <h2 class="text-3xl font-semibold mb-4">{{ $title }}</h2>
        <p class="text-lg text-gray-700">{{ $subtitle }}</p>
    </div>
</div>

```

> **Nota**: Questo blocco utilizza il plugin [filament-spatie-translatable](https://github.com/filamentphp/spatie-laravel-translatable-plugin) per gestire automaticamente le traduzioni. Di conseguenza, nei template Blade dei blocchi puoi usare direttamente le variabili translatabili come `$title`, `$subtitle` senza accedere manualmente all'array di data.
