# Standard per le Traduzioni nel Progetto SaluteOra

## Struttura delle Cartelle

Le traduzioni vanno posizionate nella cartella `lang` di ogni modulo, organizzate per lingua:

```
Modules/
  ├── ModuleName/
  │   └── lang/
  │       ├── it/
  │       │   ├── resource-name.php
  │       │   └── ...
  │       └── en/
  │           ├── resource-name.php
  │           └── ...
```

## Convenzione di Naming

1. **Chiavi di Traduzione**:
   - Usare la notazione `snake_case`
   - Seguire la struttura gerarchica: `tipo.entità.elemento`
   - Esempio: `fields.patient.birth_date.label`

2. **Struttura Standard per le Risorse**:
   ```php
   return [
       'navigation' => [
           'label' => 'Etichetta Menu',
           'group' => 'Gruppo Menu',
           'icon' => 'heroicon-o-icon-name',
       ],
       'fields' => [
           'field_name' => [
               'label' => 'Etichetta Campo',
               'placeholder' => 'Testo segnaposto',
               'helper_text' => 'Testo di aiuto',
               'tooltip' => 'Tooltip',
           ],
       ],
       'actions' => [
           'save' => 'Salva',
           'cancel' => 'Annulla',
       ],
       'messages' => [
           'created' => 'Record creato con successo',
           'updated' => 'Record aggiornato',
           'deleted' => 'Record eliminato',
       ]
   ];
   ```

## Linee Guida per le Traduzioni

1. **Mai usare chiavi di traduzione in italiano** direttamente nel codice
2. **Non usare mai `.navigation`** come valore di traduzione
3. **Usare sempre la struttura espansa** per i campi
4. **Mantenere l'ordine alfabetico** delle chiavi
5. **Tutti i testi visibili all'utente** devono essere tradotti
6. **Usare le icone Heroicons** per le voci di menu

## Esempi

### ❌ Errato:
```php
'label' => 'user.navigation',
'group' => 'user.navigation',
'icon' => 'user.navigation',
```

### ✅ Corretto:
```php
'navigation' => [
    'label' => 'Utenti',
    'group' => 'Amministrazione',
    'icon' => 'heroicon-o-users',
],
```

## Struttura Consigliata per le Risorse Filament

```php
return [
    'navigation' => [
        'label' => 'Pazienti',
        'group' => 'Gestione',
        'icon' => 'heroicon-o-user-group',
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'helper_text' => 'Inserisci il nome del paziente',
        ],
        // Altri campi...
    ],
    'actions' => [
        'create' => 'Nuovo Paziente',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
    ]
];
```

## Best Practices

1. **Mantenere la coerenza** tra le diverse lingue
2. **Validare** che tutte le chiavi siano presenti in tutte le lingue
3. **Documentare** le nuove chiavi aggiunte
4. **Non duplicare** le traduzioni tra moduli diversi
5. **Usare i gruppi** per organizzare le voci di menu correlate

## Strumenti Utili

1. **php artisan translation:sync** - Sincronizza le chiavi tra le lingue
2. **php artisan translation:missing** - Trova le chiavi mancanti
3. **php artisan translation:export** - Esporta le traduzioni per la localizzazione

## Note Importanti

- Le traduzioni sono gestite automaticamente dal `LangServiceProvider`
- Non è necessario usare `->label()` nei componenti Filament
- Le etichette vengono risolte automaticamente in base al nome del campo
