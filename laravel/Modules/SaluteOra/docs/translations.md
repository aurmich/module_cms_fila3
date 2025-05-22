# Gestione delle Traduzioni in SaluteOra

## Struttura delle Traduzioni

Le traduzioni in SaluteOra seguono una struttura standardizzata per garantire consistenza e manutenibilità:

### Struttura Base
```php
return [
    'name' => 'Nome Modulo',
    'navigation' => [
        'label' => 'Etichetta Navigazione',
        'sort' => 37, // Ordine nel menu
        'icon' => 'heroicon-o-user-group',
        'color' => 'primary'
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Testo Placeholder',
            'helper_text' => 'Testo di Aiuto',
            'description' => 'Descrizione Dettagliata',
            'tooltip' => 'Tooltip al Passaggio del Mouse'
        ]
    ]
];
```

### Regole Importanti

1. **Struttura dei Campi**
   - Ogni campo deve avere almeno una `label`
   - I campi di input devono avere un `placeholder`
   - Usare `helper_text` per suggerimenti brevi
   - Usare `description` per spiegazioni più dettagliate
   - Usare `tooltip` per informazioni contestuali

2. **Navigazione**
   - Non usare mai `.navigation` come suffisso
   - Includere sempre `sort` per l'ordine nel menu
   - Specificare `icon` e `color` per la coerenza visiva

3. **Steps**
   - Ogni step deve avere `label` e `description`
   - Includere `icon` e `color` per la coerenza visiva
   - Mantenere una struttura gerarchica chiara

4. **Actions**
   - Ogni azione deve avere una `label`
   - Includere `tooltip` per spiegazioni contestuali
   - Per le azioni modali, includere `heading` e `description`

5. **Messages**
   - Organizzare i messaggi in categorie (success, errors, confirmations)
   - Mantenere un tono professionale e chiaro
   - Includere messaggi per tutte le azioni CRUD

### Best Practices

1. **Organizzazione**
   - Mantenere le traduzioni nella cartella `lang` del modulo
   - Evitare duplicati tra `resources/lang` e `lang`
   - Usare namespace coerenti (`saluteora::`)

2. **Naming**
   - Usare nomi descrittivi e in inglese per le chiavi
   - Mantenere una struttura gerarchica logica
   - Evitare chiavi troppo lunghe o complesse

3. **Manutenzione**
   - Aggiornare le traduzioni quando si aggiungono nuovi campi
   - Mantenere la coerenza tra le diverse lingue
   - Documentare eventuali eccezioni o casi speciali

4. **Validazione**
   - Verificare che tutte le chiavi necessarie siano presenti
   - Controllare la coerenza tra le diverse lingue
   - Testare le traduzioni in contesto

### Esempi di Implementazione

#### Campo Base
```php
'email' => [
    'label' => 'Email',
    'placeholder' => 'Inserisci l\'indirizzo email',
    'helper_text' => 'Indirizzo email valido',
    'description' => 'Email per le comunicazioni',
    'tooltip' => 'Verrà utilizzata per le comunicazioni importanti'
]
```

#### Step
```php
'personal_data_step' => [
    'label' => 'Dati Personali',
    'description' => 'Inserisci i tuoi dati personali',
    'icon' => 'heroicon-o-user',
    'color' => 'primary'
]
```

#### Action
```php
'create' => [
    'label' => 'Nuovo Paziente',
    'tooltip' => 'Crea una nuova scheda paziente',
    'modal' => [
        'heading' => 'Crea Nuovo Paziente',
        'description' => 'Inserisci i dati del nuovo paziente'
    ]
]
```

## Regole pratiche per le traduzioni

- Non usare mai chiavi che terminano con `.navigation`.
- Le label devono essere localizzate e descrittive.
- Aggiorna sempre i file lang quando aggiungi nuovi campi o azioni.
- Se una traduzione manca, aggiungila subito e documenta la struttura.

### Esempio di struttura corretta
```php
'navigation' => [
    'label' => 'Gestione Pazienti',
    'group' => 'Pazienti',
    'icon' => 'heroicon-o-user-group',
    'color' => 'primary',
],
'fields' => [
    'first_name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'helper_text' => 'Nome del paziente',
        'description' => 'Il nome anagrafico del paziente',
        'tooltip' => 'Deve corrispondere al nome sul documento d\'identità'
    ],
    // ...
],
```

- Se trovi chiavi `.navigation`, correggile subito e aggiorna la documentazione.

# ⚠️ ATTENZIONE: Mai usare ->label() nei componenti Filament

- Tutte le label, placeholder, help, tooltip, description devono essere gestite tramite i file di traduzione del modulo.
- La presenza di `->label()` è un errore da correggere ovunque.
- Consulta anche:
  - [Regole traduzioni Filament](../../Lang/docs/filament-translations.md)
  - [Regole generali Xot](../../Xot/docs/README.md)
