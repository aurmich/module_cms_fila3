# Convenzioni di Traduzione nel Modulo Notify

## Regole Specifiche per il Modulo Notify

Il modulo Notify utilizza convenzioni di traduzione specifiche che differiscono dalle convenzioni generali di SaluteOra.

### Naming dei File

- I nomi dei file devono essere in snake_case
- Gli acronimi (SMS, AWS, ecc.) devono essere trattati come una singola parola
- ✅ CORRETTO: `send_sms.php`, `send_aws_email.php`, `send_whats_app.php`
- ❌ ERRATO: `sendSms.php`, `SendWhatsApp.php`

### Struttura delle Chiavi

```php
return [
    'navigation' => [
        'label' => 'Nome della Funzionalità',
        'group' => 'Gruppo di Navigazione',
    ],
    'fields' => [
        'campo' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'azione' => [
            'label' => 'Etichetta Azione',
        ],
    ],
];
```

### Nota Importante

Questa struttura rappresenta un'eccezione documentata alle convenzioni generali di SaluteOra. Quando si lavora nel modulo Notify, seguire queste convenzioni specifiche anziché le convenzioni generali descritte in `Modules/Lang/docs/TRANSLATION_KEYS_RULES.md`.
