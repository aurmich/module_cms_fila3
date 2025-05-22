# Header Section

L'header è una sezione fondamentale del tema che gestisce la navigazione principale del sito.

## Struttura

L'header è composto da quattro blocchi principali:
- Logo
- Navigation
- Language Switcher
- User Menu

### Componenti Necessari

1. Il componente `<x-section>` deve essere presente in `resources/views/components/section.blade.php`
2. I dati della sezione devono essere presenti nel database (tabella `sections`)
3. I blocchi `logo`, `navigation`, `language-switcher` e `user-menu` devono essere registrati nel modulo CMS

## Gestione delle Traduzioni

### Chiavi di Traduzione
Tutte le stringhe nell'header devono utilizzare chiavi di traduzione in inglese:

```php
// ❌ NON FARE
__('Accedi')
__('Benvenuto')

// ✅ FARE
__('auth.login')
__('welcome.message')
```

### File di Traduzione
Le traduzioni devono essere definite in:
```
lang/
├── it/
│   ├── auth.php
│   ├── navigation.php
│   └── user.php
└── en/
    ├── auth.php
    ├── navigation.php
    └── user.php
```

### Esempio di Struttura
```php
// lang/it/auth.php
return [
    'login' => 'Accedi',
    'register' => 'Registrati',
    'logout' => 'Esci'
];

// lang/it/navigation.php
return [
    'home' => 'Home',
    'services' => 'Servizi',
    'about' => 'Chi Siamo',
    'contact' => 'Contatti'
];

// lang/it/user.php
return [
    'profile' => 'Profilo',
    'settings' => 'Impostazioni'
];
```

## Configurazione

### 1. Layout

L'header viene incluso nel layout principale tramite:

```blade
<x-section slug="header" />
```

### 2. Database

I dati dell'header vengono inseriti tramite il seeder `SectionsTableSeeder`:

```php
Section::create([
    'name' => ['it' => 'Header', 'en' => 'Header'],
    'slug' => 'header',
    'blocks' => [
        [
            'type' => 'logo',
            'data' => [...]
        ],
        [
            'type' => 'navigation',
            'data' => [...]
        ],
        [
            'type' => 'language-switcher',
            'data' => [
                'languages' => [
                    [
                        'code' => 'it',
                        'name' => 'Italiano',
                        'flag' => '/images/flags/it.svg'
                    ],
                    [
                        'code' => 'en',
                        'name' => 'English',
                        'flag' => '/images/flags/en.svg'
                    ]
                ],
                'current' => 'it'
            ]
        ],
        [
            'type' => 'user-menu',
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
                ]
            ]
        ]
    ]
]);
```

### 3. Blocchi

#### Logo Block
```php
'logo' => [
    'image' => '/themes/One/images/logo.svg',
    'alt' => 'Logo',
    'text' => 'One Theme',
    'type' => 'both', // image, text, both
    'url' => '/'
]
```

#### Navigation Block
```php
'navigation' => [
    'items' => [
        [
            'label' => 'Home',
            'url' => '/',
            'type' => 'link'
        ],
        [
            'label' => 'Servizi',
            'url' => '/servizi',
            'type' => 'dropdown',
            'children' => [...]
        ]
    ],
    'alignment' => 'end', // start, center, end
    'orientation' => 'horizontal' // horizontal, vertical
]
```

#### Language Switcher Block
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
            'type' => 'button', // button, dropdown, pills
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

#### User Menu Block
```php
'user-menu' => [
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
```

### Stile Clickbait per Language Switcher

Il language switcher è stato progettato per essere più interattivo e accattivante con:

1. **Effetti Visivi**:
   - Animazioni al passaggio del mouse
   - Effetto ripple al click
   - Transizioni fluide
   - Colori vivaci per la lingua attiva

2. **Interattività**:
   - Tooltip informativi
   - Feedback visivo immediato
   - Animazioni al cambio lingua
   - Effetti di hover personalizzati

3. **Personalizzazione**:
   - Stili configurabili per ogni lingua
   - Effetti animazione personalizzabili
   - Posizionamento flessibile dei tooltip
   - Opzioni di display multiple

1. Mantenere il logo di dimensioni ragionevoli
2. Limitare il numero di voci nel menu principale
3. Utilizzare dropdown solo quando necessario
4. Assicurarsi che il menu sia responsive
5. Testare la navigazione su dispositivi mobili 

## Collegamenti tra versioni di header.md
* [header.md](docs/sections/header.md)
* [header.md](laravel/Modules/Cms/docs/components/header.md)
* [header.md](laravel/Modules/Cms/docs/sections/header.md)
* [header.md](laravel/Themes/One/docs/sections/header.md)

4. **Accessibilità**:
   - Contrasto adeguato
   - Focus visibile
   - Testi alternativi
   - Navigazione da tastiera

### Utilizzo dei Flag SVG

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
