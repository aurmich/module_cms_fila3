# Regole per il Pattern TransTrait in Laraxot

## Descrizione
Il `TransTrait` è un trait fornito dal modulo Xot che automatizza la gestione delle traduzioni per gli enum, generando automaticamente le chiavi di traduzione basandosi sul nome della classe.

## Regole Fondamentali

### 1. Utilizzo Obbligatorio per Enum Filament
- **SEMPRE** utilizzare `TransTrait` per enum che implementano `HasLabel`, `HasIcon`, `HasColor`
- **MAI** utilizzare traduzioni hardcoded o match expressions per questi metodi
- **SEMPRE** importare: `use Modules\Xot\Filament\Traits\TransTrait;`

### 2. Implementazione Standard
```php
enum PatientAgeRangeEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    
    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value.'.label');
    }
    
    public function getColor(): string
    {
        return $this->transClass(self::class, $this->value.'.color');
    }
    
    public function getIcon(): string
    {
        return $this->transClass(self::class, $this->value.'.icon');
    }
    
    public function getDescription(): string
    {
        return $this->transClass(self::class, $this->value.'.description');
    }
}
```

### 3. Struttura File di Traduzione
- **SEMPRE** creare file di traduzione in tutte e tre le lingue (it, en, de)
- **SEMPRE** utilizzare struttura associativa con chiavi `label`, `color`, `icon`, `description`
- **SEMPRE** includere `declare(strict_types=1);` nei file di traduzione

### 4. Pattern Chiavi di Traduzione
Il TransTrait genera automaticamente:
```
{namespace}::{class_name}::{value}.{property}
```

Esempio: `saluteora::patient_age_range_enum.under_20.label`

## Vantaggi del Pattern

1. **Generazione automatica**: Le chiavi vengono generate dal nome della classe
2. **Coerenza**: Pattern uniforme per tutti gli enum del modulo
3. **Manutenibilità**: Meno errori di digitazione nelle chiavi
4. **Refactoring sicuro**: Cambi di nome classe aggiornano automaticamente le traduzioni

## Best Practices

1. **Sempre usare TransTrait** per enum che implementano interfacce Filament
2. **Mantenere coerenza** nella struttura delle traduzioni
3. **Documentare** ogni nuovo enum che usa TransTrait
4. **Aggiornare** tutti i file di lingua quando si aggiungono nuovi valori
5. **Testare** le traduzioni in tutte le lingue supportate

## Esempi di Utilizzo

### In Filament Forms
```php
Forms\Components\Select::make('age_range')
    ->label(__('saluteora::patient.age_range.label'))
    ->placeholder(__('saluteora::patient.age_range.placeholder'))
    ->helperText(__('saluteora::patient.age_range.helper_text'))
    ->options(PatientAgeRangeEnum::class)
    ->required(),
```

### In Filament Tables
```php
Tables\Columns\TextColumn::make('age_range')
    ->label(__('saluteora::patient.age_range.label'))
    ->formatStateUsing(fn (PatientAgeRangeEnum $state): string => $state->getLabel())
    ->color(fn (PatientAgeRangeEnum $state): string => $state->getColor()),
```

## Risoluzione Problemi

### Errore: "Target class [translator] does not exist"
- **Causa**: Test unitari senza contesto Laravel completo
- **Soluzione**: Convertire in Feature tests o usare `RefreshDatabase` trait

### Traduzioni non caricate
- **Causa**: File di traduzione con struttura errata
- **Soluzione**: Verificare che la struttura corrisponda al pattern `{value}.{property}`

### Chiavi non trovate
- **Causa**: Nome classe o namespace errato
- **Soluzione**: Verificare che `self::class` restituisca il nome corretto

## Collegamenti

- [Documentazione TransTrait](../../laravel/Modules/SaluteOra/docs/trans-trait-pattern.md)
- [PatientAgeRangeEnum](../../laravel/Modules/SaluteOra/docs/enums/patient-age-range-enum.md)
- [Filament Enums Integration](../../laravel/Modules/SaluteOra/docs/filament-enums-integration.mdc)

*Ultimo aggiornamento: Gennaio 2025*
