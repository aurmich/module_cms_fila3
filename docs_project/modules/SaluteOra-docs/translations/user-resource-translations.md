# Traduzioni UserResource

## Struttura
Le traduzioni per UserResource devono seguire questa struttura:

```php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'tooltip' => 'Nome completo dell\'utente'
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'tooltip' => 'Indirizzo email dell\'utente'
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'tooltip' => 'Password dell\'utente'
        ],
        'state' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'tooltip' => 'Stato dell\'utente'
        ]
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Utente',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary'
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning'
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger'
        ]
    ]
];
```

## Note Importanti
- Non usare mai ->label() direttamente nel codice
- Tutte le etichette devono essere gestite tramite LangServiceProvider
- Ogni campo può avere label, placeholder e tooltip
- Le azioni possono avere anche icon e color
- Le traduzioni devono essere nel file di lingua del modulo

## Collegamenti
- [LangServiceProvider Documentation](../../lang-service-provider.md)
- [Translation Guidelines](../../translation-guidelines.md) 