# Utilizzo di Enum e Config in SaluteOra

## Regola Fondamentale

**MAI hardcodare array di opzioni direttamente nei componenti Filament**

## Approcci Corretti

1. **Utilizzare Enum**:
   ```php
   use Modules\Notify\Enums\SmsDriverEnum;
   
   Forms\Components\Select::make('driver')
       ->options(SmsDriverEnum::options())
   ```

2. **Utilizzare Config**:
   ```php
   Forms\Components\Select::make('driver')
       ->options(config('sms.drivers'))
   ```

## Esempi Corretti vs Errati

### ❌ ERRATO: Hardcoding delle opzioni

```php
Forms\Components\Select::make('driver')
    ->options([
        'smsfactor' => 'SMSFactor',
        'twilio' => 'Twilio',
        'nexmo' => 'Nexmo',
        // ...
    ])
```

### ✅ CORRETTO: Utilizzo di Enum

```php
Forms\Components\Select::make('driver')
    ->options(SmsDriverEnum::options())
```

### ✅ CORRETTO: Utilizzo di Config

```php
Forms\Components\Select::make('driver')
    ->options(config('sms.drivers'))
```

## Motivazione

1. **Manutenibilità**: Un unico punto di modifica
2. **Riutilizzo**: Evita duplicazione del codice
3. **Coerenza**: Garantisce coerenza in tutta l'applicazione
4. **Flessibilità**: Facilita l'aggiunta o rimozione di opzioni
5. **Localizzazione**: Supporta la traduzione delle etichette

## Implementazione

1. **Creare Enum** per tipi di dati enumerabili del dominio
2. **Utilizzare Config** per valori configurabili dell'applicazione
3. **Centralizzare** la definizione di opzioni comuni
4. **Localizzare** le etichette nei file di traduzione
