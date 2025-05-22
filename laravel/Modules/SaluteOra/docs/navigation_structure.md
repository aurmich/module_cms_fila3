# Struttura della Navigazione in SaluteOra

## Panoramica

Questo documento descrive la struttura standardizzata della navigazione utilizzata in SaluteOra, con particolare attenzione alla gestione delle traduzioni e delle proprietà dei menu.

## Struttura Base della Navigazione

Ogni elemento di navigazione in SaluteOra deve seguire una struttura standardizzata:

```php
'navigation' => [
    'label' => 'Etichetta Menu',
    'sort' => 37, // Ordine nel menu
    'icon' => 'heroicon-o-user-group',
    'color' => 'primary'
]
```

## Esempi di Implementazione

### 1. Menu Principale
```php
'navigation' => [
    'label' => 'Gestione Pazienti',
    'sort' => 37,
    'icon' => 'heroicon-o-user-group',
    'color' => 'primary'
]
```

### 2. Sottomenu
```php
'navigation' => [
    'label' => 'Gestione Medici',
    'sort' => 38,
    'icon' => 'heroicon-o-user-group',
    'color' => 'primary',
    'group' => 'Amministrazione'
]
```

## Proprietà della Navigazione

### 1. Label
- Deve essere chiaro e descrittivo
- Non deve finire con `.navigation`
- Deve essere tradotto in tutte le lingue supportate

### 2. Sort
- Numero intero che determina l'ordine nel menu
- Valori più bassi appaiono prima
- Mantenere intervalli ragionevoli per future inserzioni

### 3. Icon
- Utilizzare le icone di Heroicons
- Prefisso `heroicon-o-` per outline
- Prefisso `heroicon-s-` per solid

### 4. Color
- Utilizzare i colori predefiniti di Filament
- `primary`, `secondary`, `success`, `danger`, `warning`, `info`

## Best Practices

1. **Organizzazione**
   - Raggruppare elementi correlati
   - Mantenere una struttura logica
   - Usare prefissi coerenti per i gruppi

2. **Naming**
   - Usare nomi descrittivi
   - Mantenere la coerenza tra le diverse sezioni
   - Evitare nomi troppo lunghi o complessi

3. **Ordine**
   - Organizzare gli elementi in modo logico
   - Lasciare spazio per future aggiunte
   - Documentare l'ordine scelto

4. **Accessibilità**
   - Usare icone intuitive
   - Fornire etichette chiare
   - Mantenere una struttura coerente

## Esempi di Implementazione Completa

### Menu Completo con Sottomenu
```php
'navigation' => [
    'label' => 'Gestione Clinica',
    'sort' => 30,
    'icon' => 'heroicon-o-building-office',
    'color' => 'primary',
    'group' => 'Amministrazione',
    'items' => [
        'patients' => [
            'label' => 'Pazienti',
            'sort' => 1,
            'icon' => 'heroicon-o-user-group',
            'color' => 'primary'
        ],
        'doctors' => [
            'label' => 'Medici',
            'sort' => 2,
            'icon' => 'heroicon-o-user-group',
            'color' => 'success'
        ],
        'appointments' => [
            'label' => 'Appuntamenti',
            'sort' => 3,
            'icon' => 'heroicon-o-calendar',
            'color' => 'warning'
        ]
    ]
]
```

### Menu con Permessi
```php
'navigation' => [
    'label' => 'Amministrazione',
    'sort' => 100,
    'icon' => 'heroicon-o-cog',
    'color' => 'danger',
    'permission' => 'admin.access',
    'items' => [
        'users' => [
            'label' => 'Utenti',
            'sort' => 1,
            'icon' => 'heroicon-o-users',
            'color' => 'primary',
            'permission' => 'users.manage'
        ],
        'roles' => [
            'label' => 'Ruoli',
            'sort' => 2,
            'icon' => 'heroicon-o-shield-check',
            'color' => 'success',
            'permission' => 'roles.manage'
        ]
    ]
]
```

## Note Importanti

1. **Traduzioni**
   - Tutte le etichette devono essere tradotte
   - Mantenere la coerenza tra le lingue
   - Usare il namespace corretto (`saluteora::`)

2. **Permessi**
   - Definire i permessi necessari
   - Verificare l'accesso prima di mostrare
   - Documentare i requisiti di accesso

3. **Manutenzione**
   - Aggiornare la documentazione quando si modificano i menu
   - Verificare la coerenza dopo le modifiche
   - Testare la navigazione in tutte le lingue 