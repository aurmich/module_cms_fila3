# Wizard vs Tabs in Filament

## Differenze Chiave

### Wizard
- Utilizzato per processi sequenziali
- Ogni step deve essere completato in ordine
- Ideale per:
  - Registrazione utenti
  - Processi di onboarding
  - Flussi di lavoro complessi
  - Dati che dipendono l'uno dall'altro

### Tabs
- Utilizzato per organizzare informazioni correlate
- Accesso non sequenziale
- Ideale per:
  - Modifica profili
  - Visualizzazione dati correlati
  - Organizzazione logica di informazioni

## Errore Comune
❌ Utilizzare i Tabs quando è richiesto un Wizard
```php
// ERRATO: Usare Tabs per un processo sequenziale
Forms\Components\Tabs::make('Dottore')
    ->tabs([...]);
```

✅ Corretto: Utilizzare Wizard per processi sequenziali
```php
// CORRETTO: Usare Wizard per un processo sequenziale
Forms\Components\Wizard::make('Dottore')
    ->steps([...]);
```

## Best Practices

1. **Quando usare Wizard**
   - Processi di registrazione
   - Onboarding
   - Flussi di lavoro sequenziali
   - Dati che richiedono validazione step-by-step

2. **Quando usare Tabs**
   - Modifica profili
   - Visualizzazione dati correlati
   - Organizzazione logica di informazioni
   - Accesso non sequenziale ai dati

## Collegamenti
- [README](README.md)
- [Filament Resources](filament-resources.md)
- [Form Components](filament-form-components.md)

## Vedi Anche
- [Filament Wizard Documentation](https://filamentphp.com/docs/forms/layout#wizard)
- [Filament Tabs Documentation](https://filamentphp.com/docs/forms/layout#tabs) 