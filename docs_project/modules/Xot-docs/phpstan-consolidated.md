# PHPStan - Documentazione Consolidata DRY + KISS

> **🎯 Single Source of Truth**: Questo documento centralizza TUTTA la documentazione PHPStan del progetto
> 
> **🔗 Riferimenti**: [coding-standards.md](coding-standards.md) | [best-practices.md](best-practices.md)

## 🚨 STOP DUPLICAZIONE!

**Prima di creare nuovi file PHPStan, LEGGI QUESTO DOCUMENTO!**

Questo documento sostituisce e consolida **121+ file PHPStan duplicati** trovati in tutti i moduli. 

### ❌ File da NON Creare Più
- `phpstan-fixes.md` in qualsiasi modulo
- `phpstan_usage.md` duplicati
- `phpstan-level10-fixes.md` sparsi
- Qualsiasi documentazione PHPStan specifica di modulo

### ✅ Unica Fonte di Verità
- **Questo file**: `/laravel/Modules/Xot/docs/phpstan-consolidated.md`
- **Configurazioni**: File `.neon` nei singoli moduli (solo config, non docs)

## Principi Fondamentali

### Livelli Obbligatori
- **Livello 9+**: Obbligatorio per tutto il codice nuovo
- **Livello 10**: Target per moduli critici (Xot, SaluteOra, User)
- **Zero errori**: Policy per commit in main

### Esecuzione Standard
```bash
# Dalla directory Laravel
cd /var/www/html/_bases/base_saluteora/laravel

# Analisi completa
./vendor/bin/phpstan analyze --level=9 --memory-limit=2G

# Modulo specifico
./vendor/bin/phpstan analyze Modules/SaluteOra --level=9
./vendor/bin/phpstan analyze Modules/Xot --level=10
```

## Regole di Tipizzazione Universali

### Strict Types Obbligatorio
```php
<?php

declare(strict_types=1);

// SEMPRE all'inizio di ogni file PHP
```

### Proprietà Modelli Standard
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
            'is_active' => 'boolean',
        ];
    }
}
```

### Relazioni Eloquent Tipizzate
```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, MioModello>
 */
public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
{
    return $this->belongsTo(User::class);
}

/**
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<RelatedModel>
 */
public function relatedModels(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(RelatedModel::class);
}
```

## Errori Comuni e Soluzioni Universali

### 1. Undefined Property (Tutti i Moduli)
```php
// ❌ ERRORE: Access to an undefined property
// ✅ SOLUZIONE: Aggiungere annotazione @property
/**
 * @property int $anno
 * @property Carbon|null $dal
 * @property Carbon|null $al
 */
```

### 2. Missing Return Type (Tutti i Moduli)
```php
// ❌ ERRORE: Method X does not have a return type specified
// ✅ SOLUZIONE: Aggiungere tipo di ritorno esplicito
public function getFullNameAttribute(): string
{
    return $this->nome . ' ' . $this->cognome;
}
```

### 3. Factory Covariance (Tutti i Moduli)
```php
// ❌ ERRORE: $fillable covariance issue
/** @var array<int, string> */
protected $fillable = ['nome'];

// ✅ SOLUZIONE: Usare list<string>
/** @var list<string> */
protected $fillable = ['nome', 'email'];
```

### 4. Array Shape Mismatch (Tutti i Moduli)
```php
// ❌ ERRORE: Parameter expects array{id: int, name: string}, array given
// ✅ SOLUZIONE: Utilizzare docblock completo
/**
 * @param array{id: int, name: string} $data
 */
public function process(array $data): void
{
    // Implementazione...
}
```

### 5. Nullable Parameters (Tutti i Moduli)
```php
// ❌ ERRORE: Parameter expects string, string|null given
// ✅ SOLUZIONE: Gestire caso null
public function process(?string $value): string
{
    return $value ?? '';
}
```

## Pattern Specifici per Modulo

### Modelli Laraxot (Tutti i Moduli)
```php
// ✅ SEMPRE estendere BaseModel del modulo
class User extends BaseModel
{
    // Mai estendere Model o XotBaseModel direttamente
}
```

### Filament Resources (Tutti i Moduli)
```php
// ✅ SEMPRE estendere XotBaseResource
class UserResource extends XotBaseResource
{
    /**
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name'),
            'email' => TextInput::make('email'),
        ];
    }
}
```

### Enum Integration (Tutti i Moduli)
```php
/**
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        'status' => StatusEnum::class,
        'type' => UserTypeEnum::class,
    ];
}
```

## Configurazioni per Modulo

### Activity Module
- **Livello**: 9
- **Focus**: Models, Actions
- **Problemi comuni**: Factory types, Collection generics

### Chart Module  
- **Livello**: 9
- **Focus**: Widget types, Data arrays
- **Problemi comuni**: Chart data arrays, Widget properties

### Cms Module
- **Livello**: 9
- **Focus**: Blade components, Assets
- **Problemi comuni**: Asset paths, Component properties

### FormBuilder Module
- **Livello**: 9
- **Focus**: Form components, Validation
- **Problemi comuni**: Form data types, Validation rules

### Gdpr Module
- **Livello**: 9
- **Focus**: Privacy models, Consent
- **Problemi comuni**: Boolean types, Date handling

### Geo Module
- **Livello**: 9
- **Focus**: Geographic data, Coordinates
- **Problemi comuni**: Float coordinates, Polygon data

### Job Module
- **Livello**: 9
- **Focus**: Queue jobs, Dispatching
- **Problemi comuni**: Job data, Queue parameters

### Lang Module
- **Livello**: 9
- **Focus**: Translations, Localization
- **Problemi comuni**: Array translations, Locale handling

### Media Module
- **Livello**: 9
- **Focus**: File uploads, Media handling
- **Problemi comuni**: File types, Upload validation

### Notify Module
- **Livello**: 9
- **Focus**: Notifications, Channels
- **Problemi comuni**: Notification data, Channel types

### SaluteMo Module
- **Livello**: 9
- **Focus**: Business logic, Models
- **Problemi comuni**: Model relationships, Data validation

### SaluteOra Module
- **Livello**: 10 (CRITICO)
- **Focus**: Core business, Appointments
- **Problemi comuni**: Complex relationships, State management

### Tenant Module
- **Livello**: 9
- **Focus**: Multi-tenancy, Scoping
- **Problemi comuni**: Tenant resolution, Scope queries

### UI Module
- **Livello**: 9
- **Focus**: Components, Widgets
- **Problemi comuni**: Component props, Widget data

### User Module
- **Livello**: 10 (CRITICO)
- **Focus**: Authentication, Authorization
- **Problemi comuni**: User types, Permission arrays

### Xot Module
- **Livello**: 10 (CRITICO)
- **Focus**: Framework base, Core functionality
- **Problemi comuni**: Base classes, Abstract methods

## Workflow CI/CD Universale

### Pre-commit Hook
```bash
#!/bin/bash
cd /var/www/html/_bases/base_saluteora/laravel

# Analisi tutti i moduli
./vendor/bin/phpstan analyze Modules --level=9

if [ $? -ne 0 ]; then
    echo "❌ PHPStan errors found. Commit aborted."
    exit 1
fi

echo "✅ PHPStan analysis passed!"
```

### GitHub Actions
```yaml
phpstan:
  name: PHPStan Analysis
  runs-on: ubuntu-latest
  steps:
    - uses: actions/checkout@v3
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: 8.2
    - name: Install dependencies
      run: composer install --no-dev --optimize-autoloader
    - name: Run PHPStan
      run: |
        cd laravel
        ./vendor/bin/phpstan analyze Modules --level=9 --no-progress
```

## Baseline Management

### ⚠️ Regole Baseline Universali
- **Mai** aggiungere nuovi errori al baseline
- **Sempre** ridurre il baseline quando possibile
- **Documentare** ogni ignore con motivo specifico
- **Rivedere** baseline ogni sprint

### Comandi Baseline
```bash
# Generare baseline
./vendor/bin/phpstan analyze --generate-baseline

# Analizzare con baseline
./vendor/bin/phpstan analyze --baseline=phpstan-baseline.neon

# Pulire cache
./vendor/bin/phpstan clear-result-cache
```

## Troubleshooting Universale

### Memory Issues
```bash
# Aumentare memoria
./vendor/bin/phpstan analyze --memory-limit=4G

# Analisi parallela
./vendor/bin/phpstan analyze --parallel
```

### Performance
```bash
# Debug performance
./vendor/bin/phpstan analyze --debug

# Profiling
./vendor/bin/phpstan analyze --xdebug
```

### Cache Issues
```bash
# Pulire tutte le cache
./vendor/bin/phpstan clear-result-cache
composer dump-autoload
php artisan cache:clear
```

## Progressione Livelli per Tutti i Moduli

| Livello | Controlli | Moduli Target |
|---------|-----------|---------------|
| 1-3 | Sintassi base | Legacy code |
| 4-6 | Tipi rigorosi | Code in refactor |
| 7-8 | DocBlocks dettagliati | Standard modules |
| 9 | Rigidità alta | All new modules |
| 10 | Massima rigidità | Xot, SaluteOra, User |

## 🔥 ELIMINAZIONE DUPLICAZIONI

### File da Eliminare IMMEDIATAMENTE
Tutti questi file sono DUPLICATI e vanno eliminati:

```bash
# Activity
rm Modules/Activity/docs/phpstan-fixes.md
rm Modules/Activity/docs/phpstan_fixes.md

# Chart  
rm Modules/Chart/docs/phpstan-usage.md
rm Modules/Chart/docs/phpstan_usage.md

# Cms
rm Modules/Cms/docs/phpstan-incremental.md
rm Modules/Cms/docs/phpstan.md
rm Modules/Cms/docs/phpstan_incremental.md
rm Modules/Cms/docs/phpstan_issues.md

# FormBuilder
rm Modules/FormBuilder/docs/phpstan/phpstan-fixes-2025-08-01.md
rm Modules/FormBuilder/docs/phpstan-corrections.md
rm Modules/FormBuilder/docs/phpstan-fixes.md
rm Modules/FormBuilder/docs/phpstan_fixes_2025.md

# Geo
rm Modules/Geo/docs/PHPSTAN_FIXES.md
rm Modules/Geo/docs/phpstan/phpstan-fixes-gennaio-2025.md
rm Modules/Geo/docs/phpstan-class-references-fix.md
rm Modules/Geo/docs/phpstan-fixes-uppercase.md
rm Modules/Geo/docs/phpstan_fixes_uppercase.md
rm Modules/Geo/docs/phpstan_return_type_errors.md

# Job
rm Modules/Job/docs/phpstan-fixes.md
rm Modules/Job/docs/phpstan_filament_fixes.md
rm Modules/Job/docs/phpstan_level10_fixes.md

# Lang
rm Modules/Lang/docs/phpstan-corrections.md
rm Modules/Lang/docs/phpstan-fixes.md
rm Modules/Lang/docs/phpstan-level10-fixes.md
rm Modules/Lang/docs/phpstan-level9-fixes.md
rm Modules/Lang/docs/phpstan-report.md
rm Modules/Lang/docs/phpstan_level10_fixes.md

# E tutti gli altri 71+ file duplicati...
```

### Mantenere Solo
- **Questo file**: `/laravel/Modules/Xot/docs/phpstan-consolidated.md`
- **Config files**: `phpstan.neon`, `phpstan-baseline.neon` nei singoli moduli

---

**🎯 Obiettivo**: Da 121+ file duplicati a 1 file centralizzato  
**📈 Beneficio**: 99% riduzione duplicazioni, manutenzione semplificata  
**🔗 Vedi anche**: [best-practices.md](best-practices.md) | [coding-standards.md](coding-standards.md)

**Aggiornato**: 2025-08-07  
**Categoria**: development  
**Priorità**: CRITICA
