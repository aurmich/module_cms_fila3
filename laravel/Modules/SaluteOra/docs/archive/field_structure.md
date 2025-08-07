# Struttura dei Campi in SaluteOra

## Panoramica

Questo documento descrive la struttura standardizzata dei campi utilizzata in SaluteOra, con particolare attenzione alla gestione delle traduzioni e delle proprietà dei campi.

## Struttura Base dei Campi

Ogni campo in SaluteOra deve seguire una struttura standardizzata che include:

```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Testo Placeholder',
    'helper_text' => 'Testo di Aiuto',
    'description' => 'Descrizione Dettagliata',
    'tooltip' => 'Tooltip al Passaggio del Mouse'
]
```

## Tipi di Campi Comuni

### 1. Campi di Input Base
```php
'first_name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'helper_text' => 'Nome del paziente',
    'description' => 'Il nome anagrafico del paziente',
    'tooltip' => 'Deve corrispondere al nome sul documento d\'identità'
]
```

### 2. Campi di Selezione
```php
'gender' => [
    'label' => 'Genere',
    'placeholder' => 'Seleziona il genere',
    'helper_text' => 'Genere del paziente',
    'options' => [
        'M' => 'Maschio',
        'F' => 'Femmina',
        'O' => 'Altro',
    ]
]
```

### 3. Campi di Upload
```php
'health_card' => [
    'label' => 'Tessera Sanitaria',
    'placeholder' => 'Carica la tessera sanitaria',
    'helper_text' => 'Carica una scansione/foto della tessera sanitaria',
    'description' => 'Tessera sanitaria del paziente',
    'tooltip' => 'Assicurati che il documento sia leggibile'
]
```

### 4. Campi di Data
```php
'birth_date' => [
    'label' => 'Data di Nascita',
    'placeholder' => 'Seleziona la data di nascita',
    'helper_text' => 'Data di nascita del paziente',
    'description' => 'Data di nascita come indicata sul documento d\'identità'
]
```

## Proprietà Speciali

### 1. Campi con Valori Predefiniti
```php
'country' => [
    'label' => 'Paese',
    'placeholder' => 'Inserisci il paese',
    'helper_text' => 'Paese di residenza',
    'description' => 'Inserisci il paese di residenza',
    'default' => 'Italia'
]
```

### 2. Campi con Validazione
```php
'fiscal_code' => [
    'label' => 'Codice Fiscale',
    'placeholder' => 'Inserisci il codice fiscale',
    'helper_text' => 'Codice fiscale del paziente',
    'description' => 'Codice fiscale come indicato sulla tessera sanitaria',
    'validation' => [
        'required' => 'Il codice fiscale è obbligatorio',
        'format' => 'Il formato del codice fiscale non è valido'
    ]
]
```

## Best Practices

1. **Completezza**
   - Fornire sempre almeno una `label` e un `placeholder`
   - Aggiungere `helper_text` per suggerimenti brevi
   - Usare `description` per spiegazioni più dettagliate
   - Includere `tooltip` per informazioni contestuali

2. **Coerenza**
   - Mantenere uno stile di scrittura coerente
   - Usare lo stesso formato per campi simili
   - Seguire le convenzioni di naming stabilite

3. **Accessibilità**
   - Fornire descrizioni chiare e concise
   - Includere suggerimenti utili per l'utente
   - Mantenere un tono professionale

4. **Manutenzione**
   - Aggiornare le traduzioni quando si modificano i campi
   - Verificare la coerenza tra le diverse lingue
   - Documentare eventuali eccezioni o casi speciali

## Esempi di Implementazione Completa

### Campo Completo con Tutte le Proprietà
```php
'email' => [
    'label' => 'Email',
    'placeholder' => 'Inserisci l\'indirizzo email',
    'helper_text' => 'Indirizzo email valido',
    'description' => 'Email per le comunicazioni importanti',
    'tooltip' => 'Verrà utilizzata per le comunicazioni importanti',
    'validation' => [
        'required' => 'L\'email è obbligatoria',
        'email' => 'Inserisci un indirizzo email valido'
    ],
    'default' => null,
    'icon' => 'heroicon-o-envelope',
    'color' => 'primary'
]
```

### Campo con Opzioni Multiple
```php
'professional_status' => [
    'label' => 'Stato Professionale',
    'placeholder' => 'Seleziona lo stato professionale',
    'helper_text' => 'Stato professionale attuale',
    'description' => 'Seleziona il tuo stato professionale attuale',
    'options' => [
        'employed' => 'Dipendente',
        'self_employed' => 'Autonomo',
        'student' => 'Studente',
        'unemployed' => 'Disoccupato',
        'retired' => 'Pensionato'
    ],
    'tooltip' => 'Seleziona l\'opzione che meglio descrive la tua situazione'
]
``` 