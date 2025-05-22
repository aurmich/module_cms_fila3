# Implementazione degli Enum in SaluteOra

## Introduzione

Questo documento descrive l'implementazione degli enum in Laravel e Filament per la gestione dei tipi di utente e di altri valori enumerativi all'interno dell'applicazione SaluteOra.

## Indice
1. [Perché usare gli Enum](#perchè-usare-gli-enum)
2. [Implementazione Base](#implementazione-base)
3. [Enum per i Tipi Utente](#enum-per-i-tipi-utente)
4. [Utilizzo nei Modelli](#utilizzo-nei-modelli)
5. [Utilizzo in Filament](#utilizzo-in-filament)
6. [Best Practice](#best-practice)
7. [Esempi Avanzati](#esempi-avanzati)

## Perché usare gli Enum

Gli enum offrono numerosi vantaggi rispetto alle costanti di classe o agli array associativi:

- **Type Safety**: Il tipo viene verificato in fase di compilazione
- **Autocompletamento**: Migliora l'esperienza di sviluppo con l'autocompletamento dell'IDE
- **Documentazione incorporata**: I valori possibili sono espliciti nel codice
- **Mantenibilità**: Modifiche centralizzate ai valori possibili
- **Performance**: Gli enum PHP sono più performanti degli array associativi

## Implementazione Base

### Installazione

Assicurati di utilizzare PHP 8.1+ e Laravel 9+. Non sono necessari pacchetti aggiuntivi.

### Creazione di un Enum Base

```php
<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
    
    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Amministratore',
            self::DOCTOR => 'Dottore',
            self::PATIENT => 'Paziente',
        };
    }
    
    public static function options(): array
    {
        return [
            self::ADMIN->value => self::ADMIN->label(),
            self::DOCTOR->value => self::DOCTOR->label(),
            self::PATIENT->value => self::PATIENT->label(),
        ];
    }
}
```

## Enum per i Tipi Utente

### UserType Enum

```php
<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserType: string implements HasLabel
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
    
    public function getLabel(): ?string
    {
        return match($this) {
            self::ADMIN => 'Amministratore',
            self::DOCTOR => 'Dottore',
            self::PATIENT => 'Paziente',
        };
    }
    
    public function getColor(): string
    {
        return match($this) {
            self::ADMIN => 'danger',
            self::DOCTOR => 'primary',
            self::PATIENT => 'success',
        };
    }
    
    public function getIcon(): string
    {
        return match($this) {
            self::ADMIN => 'heroicon-s-shield-check',
            self::DOCTOR => 'heroicon-s-user-plus',
            self::PATIENT => 'heroicon-s-user',
        };
    }
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    
    public static function labels(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->getLabel(), self::cases())
        );
    }
}
```

## Utilizzo nei Modelli

### Modello Utente con Enum

```php
<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Model;
use Parental\HasChildren;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasChildren;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'type', // user_type sarebbe meglio per convenzione
        'clinic_id',
    ];
    
    protected $casts = [
        'type' => UserType::class,
        'email_verified_at' => 'datetime',
    ];
    
    protected $childTypes = [
        UserType::ADMIN->value => Admin::class,
        UserType::DOCTOR->value => Doctor::class,
        UserType::PATIENT->value => Patient::class,
    ];
    
    // Metodi di utilità
    public function isAdmin(): bool
    {
        return $this->type === UserType::ADMIN;
    }
    
    public function isDoctor(): bool
    {
        return $this->type === UserType::DOCTOR;
    }
    
    public function isPatient(): bool
    {
        return $this->type === UserType::PATIENT;
    }
    
    // Scope per query
    public function scopeAdmins($query)
    {
        return $query->where('type', UserType::ADMIN->value);
    }
    
    public function scopeDoctors($query)
    {
        return $query->where('type', UserType::DOCTOR->value);
    }
    
    public function scopePatients($query)
    {
        return $query->where('type', UserType::PATIENT->value);
    }
}
```

## Utilizzo in Filament

### Selezione in un Form

```php
use App\Enums\UserType;
use Filament\Forms\Components\Select;

Select::make('type')
    ->label('Tipo Utente')
    ->options(UserType::class) // Sfrutta l'interfaccia HasLabel
    ->enum(UserType::class)
    ->required()
    ->searchable()
    ->reactive()
    ->afterStateUpdated(function ($state, callable $set) {
        // Logica aggiuntiva quando cambia il tipo
    });
```

### Filtri in una Tabella

```php
use App\Enums\UserType;
use Filament\Tables\Filters\SelectFilter;

SelectFilter::make('type')
    ->label('Filtra per Tipo')
    ->options(UserType::class) // Sfrutta l'interfaccia HasLabel
    ->multiple()
    ->query(function (Builder $query, array $state) {
        if (! empty($state['values'])) {
            $query->whereIn('type', $state['values']);
        }
    });
```

### Colonne nella Tabella

```php
use App\Enums\UserType;
use Filament\Tables\Columns\TextColumn;

TextColumn::make('type')
    ->label('Tipo')
    ->badge()
    ->color(fn (string $state): string => UserType::from($state)->getColor())
    ->formatStateUsing(fn (string $state): string => UserType::from($state)->getLabel())
    ->sortable()
    ->searchable();
```

## Best Practice

1. **Naming**: Usa nomi descrittivi per gli enum e i loro casi
2. **Documentazione**: Documenta ogni caso enum con commenti esplicativi
3. **Interfacce**: Implementa `HasLabel` per l'integrazione con Filament
4. **Metodi di utilità**: Aggiungi metodi per colori, icone, ecc.
5. **Localizzazione**: Usa i file di traduzione per le etichette
6. **Validazione**: Crea regole di validazione personalizzate per gli enum
7. **Testing**: Scrivi test per verificare il comportamento degli enum

## Esempi Avanzati

### Validazione Personalizzata

```php
use Illuminate\Validation\Rules\Enum;

$request->validate([
    'type' => ['required', new Enum(UserType::class)],
]);
```

### Cast Personalizzato

```php
use App\Enums\UserType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class UserTypeCast implements CastsAttributes
{
    public function get(Model $model, string $key, $value, array $attributes)
    {
        return UserType::from($value);
    }

    public function set(Model $model, string $key, $value, array $attributes)
    {
        if ($value instanceof UserType) {
            return $value->value;
        }
        
        return $value;
    }
}
```

### Utilizzo nei Modelli

```php
protected $casts = [
    'type' => UserTypeCast::class,
];
```

### Localizzazione

Crea un file di traduzione in `lang/en/enums.php`:

```php
return [
    'user_type' => [
        UserType::ADMIN->value => 'Administrator',
        UserType::DOCTOR->value => 'Doctor',
        UserType::PATIENT->value => 'Patient',
    ],
];
```

E nel metodo `label()` dell'enum:

```php
public function getLabel(): string
{
    return __("enums.user_type.{$this->value}");
}
```

## Conclusione

L'utilizzo degli enum in Laravel e Filament offre un modo robusto e manutenibile per gestire tipi fissi di dati. Seguendo queste linee guida, puoi sfruttare al massimo le funzionalità di PHP 8.1+ e migliorare la qualità del tuo codice.
