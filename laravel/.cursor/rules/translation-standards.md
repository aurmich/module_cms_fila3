# Standard per le Traduzioni

## Convenzioni di Naming per i File di Traduzione

1. **Nomi in snake_case**: Tutti i file di traduzione devono utilizzare il formato `snake_case.php`
2. **Nomi Semantici**: I nomi devono riflettere il contesto o la risorsa a cui si riferiscono
3. **Evitare Acronimi nel Nome del File**: Scrivere per esteso (es. `send_aws_email.php` invece di `send_a_w_s_email.php`)

## Esempi Corretti vs Errati

| ✅ Corretto | ❌ Errato |
|------------|----------|
| `send_sms.php` | `send_s_m_s.php` |
| `send_aws_email.php` | `send_a_w_s_email.php` |
| `send_whatsapp.php` | `send_whats_app.php` |

## Struttura dei File di Traduzione

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
    ],
];
```

## Regole per le Chiavi di Traduzione

1. **Struttura Gerarchica**: Utilizzare una struttura nidificata per organizzare le traduzioni
2. **Chiavi in snake_case**: Tutte le chiavi devono essere in `snake_case`
3. **Evitare Stringhe Piatte**: Non utilizzare un array piatto di traduzioni

## Utilizzo delle Traduzioni

```php
// Corretto
{{ __('notify::send_sms.fields.to.label') }}

// Errato
{{ __('notify::send_sms.to') }}
```

## Errori Comuni da Evitare

1. **Nomi File Errati**: `send_s_m_s.php` invece di `send_sms.php`
2. **File Senza Nome**: `.php` (file senza nome)
3. **Traduzioni Incomplete**: File con solo alcune chiavi
4. **Inconsistenza tra Lingue**: File che esistono solo in alcune lingue
5. **Stringhe Hardcoded**: Testo hardcoded invece di utilizzare le traduzioni
