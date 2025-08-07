# FormBuilder - Design Patterns per i Modelli

## Introduzione

Questo documento descrive i design pattern utilizzati nei modelli del modulo FormBuilder, seguendo le best practice identificate negli altri moduli del progetto SaluteOra.

## Pattern Architetturali

### 1. Base Model Pattern

Tutti i modelli del modulo FormBuilder estendono `BaseModel` del modulo stesso, seguendo la convenzione Laraxot:

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast.
     *
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

### 2. Modello Form

Il modello principale per la gestione dei form:

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FormBuilder\Enums\FormStatusEnum;
use Modules\User\Models\User;

/**
 * Form model for dynamic form creation.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property FormStatusEnum $status
 * @property array<string, mixed> $configuration
 * @property int|null $created_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FormField> $fields
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FormSubmission> $submissions
 * @property-read User|null $creator
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
        'created_by',
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
     * Get the submissions for this form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<FormSubmission>
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }

    /**
     * Get the user who created this form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Form>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
```

### 3. Modello FormField

Modello per i campi del form:

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FormBuilder\Enums\FieldTypeEnum;

/**
 * FormField model for form field configuration.
 *
 * @property int $id
 * @property int $form_id
 * @property string $name
 * @property string $label
 * @property FieldTypeEnum $type
 * @property array<string, mixed> $validation_rules
 * @property array<string, mixed> $options
 * @property int $sort_order
 * @property bool $required
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read Form $form
 */
class FormField extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'form_id',
        'name',
        'label',
        'type',
        'validation_rules',
        'options',
        'sort_order',
        'required',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string|class-string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'type' => FieldTypeEnum::class,
            'validation_rules' => 'array',
            'options' => 'array',
            'required' => 'boolean',
        ]);
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
}
```

## Convenzioni di Naming

### 1. Nomi Tabelle

- Utilizzare snake_case plurale
- Prefisso del modulo quando necessario
- Esempi: `forms`, `form_fields`, `form_submissions`

### 2. Nomi Colonne

- Utilizzare snake_case
- Suffissi standard: `_id` per foreign key, `_at` per timestamp
- Esempi: `created_by`, `updated_at`, `form_id`

### 3. Nomi Relazioni

- Utilizzare camelCase
- Nomi descrittivi e chiari
- Esempi: `fields()`, `submissions()`, `creator()`

## Pattern di Validazione

### 1. Validazione a Livello Modello

```php
/**
 * Boot the model.
 */
protected static function boot(): void
{
    parent::boot();

    static::saving(function (Form $form): void {
        // Validazione custom prima del salvataggio
        if (empty($form->name)) {
            throw new \InvalidArgumentException('Form name is required');
        }
    });
}
```

### 2. Mutators e Accessors

```php
/**
 * Set the form name.
 */
protected function name(): Attribute
{
    return Attribute::make(
        set: fn (string $value): string => trim($value),
    );
}

/**
 * Get the form display name.
 */
protected function displayName(): Attribute
{
    return Attribute::make(
        get: fn (): string => $this->name . ' (' . $this->fields->count() . ' fields)',
    );
}
```

## Pattern di Scoping

### 1. Query Scopes

```php
/**
 * Scope a query to only include active forms.
 *
 * @param \Illuminate\Database\Eloquent\Builder<Form> $query
 * @return \Illuminate\Database\Eloquent\Builder<Form>
 */
public function scopeActive(Builder $query): Builder
{
    return $query->where('status', FormStatusEnum::ACTIVE);
}

/**
 * Scope a query to only include forms created by a specific user.
 *
 * @param \Illuminate\Database\Eloquent\Builder<Form> $query
 * @param int $userId
 * @return \Illuminate\Database\Eloquent\Builder<Form>
 */
public function scopeCreatedBy(Builder $query, int $userId): Builder
{
    return $query->where('created_by', $userId);
}
```

## Best Practices

### 1. Type Safety

- Sempre utilizzare `declare(strict_types=1);`
- Annotazioni PHPDoc complete per tutte le proprietà
- Cast espliciti per tutti gli attributi

### 2. Relazioni

- Tipizzazione esplicita delle relazioni
- Lazy loading per performance
- Eager loading quando necessario

### 3. Convenzioni Laraxot
- Estensione di BaseModel del modulo
- Utilizzo di enum per stati e tipi
- Seguire le convenzioni di naming

## Collegamenti Correlati

- [Architecture Overview](../architecture/overview.md)
- [Enums Implementation](../enums/implementation.md)
- [Service Pattern](../services/README.md)
- [PHPStan Guidelines](../phpstan/guidelines.md)

---

**Ultimo aggiornamento**: 2025-07-29
**Autore**: Sistema di correzione automatica
**Stato**: ✅ Completato
