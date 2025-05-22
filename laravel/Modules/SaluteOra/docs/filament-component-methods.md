# Metodi dei Componenti Filament

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo Patient. La documentazione principale e completa sulla compatibilità dei metodi dei componenti Filament si trova nel [modulo UI](../../UI/docs/filament/component-methods-compatibility.md).

## Compatibilità dei Metodi tra Componenti

Un errore comune nello sviluppo con Filament è assumere che tutti i componenti supportino gli stessi metodi. Questo documento elenca i metodi disponibili per i componenti più utilizzati e le loro compatibilità nel contesto del modulo Patient.

## Metodo `prefixIcon()`

Il metodo `prefixIcon()` è utilizzato per aggiungere un'icona prima del contenuto di un componente, ma **non è supportato da tutti i componenti**.

### Componenti che supportano `prefixIcon()`

| Componente | Supporta `prefixIcon()` | Note |
|------------|--------------------------|------|
| `TextInput` | ✅ Sì | Supportato completamente |
| `Select` | ✅ Sì | Supportato completamente |
| `Checkbox` | ❌ No | - |
| `FileUpload` | ❌ No | Usa `icon()` invece |
| `DatePicker` | ✅ Sì | Supportato completamente |
| `TimePicker` | ✅ Sì | Supportato completamente |
| `Toggle` | ❌ No | - |

### Esempio di Errore Comune

```php
// ERRATO
Forms\Components\FileUpload::make('certification')
    ->label('Certificazione')
    ->prefixIcon('heroicon-o-document-text') // Questo metodo non esiste!
```

### Uso Corretto

```php
// CORRETTO
Forms\Components\FileUpload::make('certification')
    ->label('Certificazione')
    // FileUpload non supporta prefixIcon, ma supporta icon
    ->icon('heroicon-o-document-text')
```

## Metodo `extraAttributes()`

Il metodo `extraAttributes()` è utilizzato per aggiungere attributi HTML personalizzati ai componenti, ma anche questo **non è supportato da tutti i componenti**.

### Componenti che supportano `extraAttributes()`

| Componente | Supporta `extraAttributes()` | Note |
|------------|------------------------------|------|
| `TextInput` | ✅ Sì | Supportato completamente |
| `Select` | ✅ Sì | Supportato completamente |
| `Checkbox` | ✅ Sì | Supportato completamente |
| `FileUpload` | ❌ No | - |
| `DatePicker` | ✅ Sì | Supportato completamente |
| `TimePicker` | ✅ Sì | Supportato completamente |
| `Toggle` | ✅ Sì | Supportato completamente |

## Best Practices

1. **Consultare la documentazione ufficiale**: Verificare sempre la documentazione di Filament per i metodi supportati
2. **Ispezionare il codice sorgente**: In caso di dubbi, esaminare il codice sorgente della classe del componente
3. **Utilizzare l'IDE**: Sfruttare l'autocompletamento dell'IDE per vedere i metodi disponibili
4. **Test incrementali**: Testare piccole modifiche alla volta per identificare rapidamente gli errori

## Collegamenti Bidirezionali

- [Documentazione principale sulla compatibilità dei metodi dei componenti Filament](../../UI/docs/filament/component-methods-compatibility.md)
- [API dei Componenti Filament](./filament-components-api.md)
- [Implementazione Wizard in Filament](./filament-wizard-implementation.md)
- [Documentazione Filament](../../Xot/docs/filament/README.md)
