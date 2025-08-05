# Traduzioni del Modulo Chart

## Collegamenti

- [Modulo Lang](../../Lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)

## Aggiornamenti Recenti

### Modulo SaluteOra - Risoluzione Conflitti Git (Gennaio 2025)
**Attività**: Risoluzione conflitti Git nei file di traduzione degli stati appuntamenti

- **File con conflitti**: 
  - `laravel/Modules/SaluteOra/lang/it/appointment.php`
  - `laravel/Modules/SaluteOra/lang/en/appointment.php`
  - `laravel/Modules/SaluteOra/lang/de/appointment.php`
- **Soluzione**: Mantenute le versioni corrette con icone valide (dopo `=======`)
- **Stati risolti**: rescheduled, refund_to_integrate, refund_integrate
- **Motivazione**: HEAD conteneva icone non valide, commit 023253bb conteneva icone valide
- **Risultato**: Tutti i conflitti risolti, sistema funzionante senza errori

### Modulo SaluteOra - Correzione Icone (Gennaio 2025)
**Attività**: Sostituzione icone non esistenti con icone valide del set Heroicons
- **Problema**: Errori "Svg by name 'o-arrow-path-20-solid' from set 'heroicons' not found" e "Svg by name 'o-arrow-right-left' from set 'heroicons' not found"
- **Causa**: Icone `heroicon-o-arrow-path` e `heroicon-o-arrow-right-left` non esistono nel set Heroicons
- **Soluzione**: Sostituite con icone che esistono realmente nel set Heroicons
- **File aggiornati**: 
  - `laravel/Modules/SaluteOra/lang/it/appointment.php`
  - `laravel/Modules/SaluteOra/lang/en/appointment.php`
  - `laravel/Modules/SaluteOra/lang/de/appointment.php`
- **Stati corretti**: rescheduled, refund_to_integrate, refund_integrate
- **Icone utilizzate**: 
  - `heroicon-o-arrow-left` (per rescheduled)
  - `heroicon-o-arrow-down-on-square` (per refund_to_integrate e refund_integrate)
- **Verifica**: Tutte le icone sono state verificate come esistenti nel set Heroicons

### Modulo SaluteOra - Stati Appuntamenti (Gennaio 2025)
**Attività**: Completamento traduzioni per stati `completed` e `in_progress` mancanti
- **Problema**: Stati `completed` e `in_progress` erano presenti nella logica ma mancavano nelle traduzioni
- **Soluzione**: Aggiunte traduzioni complete per entrambi gli stati in tutte e tre le lingue
- **File aggiornati**: 
  - `laravel/Modules/SaluteOra/lang/it/appointment.php`
  - `laravel/Modules/SaluteOra/lang/en/appointment.php`
  - `laravel/Modules/SaluteOra/lang/de/appointment.php`
- **Stati aggiunti**:
  - `completed` - Completato / Completed / Abgeschlossen
  - `in_progress` - In Corso / In Progress / In Bearbeitung
- **Standard applicati**: Sintassi array breve, strict types, struttura completa con label, color, bg_color, icon, modal_heading, modal_description

### Modulo SaluteOra - Refund Integration (Gennaio 2025)
**Attività**: Completamento traduzioni multilingua per refund integration
- **Problema**: File tedesco incompleto, mancanza coerenza nomi file
- **Soluzione**: Aggiornato file tedesco e creati file mancanti per coerenza
- **File aggiornati**: 
  - `laravel/Modules/SaluteOra/lang/de/refund_to_integrate.php` (completato)
  - `laravel/Modules/SaluteOra/lang/en/refund_integrate.php` (creato)
  - `laravel/Modules/SaluteOra/lang/de/refund_integrate.php` (creato)
- **Standard applicati**: Sintassi array breve, strict types, struttura espansa completa
- **Documentazione**: Aggiornata in `laravel/Modules/SaluteOra/docs/translation_quality_standards.md`

## Struttura

```
Modules/Chart/
└── lang/
    ├── it/
    │   └── chart.php
    └── en/
        └── chart.php
```

## Contenuto

Il file `chart.php` contiene le traduzioni per:

### 1. Tipi di Grafici
- Linee
- Barre
- Torta
- Area
- Radar
- Scatter
- Bubble
- Heatmap

### 2. Configurazione
- Opzioni generali
- Stili e temi
- Interazioni
- Animazioni
- Responsive

### 3. Componenti
- Assi e legende
- Tooltip
- Serie dati
- Griglia
- Zoom
- Esportazione

### 4. Widget e Dashboard
- Widget grafici
- Dashboard personalizzate
- Filtri e controlli
- Aggiornamenti in tempo reale

## Esempi di Implementazione

### 1. Tipi di Grafici
```php
return [
    'types' => [
        'line' => [
            'label' => 'Grafico a Linee',
            'tooltip' => 'Visualizza i dati come linee continue',
            'description' => 'Ideale per mostrare trend nel tempo'
        ],
        'bar' => [
            'label' => 'Grafico a Barre',
            'tooltip' => 'Visualizza i dati come barre verticali',
            'description' => 'Perfetto per confronti diretti'
        ],
        'pie' => [
            'label' => 'Grafico a Torta',
            'tooltip' => 'Visualizza i dati come sezioni di una torta',
            'description' => 'Ottimo per mostrare proporzioni'
        ]
    ]
];
```

### 2. Configurazione
```php
'configuration' => [
    'general' => [
        'title' => [
            'label' => 'Titolo del Grafico',
            'tooltip' => 'Inserisci un titolo descrittivo'
        ],
        'theme' => [
            'label' => 'Tema',
            'tooltip' => 'Seleziona il tema del grafico',
            'options' => [
                'light' => 'Chiaro',
                'dark' => 'Scuro',
                'custom' => 'Personalizzato'
            ]
        ]
    ],
    'interactions' => [
        'hover' => [
            'label' => 'Effetto Hover',
            'tooltip' => 'Configura il comportamento al passaggio del mouse'
        ],
        'click' => [
            'label' => 'Interazione Click',
            'tooltip' => 'Configura le azioni al click'
        ]
    ]
];
```

### 3. Componenti
```php
'components' => [
    'axes' => [
        'x' => [
            'label' => 'Asse X',
            'tooltip' => 'Configura l\'asse orizzontale'
        ],
        'y' => [
            'label' => 'Asse Y',
            'tooltip' => 'Configura l\'asse verticale'
        ]
    ],
    'tooltip' => [
        'enabled' => [
            'label' => 'Abilita Tooltip',
            'tooltip' => 'Mostra informazioni aggiuntive al passaggio del mouse'
        ],
        'format' => [
            'label' => 'Formato',
            'tooltip' => 'Personalizza il formato del tooltip'
        ]
    ]
];
```

### 4. Widget e Dashboard
```php
'widgets' => [
    'chart' => [
        'title' => [
            'label' => 'Titolo Widget',
            'tooltip' => 'Inserisci un titolo per il widget'
        ],
        'refresh' => [
            'label' => 'Aggiornamento',
            'tooltip' => 'Configura l\'intervallo di aggiornamento',
            'options' => [
                'manual' => 'Manuale',
                'auto' => 'Automatico',
                'realtime' => 'Tempo Reale'
            ]
        ]
    ],
    'dashboard' => [
        'layout' => [
            'label' => 'Layout',
            'tooltip' => 'Configura il layout della dashboard'
        ],
        'filters' => [
            'label' => 'Filtri',
            'tooltip' => 'Gestisci i filtri della dashboard'
        ]
    ]
];
```

## Best Practices

### 1. Organizzazione
- Raggruppa le traduzioni per contesto
- Usa chiavi descrittive e gerarchiche
- Mantieni la coerenza tra le lingue
- Documenta le traduzioni complesse

### 2. Performance
- Carica solo le traduzioni necessarie
- Utilizza la cache per le traduzioni statiche
- Ottimizza i file di grandi dimensioni
- Implementa il lazy loading dove possibile

### 3. Accessibilità
- Fornisci descrizioni chiare per i tooltip
- Includi testi alternativi per le immagini
- Supporta le descrizioni per screen reader
- Mantieni la coerenza nei messaggi di stato

### 4. Testing
- Verifica tutte le traduzioni
- Testa il fallback delle lingue
- Controlla la coerenza dei formati
- Valuta le performance di caricamento 
- Valuta le performance di caricamento 
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

