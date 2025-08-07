# Filament Form Components

## Best Practices

### Label Management
- NON utilizzare mai il metodo `->label()` direttamente nei componenti
- Utilizzare i file di traduzione per gestire le etichette
- Seguire la struttura standard dei file di traduzione

### Struttura Corretta
```php
// ✅ CORRETTO
Forms\Components\TextInput::make('first_name')
    ->required()
    ->maxLength(255);

// ❌ ERRATO
Forms\Components\TextInput::make('first_name')
    ->label('Nome')
    ->required();
```

### File di Traduzione
```php
// lang/it/patient-resource.php
return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'tooltip' => 'Il tuo nome di battesimo'
        ]
    ]
];
```

## Collegamenti
- [LangServiceProvider Labels](langserviceprovider-labels.md)
- [Traduzioni](translations.md)
- [Best Practices](filament-wizard-best-practices.md)
- [FileUpload Components](../../UI/docs/filament-fileupload-components.md)
- [Naming Conventions](../../UI/docs/naming-conventions.md)
- [Wizard vs Tabs](wizard-vs-tabs.md)
- [Wizard Structure](filament-wizard-structure.md)

## Vedi Anche
- [Filament Forms Documentation](https://filamentphp.com/docs/forms)
- [Best Practices](../../Xot/docs/filament-best-practices.md) 