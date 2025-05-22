# Regole per l'Utilizzo degli Enum in SaluteOra

## Indice
1. [Introduzione](#introduzione)
2. [Convenzioni di Naming](#convenzioni-di-naming)
3. [Struttura degli Enum](#struttura-degli-enum)
4. [Utilizzo nei Modelli](#utilizzo-nei-modelli)
5. [Utilizzo in Filament](#utilizzo-in-filament)
6. [Validazione](#validazione)
7. [Testing](#testing)
8. [Best Practice](#best-practice)

## Introduzione

Questo documento definisce le linee guida per l'utilizzo degli enum nel progetto SaluteOra. Gli enum sono preferiti rispetto alle costanti di classe o agli array associativi per gestire valori fissi.

## Convenzioni di Naming

### Nomi delle Classi Enum
- Usa il suffisso `Type` per gli enum che rappresentano tipi (es: `UserType`)
- Usa il suffisso `Status` per gli enum che rappresentano stati (es: `AppointmentStatus`)
- Usa nomi al singolare
- Usa PascalCase per i nomi delle classi

### Nomi dei Casi
- Usa MAIUSCOLO_SNAKE_CASE per i nomi dei casi
- Sii coerente con i prefissi (es: `STATUS_*` per stati)
- Mantieni i nomi dei casi descrittivi ma concisi

## Struttura degli Enum

### Struttura Base

```php
<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserType: string implements HasLabel
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';
    
    // Metodi richiesti dall'interfaccia HasLabel
    public function getLabel(): ?string
    {
        return match($this) {
            self::ADMIN => 'Amministratore',
            self::DOCTOR => 'Dottore',
            self::PATIENT => 'Paziente',
        };
    }
    
    // Metodi aggiuntivi utili
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
    
    // Metodi statici di utilità
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    
    public static function options(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->getLabel(), self::cases())
        );
    }
}
```

## Utilizzo nei Modelli

### Definizione del Cast

```php
use App\Enums\UserType;

class User extends Authenticatable
{
    protected $casts = [
        'type' => UserType::class,
    ];
    
    // ...
}
```

### Metodi di Utilità

Aggiungi metodi di utilità per migliorare la leggibilità:

```php
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
```

### Scope per Query

```php
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
```

## Utilizzo in Filament

### Campi di Selezione

```php
use App\Enums\UserType;
use Filament\Forms\Components\Select;

Select::make('type')
    ->label('Tipo Utente')
    ->options(UserType::class) // Sfrutta l'interfaccia HasLabel
    ->enum(UserType::class)
    ->required()
    ->searchable();
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
    ->sortable();
```

### Filtri

```php
use App\Enums\UserType;
use Filament\Tables\Filters\SelectFilter;

SelectFilter::make('type')
    ->label('Tipo Utente')
    ->options(UserType::class)
    ->multiple();
```

## Validazione

### Regola di Validazione Personalizzata

```php
use App\Enums\UserType;
use Illuminate\Validation\Rules\Enum;

$request->validate([
    'type' => ['required', new Enum(UserType::class)],
]);
```

### Regola Personalizzata per Array di Enum

```php
use App\Enums\UserType;
use Illuminate\Validation\Rules\In;

$request->validate([
    'types' => [
        'required',
        'array',
    ],
    'types.*' => [
        'required',
        'string',
        new In(UserType::values()),
    ],
]);
```

## Testing

### Test per gli Enum

```php
use App\Enums\UserType;
use Tests\TestCase;

class UserTypeTest extends TestCase
{
    public function test_enum_has_correct_values()
    {
        $this->assertEquals('admin', UserType::ADMIN->value);
        $this->assertEquals('doctor', UserType::DOCTOR->value);
        $this->assertEquals('patient', UserType::PATIENT->value);
    }
    
    public function test_enum_has_correct_labels()
    {
        $this->assertEquals('Amministratore', UserType::ADMIN->getLabel());
        $this->assertEquals('Dottore', UserType::DOCTOR->getLabel());
        $this->assertEquals('Paziente', UserType::PATIENT->getLabel());
    }
}
```

### Test per i Modelli con Enum

```php
use App\Enums\UserType;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_type_casting()
    {
        $user = User::factory()->create(['type' => UserType::ADMIN]);
        
        $this->assertInstanceOf(UserType::class, $user->type);
        $this->assertEquals(UserType::ADMIN, $user->type);
        $this->assertEquals('admin', $user->getRawOriginal('type'));
    }
    
    public function test_is_admin_helper()
    {
        $admin = User::factory()->create(['type' => UserType::ADMIN]);
        $doctor = User::factory()->create(['type' => UserType::DOCTOR]);
        
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($doctor->isAdmin());
    }
}
```

## Best Practice

1. **Usa sempre enum tipizzati** invece di stringhe o costanti
2. **Implementa l'interfaccia `HasLabel`** per l'integrazione con Filament
3. **Aggiungi metodi di utilità** per colori, icone, ecc.
4. **Documenta** ogni caso enum con commenti esplicativi
5. **Crea test** per verificare il comportamento degli enum
6. **Usa i cast** nei modelli per la conversione automatica
7. **Evita di usare valori magici** nelle query, usa invece le costanti degli enum
8. **Centralizza la logica** correlata agli enum nei metodi dell'enum
9. **Usa metodi statici** per operazioni di utilità comuni
10. **Mantieni gli enum immutabili** - non aggiungere stati dopo il rilascio

# Regola Directory Obbligatoria (Cursor)

Tutte le classi PHP (Models, Enums, Actions, Providers, View/Components, ecc.) DEVONO essere in `app/`.

- ❌ Sbagliato: `Modules/SaluteOra/Enums/UserType.php`
- ✅ Corretto: `Modules/SaluteOra/app/Enums/UserType.php`

Cursor deve segnalare e bloccare errori di struttura.

Consulta sempre:
- [MIGLIORAMENTI_E_CORREZIONI.md](./MIGLIORAMENTI_E_CORREZIONI.md)
- [WINDSURF_RULES.md](./WINDSURF_RULES.md)
