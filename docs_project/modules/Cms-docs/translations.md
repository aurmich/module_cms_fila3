# Traduzioni del Modulo Cms

## Collegamenti

- [Modulo Lang](../../Lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)
- [Convenzioni Namespace](../conventions/namespaces.md)

## Struttura

```
Modules/Cms/
└── lang/
    ├── it/
    │   ├── cms.php
    │   ├── menu.php
    │   ├── page.php
    │   ├── page_content.php
    │   ├── section.php
    │   └── ...
    └── en/
        └── cms.php
```

## Contenuto

Il file `cms.php` contiene le traduzioni per:
- Gestione contenuti
- Pagine
- Articoli
- Categorie
- Tag
- Media
- SEO
- Blocchi di contenuto
- Widget
- Menu
- Form

## Best Practices

### 1. Struttura delle Traduzioni
```php
return [
    'sections' => [
        'fields' => [
            'name' => [
                'label' => 'Nome',
                'tooltip' => 'Inserisci il nome della sezione'
            ],
            'slug' => [
                'label' => 'Slug',
                'tooltip' => 'Identificatore univoco della sezione'
            ]
        ]
    ],
    'blocks' => [
        'quick_links' => [
            'fields' => [
                'label' => [
                    'label' => 'Etichetta',
                    'tooltip' => 'Inserisci l\'etichetta per i link rapidi'
                ]
            ]
        ]
    ]
];
```

### 2. Utilizzo nei Componenti
```php
// ✅ CORRETTO
TextInput::make('name')
    ->translateLabel() // Usa la chiave di traduzione basata sul campo

// ✅ CORRETTO
TextInput::make('name')
    ->label(__('cms::sections.fields.name'))

// ❌ ERRATO
TextInput::make('name')
    ->label('Nome') // Stringa hardcoded
```

### 3. Regole per i Blocchi
- Ogni blocco deve avere le proprie traduzioni
- Le traduzioni devono seguire la struttura gerarchica
- Includere sempre tooltip e descrizioni
- Non utilizzare mai stringhe hardcoded

### 4. Gestione dei Form
- Utilizzare sempre le traduzioni per i campi
- Aggiungere tooltip descrittivi
- Includere messaggi di validazione
- Gestire le traduzioni per le azioni

### 5. Documentazione
- Mantenere aggiornata la documentazione
- Fornire esempi chiari
- Documentare le eccezioni
- Creare collegamenti bidirezionali

## Esempi Comuni

### 1. Sezioni
```php
'sections' => [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Inserisci il nome della sezione'
        ],
        'content' => [
            'label' => 'Contenuto',
            'tooltip' => 'Inserisci il contenuto della sezione'
        ]
    ]
]
```

### 2. Blocchi
```php
'blocks' => [
    'quick_links' => [
        'fields' => [
            'label' => [
                'label' => 'Etichetta',
                'tooltip' => 'Inserisci l\'etichetta per i link rapidi'
            ],
            'links' => [
                'label' => 'Link',
                'tooltip' => 'Aggiungi i link rapidi',
                'fields' => [
                    'label' => [
                        'label' => 'Etichetta',
                        'tooltip' => 'Inserisci l\'etichetta del link'
                    ],
                    'url' => [
                        'label' => 'URL',
                        'tooltip' => 'Inserisci l\'URL del link'
                    ]
                ]
            ]
        ]
    ]
]
```

### 3. Form
```php
'forms' => [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Inserisci il nome',
            'placeholder' => 'Inserisci il nome',
            'validation' => [
                'required' => 'Il campo nome è obbligatorio',
                'min' => 'Il nome deve essere di almeno :min caratteri'
            ]
        ]
    ]
]
```

## Troubleshooting

### Problemi Comuni
1. **Stringhe Hardcoded**
   - Verificare che non ci siano `->label()` con stringhe
   - Utilizzare sempre le traduzioni

2. **Namespace Errati**
   - Controllare che i namespace non includano `App`
   - Seguire la struttura corretta

3. **Traduzioni Mancanti**
   - Verificare la presenza di tutte le traduzioni
   - Aggiungere le traduzioni mancanti

4. **Struttura Errata**
   - Seguire la gerarchia corretta
   - Mantenere la coerenza tra i file

## Collegamenti alla Documentazione

### Documentazione del Modulo Lang
- [Struttura delle Traduzioni](../Lang/docs/structure.md)
- [Best Practices per le Traduzioni](../Lang/docs/best-practices.md)
- [Guida all'Installazione](../Lang/docs/installation.md)

### Documentazione Correlata
- [Documentazione Root](../../../docs/README.md)
- [Documentazione UI](../../UI/docs/README.md)
- [Documentazione Sezioni](./section-management.md)

## Struttura delle Traduzioni

### File di Traduzione
Le traduzioni sono organizzate per lingua nella directory `lang/`:
```
lang/
├── it/
│   ├── menu.php
│   ├── page.php
│   ├── page_content.php
│   ├── section.php
│   └── ...
└── ...
```

### Struttura del File
Ogni file di traduzione deve seguire questa struttura:
```php
return [
    'navigation' => [
        'name' => 'Nome',
        'plural' => 'Nomi',
        'group' => [
            'name' => 'Gruppo',
            'description' => 'Descrizione',
        ],
        'label' => 'Etichetta',
        'sort' => 1,
        'icon' => 'icona',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID',
        ],
        // ...
    ],
    'actions' => [
        'create' => 'Crea',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
    ],
    'messages' => [
        'created' => 'Creato con successo',
        'updated' => 'Aggiornato con successo',
        'deleted' => 'Eliminato con successo',
    ],
];
```

## Traduzioni delle Sezioni

### Struttura del File section.php
```php
return [
    'navigation' => [
        'label' => 'Sezioni',
        'group' => 'Gestione Contenuti',
        'icon' => 'heroicon-o-rectangle-stack',
        'sort' => 85,
    ],
    'fields' => [
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
        ],
        'resetFilters' => [
            'label' => 'Reimposta Filtri',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
        ],
    ],
    'model' => [
        'label' => 'Sezione',
    ],
];
```

### Campi Traducibili
- `name`: Nome della sezione
- `blocks`: Contenuto dei blocchi della sezione

## Best Practices

### 1. Nomenclatura
- Usare chiavi descrittive e consistenti
- Seguire la convenzione `modulo.entità.campo`
- Mantenere la coerenza tra le lingue

### 2. Gestione Campi
- Ogni campo deve avere `label` e `placeholder`
- Usare descrizioni chiare e concise
- Mantenere la coerenza terminologica

### 3. Validazione
- Verificare la presenza di tutte le traduzioni necessarie
- Controllare la coerenza tra le lingue
- Testare le traduzioni in produzione

## Checklist di Verifica

1. [ ] Tutti i campi hanno traduzioni
2. [ ] Le traduzioni sono coerenti tra le lingue
3. [ ] I placeholder sono descrittivi
4. [ ] Le etichette sono chiare e concise
5. [ ] Le traduzioni sono testate

## Esempi Comuni

### Menu
```php
'menu' => [
    'navigation' => [
        'name' => 'Menu',
        'plural' => 'Menu',
        'group' => [
            'name' => 'Gestione Menu',
            'description' => 'Gestione dei menu del sito',
        ],
        'label' => 'Menu',
        'sort' => 57,
        'icon' => 'heroicon-o-bars-3',
    ],
],
```

### Pagine
```php
'page' => [
    'navigation' => [
        'name' => 'Pagine',
        'plural' => 'Pagine',
        'group' => [
            'name' => 'Gestione Contenuti',
            'description' => 'Gestione delle pagine del sito',
        ],
        'label' => 'Pagine',
        'sort' => 5,
        'icon' => 'heroicon-o-document',
    ],
],
```

## Risorse Utili
- [Documentazione Laravel Localization](https://laravel.com/docs/localization)
- [Guida Filament Translations](https://filamentphp.com/docs/3.x/panels/translations)
- [Strumenti di Traduzione](https://laravel-lang.com/)

## Note
Questa documentazione è collegata bidirezionalmente con la documentazione del modulo Lang. Per ulteriori dettagli sulla struttura e le best practices delle traduzioni, consultare la documentazione del modulo Lang. 

Per informazioni specifiche sulla gestione delle sezioni, consultare la [documentazione delle sezioni](./section-management.md).

## Collegamenti tra versioni di translations.md
* [translations.md](laravel/Modules/Chart/docs/translations.md)
* [translations.md](laravel/Modules/Reporting/docs/translations.md)
* [translations.md](laravel/Modules/Gdpr/docs/translations.md)
* [translations.md](laravel/Modules/Notify/docs/translations.md)
* [translations.md](laravel/Modules/Xot/docs/roadmap/lang/translations.md)
* [translations.md](laravel/Modules/Xot/docs/translations.md)
* [translations.md](laravel/Modules/Dental/docs/translations.md)
* [translations.md](laravel/Modules/User/docs/translations.md)
* [translations.md](laravel/Modules/UI/docs/translations.md)
* [translations.md](laravel/Modules/Lang/docs/packages/translations.md)
* [translations.md](laravel/Modules/Lang/docs/translations.md)
* [translations.md](laravel/Modules/Job/docs/translations.md)
* [translations.md](laravel/Modules/Media/docs/translations.md)
* [translations.md](laravel/Modules/Tenant/docs/translations.md)
* [translations.md](laravel/Modules/Activity/docs/translations.md)
* [translations.md](laravel/Modules/Patient/docs/translations.md)
* [translations.md](laravel/Modules/Cms/docs/translations.md)

