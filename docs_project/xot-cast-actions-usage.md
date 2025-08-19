# Utilizzo delle Xot Cast Actions per Risolvere Errori PHPStan

## Regola Fondamentale

**SEMPRE** utilizzare le azioni di cast presenti in `/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/app/Actions/Cast/` per risolvere problemi di tipizzazione e cast invece di fare cast manuali o usare funzioni unsafe.

## Azioni Disponibili

### SafeStringCastAction
- **Percorso**: `Modules\Xot\Actions\Cast\SafeStringCastAction`
- **Uso**: Conversione sicura di valori mixed in string
- **Metodi**:
  - `execute(mixed $value): string`
  - `cast(mixed $value): string` (statico)

### SafeIntCastAction
- **Percorso**: `Modules\Xot\Actions\Cast\SafeIntCastAction`
- **Uso**: Conversione sicura di valori mixed in int
- **Metodi**:
  - `execute(mixed $value, ?int $default = 0): int`
  - `cast(mixed $value, ?int $default = 0): int` (statico)
  - `executeWithRange(mixed $value, int $min, int $max, ?int $default = null): int`
  - `castWithRange(mixed $value, int $min, int $max, ?int $default = null): int` (statico)
  - `executeAsId(mixed $value, ?int $default = 1): int`
  - `castAsId(mixed $value, ?int $default = 1): int` (statico)

### SafeFloatCastAction
- **Percorso**: `Modules\Xot\Actions\Cast\SafeFloatCastAction`
- **Uso**: Conversione sicura di valori mixed in float

## Esempi di Utilizzo

### Prima (Errore PHPStan)
```php
// ❌ ERRATO - Cast manuale non sicuro
$duration = $this->faker->randomElement([30, 45, 60, 90]);
$endTime->modify("+{$duration} minutes");

// ❌ ERRATO - Cast manuale
$startTime->setMinute((int) $this->faker->randomElement([0, 15, 30, 45]));
```

### Dopo (Con Xot Cast Actions)
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\Cast\SafeIntCastAction;

// ✅ CORRETTO - Uso di SafeStringCastAction
$duration = $this->faker->randomElement([30, 45, 60, 90]);
$endTime->modify('+' . SafeStringCastAction::cast($duration) . ' minutes');

// ✅ CORRETTO - Uso di SafeIntCastAction
$startTime->setMinute(SafeIntCastAction::cast($this->faker->randomElement([0, 15, 30, 45])));
```

## Vantaggi

1. **Type Safety**: Garantisce tipizzazione corretta per PHPStan
2. **DRY**: Evita duplicazione di logica di cast
3. **KISS**: Logica semplice e centralizzata
4. **Robustezza**: Gestisce tutti i casi edge
5. **Manutenibilità**: Un solo punto di verità per la logica di cast

## Aggiornamento Factory e Seeder

Quando si risolvono errori PHPStan in factory e seeder:

1. Identificare il tipo di cast necessario
2. Utilizzare l'azione appropriata dal modulo Xot
3. Importare la classe necessaria
4. Sostituire il cast manuale con la chiamata all'azione

## Esempi Specifici per Factory

### AppointmentFactory
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\Cast\SafeIntCastAction;

// Per concatenazione stringhe
'name' => $this->faker->randomElement($studioTypes) . ' ' . SafeStringCastAction::cast($this->faker->lastName()),

// Per cast di minuti
$startTime->setMinute(SafeIntCastAction::cast($this->faker->randomElement([0, 15, 30, 45])));
$endTime->addMinutes(SafeIntCastAction::cast($this->faker->randomElement([30, 45, 60])));
```

### StudioFactory
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// Per concatenazione sicura
'name' => $this->faker->randomElement($studioTypes) . ' ' . SafeStringCastAction::cast($this->faker->lastName()),
```

## Regole di Implementazione

1. **Import**: Sempre importare le azioni necessarie all'inizio del file
2. **Metodi statici**: Preferire i metodi statici `::cast()` per chiamate semplici
3. **Metodi con parametri**: Usare `::executeWithRange()` o `::executeAsId()` quando necessario
4. **Default values**: Specificare sempre valori di default appropriati
5. **Documentazione**: Aggiornare PHPDoc quando si modificano i cast

## Checklist per Correzione Errori PHPStan

- [ ] Identificare il tipo di errore di cast
- [ ] Scegliere l'azione Xot appropriata
- [ ] Importare la classe necessaria
- [ ] Sostituire il cast manuale
- [ ] Verificare che PHPStan passi
- [ ] Testare la funzionalità

## Note Importanti

- **Non usare mai** cast manuali come `(int)`, `(string)`, `(array)` quando sono disponibili le azioni Xot
- **Non usare mai** funzioni unsafe come `json_encode()` senza la versione Safe
- **Sempre** verificare che l'azione scelta gestisca correttamente i casi null e mixed
- **Sempre** aggiornare questa documentazione quando si aggiungono nuove azioni di cast

## Collegamenti

- [Xot Cast Actions Directory](../laravel/Modules/Xot/app/Actions/Cast/)
- [SafeStringCastAction](../laravel/Modules/Xot/app/Actions/Cast/SafeStringCastAction.php)
- [SafeIntCastAction](../laravel/Modules/Xot/app/Actions/Cast/SafeIntCastAction.php)
- [SafeFloatCastAction](../laravel/Modules/Xot/app/Actions/Cast/SafeFloatCastAction.php)

*Ultimo aggiornamento: Agosto 2025*
