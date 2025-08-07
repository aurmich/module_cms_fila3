# API dei Componenti Filament

## Errori Comuni nell'Utilizzo dell'API

### Metodi Non Esistenti

Un errore comune nello sviluppo con Filament è l'utilizzo di metodi che non esistono in determinate classi di componenti. Questo può accadere quando si assume che tutti i componenti condividano gli stessi metodi.

#### Esempio: `description()` in `Tabs\Tab`

**Errore**: Il metodo `description()` non esiste nella classe `Filament\Forms\Components\Tabs\Tab`.

```php
// ERRATO
Forms\Components\Tabs\Tab::make('personal_info')
    ->label('Informazioni Personali')
    ->description('Inserisci i dati personali')  // Questo metodo non esiste!
    ->schema([...]);
```

**Corretto**:
```php
Forms\Components\Tabs\Tab::make('personal_info')
    ->label('Informazioni Personali')
    // Usare Section o altri componenti interni per aggiungere descrizioni
    ->schema([
        Forms\Components\Section::make()
            ->description('Inserisci i dati personali')
            ->schema([...]),
    ]);
```

### Differenze tra Componenti Simili

Anche componenti che sembrano simili possono avere API diverse. È importante verificare la documentazione o il codice sorgente prima di utilizzare un metodo.

| Componente | Supporta `description()` | Alternative |
|------------|--------------------------|-------------|
| `Section` | ✅ Sì | - |
| `Card` | ✅ Sì | - |
| `Tabs` | ✅ Sì | - |
| `Tabs\Tab` | ❌ No | Usare `Section` all'interno |
| `Wizard\Step` | ✅ Sì | - |

## Best Practices

1. **Verifica l'API**: Controlla sempre la documentazione o il codice sorgente prima di utilizzare un metodo
2. **Usa codice esistente come riferimento**: Esamina implementazioni simili nel progetto
3. **Test incrementali**: Testa piccole modifiche alla volta per identificare rapidamente gli errori
4. **Usa IDE con autocompletamento**: Gli IDE moderni possono suggerire i metodi disponibili

## Collegamenti Bidirezionali

- [Filament Documentation](../../Xot/docs/filament/README.md)
- [Troubleshooting](../../Xot/docs/troubleshooting.md)
- [PatientResource Reference](../app/Filament/Resources/PatientResource.php)
