# PHPStan - Analisi Statica del Codice - Guida Completa

## 🚨 REGOLE CRITICHE PHPSTAN

### Esecuzione Corretta
```bash
# SEMPRE eseguire da directory Laravel
cd /var/www/html/_bases/base_saluteora/laravel

# Livello 9+ per nuovo codice
./vendor/bin/phpstan analyze --level=9 --memory-limit=2G

# Per modulo specifico
./vendor/bin/phpstan analyze Modules/SaluteOra --level=9
```

### ❌ MAI usare artisan per phpstan
```bash
# ERRATO - MAI fare questo
php artisan test:phpstan
```

## Principi Fondamentali

### Tipizzazione Rigorosa
- **SEMPRE** utilizzare `declare(strict_types=1);`
- **SEMPRE** specificare tipi di ritorno espliciti
- **SEMPRE** specificare tipi di parametri
- **EVITARE** `mixed` quando possibile, preferire union types

### PHPDoc Completo
```php
/**
 * @property int $id
 * @property string|null $nome
 * @property Carbon|null $created_at
 * @property-read Collection<int, RelatedModel> $relatedModels
 */
class MioModello extends BaseModel
{
    /** @var list<string> */
    protected $fillable = ['nome', 'email'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
```

### Generics per Collection
```php
/**
 * @return Collection<int, User>
 */
public function getActiveUsers(): Collection
{
    return User::where('active', true)->get();
}

/**
 * @param array<int, string> $names
 * @return array<int, User>
 */
public function findUsersByNames(array $names): array
{
    // Implementazione
}
```

## Errori Comuni e Soluzioni

### 1. Undefined Property
**Errore**: Access to an undefined property
**Soluzione**: Aggiungere annotazione `@property`
```php
/**
 * @property int $anno
 * @property Carbon|null $dal
 * @property Carbon|null $al
 */
```

### 2. Missing Return Type
**Errore**: Method X does not have a return type specified
**Soluzione**: Aggiungere tipo di ritorno esplicito
```php
public function getFullNameAttribute(): string
{
    return $this->nome . ' ' . $this->cognome;
}
```

### 3. Method Not Found
**Errore**: Call to an undefined method X
**Soluzione**: Verificare namespace e importazioni
```php
use Modules\User\Models\User; // Namespace corretto
```

### 4. Array Shape
**Errore**: Parameter #1 $data of method X expects array{id: int, name: string}, array given
**Soluzione**: Utilizzare docblock completo
```php
/**
 * @param array{id: int, name: string} $data
 */
public function process(array $data): void
{
    // Implementazione
}
```

### 5. Parametri Nullable
**Errore**: Parameter #1 $value of method X expects string, string|null given
**Soluzione**: Gestire caso null
```php
public function process(?string $value): string
{
    return $value ?? '';
}
```

## Verifica Conformità

### Comandi di Verifica
```bash
# Verifica livello 9
./vendor/bin/phpstan analyze --level=9

# Verifica modulo specifico
./vendor/bin/phpstan analyze Modules/SaluteOra --level=9

# Verifica con baseline
./vendor/bin/phpstan analyze --baseline=phpstan-baseline.neon
```

### Risultato Atteso
- **0 errori** per nuovo codice
- **Livello 9+** per tutti i file
- **Tipizzazione completa** per tutti i metodi

## Best Practices

### 1. Namespace Corretti
```php
// ✅ CORRETTO
namespace Modules\SaluteOra\Models;

// ❌ ERRATO
namespace Modules\SaluteOra\App\Models;
```

### 2. Ereditarietà Modelli
```php
// ✅ CORRETTO - Estende BaseModel del modulo
class Doctor extends BaseModel

// ❌ ERRATO - Estende direttamente Model
class Doctor extends \Illuminate\Database\Eloquent\Model
```

### 3. Service Provider
```php
// ✅ CORRETTO - Estende XotBaseServiceProvider
class SaluteOraServiceProvider extends XotBaseServiceProvider

// ❌ ERRATO - Estende ServiceProvider diretto
class SaluteOraServiceProvider extends \Illuminate\Support\ServiceProvider
```

### 4. Migrazioni
```php
// ✅ CORRETTO - Classe anonima che estende XotBaseMigration
return new class extends XotBaseMigration {
    public function up(): void
    {
        // Implementazione
    }
    // NIENTE metodo down()
};

// ❌ ERRATO - Estende Migration diretto
class CreateTableMigration extends \Illuminate\Database\Migrations\Migration
```

## Configurazione PHPStan

### phpstan.neon
```yaml
parameters:
    level: 9
    paths:
        - Modules/
    excludePaths:
        - Modules/*/database/migrations/
    checkMissingIterableValueType: true
    checkGenericClassInNonGenericObjectType: true
```

### Baseline
```bash
# Generare baseline
./vendor/bin/phpstan analyze --generate-baseline

# Utilizzare baseline
./vendor/bin/phpstan analyze --baseline=phpstan-baseline.neon
```

## Ignori Condizionali

```php
/** @phpstan-ignore-next-line */
$variabile = $oggetto->proprietaNonStandard;
```

## Progressione Livelli

1. **Livello 1-3**: Controlli base di sintassi e funzioni
2. **Livello 4-6**: Controlli di tipo più rigorosi
3. **Livello 7-8**: Controlli dettagliati su tipi e DocBlocks
4. **Livello 9-10**: Controlli avanzati e massima rigidità

## Note Importanti

- Eseguire PHPStan frequentemente durante lo sviluppo
- Documentare pattern comuni di errori/soluzioni
- Non ignorare errori senza documentare il motivo
- Mantenere la consistenza nei docblock e nei tipi
- Utilizzare le funzioni sicure di `thecodingmachine/safe`
- Aggiornare il baseline solo quando necessario
- Includere PHPStan nei controlli pre-commit

## Collegamenti
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Modules/Xot/docs/PHPSTAN_LIVELLO10_LINEE_GUIDA.md](../laravel/Modules/Xot/docs/PHPSTAN_LIVELLO10_LINEE_GUIDA.md)
- [docs/PHPSTAN_LEVEL10_FIXES.md](../docs/PHPSTAN_LEVEL10_FIXES.md)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 2.0 - Consolidata
**Livello Minimo**: 9 per nuovo codice
**Regole Critiche**: Esecuzione da /laravel, mai artisan, tipizzazione rigorosa
