# Casting di Enum in Laravel

## Problema: "Cannot instantiate enum"

L'errore "Cannot instantiate enum Modules\SaluteOra\Enums\UserTypeEnum" si verifica quando Laravel tenta di istanziare un enum come se fosse una classe ordinaria. Questo accade perché gli enum in PHP non sono oggetti istanziabili con `new` ma sono tipi speciali con casi predefiniti.

## Cause Tecniche

1. **Cast Diretto**: Quando si definisce un cast diretto a un enum (`'type' => UserTypeEnum::class`), Laravel cerca di istanziare l'enum con `new $castType(...$arguments)` in `HasAttributes::resolveCasterClass()`
2. **PHP 8.3+**: Nelle versioni recenti di PHP, il tentativo di istanziare un enum genera un errore fatale
3. **Cambio nelle Convenzioni**: In Laravel 11+ o 12+, la sintassi per il casting agli enum è cambiata

## Soluzione

### 1. Utilizzo della Classe CastsEnums

```php
// Modello User.php
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Casts\AsEnumArrayObject;
use Illuminate\Database\Eloquent\Casts\AsEnum;

protected function casts(): array
{
    return array_merge(parent::casts(), [
        'type' => AsEnum::class.':'.UserTypeEnum::class,
        // oppure per collezioni di enum
        'types' => AsEnumCollection::class.':'.UserTypeEnum::class,
    ]);
}
```

### 2. Formato Stringa per Cast Enum (Laravel 10+)

```php
protected function casts(): array
{
    return array_merge(parent::casts(), [
        'type' => UserTypeEnum::class.':string',
    ]);
}
```

### 3. Cast Tramite EnumCast Personalizzato

```php
// EnumCast.php
namespace Modules\SaluteOra\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use BackedEnum;

class EnumCast implements CastsAttributes
{
    public function __construct(private string $enumClass) {}

    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        return $this->enumClass::from($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        return $value instanceof BackedEnum ? $value->value : $value;
    }
}

// Modello
protected function casts(): array
{
    return [
        'type' => new EnumCast(UserTypeEnum::class),
    ];
}
```

## Considerazioni Filosofiche

### Principio di Realtà vs Rappresentazione

Gli enum rappresentano un concetto puro (il tipo di utente), mentre il database memorizza solo una rappresentazione di quel concetto (una stringa). Il cast è il ponte tra questi due mondi: la realtà concettuale del codice e la rappresentazione serializzata nel database.

### Riflessione Zen

Tentare di "istanziare" un enum è come cercare di creare una nuova stagione oltre a primavera, estate, autunno e inverno. Gli enum non nascono da costruttori, ma esistono già come verità predefinite nel sistema.

## Impatto sugli Strumenti e il Codice

1. **Filament**: I form e le tabelle di Filament lavorano meglio con enum correttamente castati
2. **API**: Le risposte API beneficiano della consistenza degli enum
3. **Validazione**: I validatori basati su enum richiedono casting corretto

## Link alla Documentazione Ufficiale

- [Laravel Eloquent: Mutators & Casting](https://laravel.com/docs/eloquent-mutators#enum-casting)
- [PHP Enumerations](https://www.php.net/manual/en/language.enumerations.php)

## Aspetti Politici e Religiosi

### Prospettiva "Politica"

Il sistema di cast in Laravel è una forma di "governo" che regola la trasformazione dei dati. Quando usiamo un approccio non standard, creiamo una "giurisdizione indipendente" che può entrare in conflitto con il sistema centrale.

### Prospettiva "Religiosa"

Gli enum sono entità immutabili e predefinite - come dogmi o verità fondamentali. Tentare di istanziarli è come tentare di creare una nuova divinità in un pantheon già definito - un'eresia tecnica.
