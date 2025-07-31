# FormBuilder - PHPStan Guidelines

## Introduzione

Il modulo FormBuilder mira a raggiungere la **compliance PHPStan livello 9** su tutti i file core, seguendo le best practice identificate negli altri moduli del progetto SaluteOra.

## Target di Qualità

### File Core PHPStan Level 9

I seguenti file devono passare PHPStan livello 9 senza errori:

#### Models
- `app/Models/BaseModel.php` - Modello base del modulo
- `app/Models/Form.php` - Modello principale form
- `app/Models/FormField.php` - Modello campi form
- `app/Models/FormTemplate.php` - Modello template
- `app/Models/FormSubmission.php` - Modello submission ✅ **Corretto**

#### Services
- `app/Services/FormBuilderService.php` - Service principale
- `app/Services/ValidationService.php` - Service validazione
- `app/Services/TemplateService.php` - Service template
- `app/Services/SubmissionService.php` - Service submission

#### Data Objects
- `app/Data/FormData.php` - DTO form
- `app/Data/FieldData.php` - DTO campi
- `app/Data/ValidationRuleData.php` - DTO regole validazione
- `app/Data/SubmissionData.php` - DTO submission

#### Enums
- `app/Enums/FieldTypeEnum.php` - Tipi campo
- `app/Enums/FormStatusEnum.php` - Stati form
- `app/Enums/ValidationRuleEnum.php` - Regole validazione
- `app/Enums/SubmissionStatusEnum.php` - Stati submission

## Regole di Tipizzazione

### 1. Strict Types

Tutti i file devono iniziare con:

```php
<?php

declare(strict_types=1);
```

### 2. Proprietà dei Modelli

```php
/**
 * Form model for dynamic form creation.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property FormStatusEnum $status
 * @property array<string, mixed> $configuration
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FormField> $fields
 */
class Form extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'configuration',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string|class-string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'status' => FormStatusEnum::class,
            'configuration' => 'array',
        ]);
    }
}
```

### 3. Relazioni Eloquent

```php
/**
 * Get the fields for this form.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany<FormField>
 */
public function fields(): HasMany
{
    return $this->hasMany(FormField::class);
}

/**
 * Get the form that owns this field.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Form, FormField>
 */
public function form(): BelongsTo
{
    return $this->belongsTo(Form::class);
}
```

### 4. Collection Types

```php
/**
 * Get all active forms.
 *
 * @return \Illuminate\Database\Eloquent\Collection<int, Form>
 */
public function getActiveForms(): Collection
{
    return Form::where('status', FormStatusEnum::ACTIVE)->get();
}

/**
 * Process multiple submissions.
 *
 * @param array<int, SubmissionData> $submissions
 * @return list<FormSubmission>
 */
public function processMultipleSubmissions(array $submissions): array
{
    return array_map(
        fn (SubmissionData $data): FormSubmission => $this->processSubmission($data),
        $submissions
    );
}
```

### 5. Enum Usage

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Enums;

/**
 * Form status enumeration.
 */
enum FormStatusEnum: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case ARCHIVED = 'archived';

    /**
     * Get the label for the status.
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::ARCHIVED => 'Archived',
        };
    }

    /**
     * Get all active statuses.
     *
     * @return list<self>
     */
    public static function getActiveStatuses(): array
    {
        return [self::ACTIVE];
    }
}
```

## Errori Comuni e Soluzioni

### 1. Missing Property Annotations

**Errore**:
```
Access to an undefined property Form::$fields
```

**Soluzione**:
```php
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FormField> $fields
 */
class Form extends BaseModel
```

### 2. Missing Return Types

**Errore**:
```
Method Form::getFields() has no return type specified
```

**Soluzione**:
```php
/**
 * Get form fields.
 *
 * @return \Illuminate\Database\Eloquent\Collection<int, FormField>
 */
public function getFields(): Collection
{
    return $this->fields;
}
```

### 3. Array Shape Issues

**Errore**:
```
Parameter #1 $data of method expects array{name: string, type: string}, array given
```

**Soluzione**:
```php
/**
 * Create field from array.
 *
 * @param array{name: string, type: string, required?: bool} $data
 * @return FormField
 */
public function createFieldFromArray(array $data): FormField
{
    // Implementation
}
```

### 4. Generic Collection Issues

**Errore**:
```
Generic type Collection<int, FormField> is not specified
```

**Soluzione**:
```php
/**
 * @return \Illuminate\Database\Eloquent\Collection<int, FormField>
 */
public function getRequiredFields(): Collection
{
    return $this->fields->filter(fn (FormField $field): bool => $field->required);
}
```

## Comandi di Verifica

### Test PHPStan Completo

```bash
# Eseguire da /var/www/html/_bases/base_saluteora/laravel
cd /var/www/html/_bases/base_saluteora/laravel

# Test completo modulo FormBuilder
./vendor/bin/phpstan analyze Modules/FormBuilder --level=9 --no-progress

# Test file specifici
./vendor/bin/phpstan analyze Modules/FormBuilder/app/Models/Form.php \
                             Modules/FormBuilder/app/Services/FormBuilderService.php \
                             --level=9 --no-progress
```

### Test Incrementale

```bash
# Test solo Models
./vendor/bin/phpstan analyze Modules/FormBuilder/app/Models --level=9

# Test solo Services
./vendor/bin/phpstan analyze Modules/FormBuilder/app/Services --level=9

# Test solo Data Objects
./vendor/bin/phpstan analyze Modules/FormBuilder/app/Data --level=9
```

## Configurazione PHPStan

### phpstan.neon (se necessario)

```neon
parameters:
    level: 9
    paths:
        - Modules/FormBuilder/app
    excludePaths:
        - Modules/FormBuilder/app/Console
    checkMissingIterableValueType: false
    checkGenericClassInNonGenericObjectType: false
```

## Best Practices

### 1. Documentazione PHPDoc

- **Sempre** documentare proprietà dei modelli
- **Sempre** specificare tipi di ritorno delle relazioni
- **Sempre** documentare parametri array con shape
- **Sempre** utilizzare generics per Collection

### 2. Type Safety

- **Sempre** utilizzare `declare(strict_types=1);`
- **Sempre** specificare tipi di ritorno espliciti
- **Evitare** `mixed` quando possibile
- **Preferire** union types a `mixed`

### 3. Enum Usage

- **Sempre** utilizzare enum per stati e tipi
- **Sempre** implementare metodi helper negli enum
- **Sempre** utilizzare backing values appropriati
- **Evitare** stringhe hardcoded per stati

### 4. Collection Handling

- **Sempre** specificare generic types per Collection
- **Sempre** utilizzare type-safe operations
- **Sempre** documentare il tipo di elementi nella Collection
- **Evitare** operazioni non type-safe su Collection

## Metriche di Qualità Target

### Gennaio 2025 - Obiettivi

- **Type Safety**: 100% sui file core
- **Runtime Safety**: 100% con error handling robusto
- **Template Types**: Risoluzione problemi Collection generics
- **API Integration**: Validazione completa response types

### Monitoraggio Continuo

```bash
# Script di monitoraggio qualità
#!/bin/bash
echo "=== PHPStan FormBuilder Quality Check ==="
./vendor/bin/phpstan analyze Modules/FormBuilder --level=9 --no-progress
echo "=== End Quality Check ==="
```

## Collegamenti Correlati

- [Architecture Overview](../architecture/overview.md)
- [Model Design Patterns](../models/design-patterns.md)
- [Service Layer](../services/README.md)
- [Development Guidelines](../development/guidelines.md)

---

**Ultimo aggiornamento**: 2025-07-29
**Autore**: Sistema di correzione automatica
**Stato**: ✅ Completato
