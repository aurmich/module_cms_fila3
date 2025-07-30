# Implementazione Enum - Modulo FormBuilder

## Data: 2025-01-06

## Panoramica

Gli enum nel modulo FormBuilder forniscono type safety e consistenza per i tipi di campo, stati dei form e altre enumerazioni del sistema, seguendo le best practices PHP 8.1+.

## Enum Core

### 1. FieldTypeEnum
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Enums;

enum FieldTypeEnum: string
{
    case TEXT = 'text';
    case EMAIL = 'email';
    case PASSWORD = 'password';
    case TEXTAREA = 'textarea';
    case SELECT = 'select';
    case CHECKBOX = 'checkbox';
    case RADIO = 'radio';
    case FILE = 'file';
    case DATE = 'date';
    case DATETIME = 'datetime';
    case NUMBER = 'number';
    case TEL = 'tel';
    case URL = 'url';
    case HIDDEN = 'hidden';
    case COLOR = 'color';
    case RANGE = 'range';
    case TIME = 'time';
    case WEEK = 'week';
    case MONTH = 'month';
    case DATETIME_LOCAL = 'datetime-local';

    public function getLabel(): string
    {
        return match($this) {
            self::TEXT => 'Text Input',
            self::EMAIL => 'Email Input',
            self::PASSWORD => 'Password Input',
            self::TEXTAREA => 'Text Area',
            self::SELECT => 'Select Dropdown',
            self::CHECKBOX => 'Checkbox',
            self::RADIO => 'Radio Button',
            self::FILE => 'File Upload',
            self::DATE => 'Date Input',
            self::DATETIME => 'Date Time Input',
            self::NUMBER => 'Number Input',
            self::TEL => 'Telephone Input',
            self::URL => 'URL Input',
            self::HIDDEN => 'Hidden Input',
            self::COLOR => 'Color Picker',
            self::RANGE => 'Range Slider',
            self::TIME => 'Time Input',
            self::WEEK => 'Week Input',
            self::MONTH => 'Month Input',
            self::DATETIME_LOCAL => 'Local Date Time Input',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::TEXT => 'heroicon-o-document-text',
            self::EMAIL => 'heroicon-o-envelope',
            self::PASSWORD => 'heroicon-o-lock-closed',
            self::TEXTAREA => 'heroicon-o-document',
            self::SELECT => 'heroicon-o-chevron-down',
            self::CHECKBOX => 'heroicon-o-check-square',
            self::RADIO => 'heroicon-o-circle',
            self::FILE => 'heroicon-o-paper-clip',
            self::DATE => 'heroicon-o-calendar',
            self::DATETIME => 'heroicon-o-clock',
            self::NUMBER => 'heroicon-o-calculator',
            self::TEL => 'heroicon-o-phone',
            self::URL => 'heroicon-o-link',
            self::HIDDEN => 'heroicon-o-eye-slash',
            self::COLOR => 'heroicon-o-swatch',
            self::RANGE => 'heroicon-o-adjustments-horizontal',
            self::TIME => 'heroicon-o-clock',
            self::WEEK => 'heroicon-o-calendar-days',
            self::MONTH => 'heroicon-o-calendar',
            self::DATETIME_LOCAL => 'heroicon-o-calendar-days',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::TEXT => 'gray',
            self::EMAIL => 'blue',
            self::PASSWORD => 'red',
            self::TEXTAREA => 'green',
            self::SELECT => 'purple',
            self::CHECKBOX => 'yellow',
            self::RADIO => 'orange',
            self::FILE => 'indigo',
            self::DATE => 'cyan',
            self::DATETIME => 'pink',
            self::NUMBER => 'teal',
            self::TEL => 'lime',
            self::URL => 'emerald',
            self::HIDDEN => 'gray',
            self::COLOR => 'rose',
            self::RANGE => 'amber',
            self::TIME => 'sky',
            self::WEEK => 'violet',
            self::MONTH => 'fuchsia',
            self::DATETIME_LOCAL => 'slate',
        };
    }

    public function getValidationRules(): array
    {
        return match($this) {
            self::EMAIL => ['email'],
            self::URL => ['url'],
            self::NUMBER => ['numeric'],
            self::DATE => ['date'],
            self::DATETIME => ['date'],
            self::DATETIME_LOCAL => ['date'],
            self::TIME => ['date_format:H:i'],
            self::WEEK => ['date_format:Y-\WW'],
            self::MONTH => ['date_format:Y-m'],
            self::TEL => ['regex:/^[\+]?[1-9][\d]{0,15}$/'],
            self::FILE => ['file'],
            default => [],
        };
    }

    public function isSelectType(): bool
    {
        return in_array($this, [
            self::SELECT,
            self::RADIO,
            self::CHECKBOX,
        ]);
    }

    public function isFileType(): bool
    {
        return $this === self::FILE;
    }

    public function isDateType(): bool
    {
        return in_array($this, [
            self::DATE,
            self::DATETIME,
            self::DATETIME_LOCAL,
            self::TIME,
            self::WEEK,
            self::MONTH,
        ]);
    }

    public function isNumericType(): bool
    {
        return in_array($this, [
            self::NUMBER,
            self::RANGE,
        ]);
    }

    public function getHtmlType(): string
    {
        return $this->value;
    }

    public static function getSelectOptions(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->getLabel()];
        })->toArray();
    }

    public static function getGroupedOptions(): array
    {
        return [
            'Basic' => [
                self::TEXT->value => self::TEXT->getLabel(),
                self::EMAIL->value => self::EMAIL->getLabel(),
                self::PASSWORD->value => self::PASSWORD->getLabel(),
                self::TEXTAREA->value => self::TEXTAREA->getLabel(),
            ],
            'Selection' => [
                self::SELECT->value => self::SELECT->getLabel(),
                self::CHECKBOX->value => self::CHECKBOX->getLabel(),
                self::RADIO->value => self::RADIO->getLabel(),
            ],
            'Date & Time' => [
                self::DATE->value => self::DATE->getLabel(),
                self::DATETIME->value => self::DATETIME->getLabel(),
                self::TIME->value => self::TIME->getLabel(),
                self::WEEK->value => self::WEEK->getLabel(),
                self::MONTH->value => self::MONTH->getLabel(),
                self::DATETIME_LOCAL->value => self::DATETIME_LOCAL->getLabel(),
            ],
            'Specialized' => [
                self::NUMBER->value => self::NUMBER->getLabel(),
                self::RANGE->value => self::RANGE->getLabel(),
                self::COLOR->value => self::COLOR->getLabel(),
                self::TEL->value => self::TEL->getLabel(),
                self::URL->value => self::URL->getLabel(),
                self::FILE->value => self::FILE->getLabel(),
                self::HIDDEN->value => self::HIDDEN->getLabel(),
            ],
        ];
    }
}
```

### 2. FormStatusEnum
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Enums;

enum FormStatusEnum: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case ARCHIVED = 'archived';
    case PUBLISHED = 'published';
    case SCHEDULED = 'scheduled';
    case EXPIRED = 'expired';

    public function getLabel(): string
    {
        return match($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::ARCHIVED => 'Archived',
            self::PUBLISHED => 'Published',
            self::SCHEDULED => 'Scheduled',
            self::EXPIRED => 'Expired',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::ACTIVE => 'success',
            self::INACTIVE => 'warning',
            self::ARCHIVED => 'danger',
            self::PUBLISHED => 'success',
            self::SCHEDULED => 'info',
            self::EXPIRED => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::DRAFT => 'heroicon-o-document',
            self::ACTIVE => 'heroicon-o-check-circle',
            self::INACTIVE => 'heroicon-o-pause-circle',
            self::ARCHIVED => 'heroicon-o-archive-box',
            self::PUBLISHED => 'heroicon-o-globe-alt',
            self::SCHEDULED => 'heroicon-o-clock',
            self::EXPIRED => 'heroicon-o-x-circle',
        };
    }

    public function isEditable(): bool
    {
        return in_array($this, [
            self::DRAFT,
            self::INACTIVE,
        ]);
    }

    public function isPublic(): bool
    {
        return in_array($this, [
            self::ACTIVE,
            self::PUBLISHED,
        ]);
    }

    public function isArchived(): bool
    {
        return $this === self::ARCHIVED;
    }

    public function canBeActivated(): bool
    {
        return in_array($this, [
            self::DRAFT,
            self::INACTIVE,
        ]);
    }

    public function canBeDeactivated(): bool
    {
        return in_array($this, [
            self::ACTIVE,
            self::PUBLISHED,
        ]);
    }

    public static function getSelectOptions(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->getLabel()];
        })->toArray();
    }

    public static function getActiveOptions(): array
    {
        return collect(self::cases())
            ->filter(fn ($case) => $case->isPublic())
            ->mapWithKeys(function ($case) {
                return [$case->value => $case->getLabel()];
            })->toArray();
    }
}
```

### 3. FormCategoryEnum
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Enums;

enum FormCategoryEnum: string
{
    case MEDICAL = 'medical';
    case REGISTRATION = 'registration';
    case CONTACT = 'contact';
    case FEEDBACK = 'feedback';
    case SURVEY = 'survey';
    case APPOINTMENT = 'appointment';
    case CONSENT = 'consent';
    case CUSTOM = 'custom';

    public function getLabel(): string
    {
        return match($this) {
            self::MEDICAL => 'Medical',
            self::REGISTRATION => 'Registration',
            self::CONTACT => 'Contact',
            self::FEEDBACK => 'Feedback',
            self::SURVEY => 'Survey',
            self::APPOINTMENT => 'Appointment',
            self::CONSENT => 'Consent',
            self::CUSTOM => 'Custom',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::MEDICAL => 'red',
            self::REGISTRATION => 'blue',
            self::CONTACT => 'green',
            self::FEEDBACK => 'yellow',
            self::SURVEY => 'purple',
            self::APPOINTMENT => 'indigo',
            self::CONSENT => 'pink',
            self::CUSTOM => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match($this) {
            self::MEDICAL => 'heroicon-o-heart',
            self::REGISTRATION => 'heroicon-o-user-plus',
            self::CONTACT => 'heroicon-o-envelope',
            self::FEEDBACK => 'heroicon-o-chat-bubble-left-right',
            self::SURVEY => 'heroicon-o-clipboard-document-list',
            self::APPOINTMENT => 'heroicon-o-calendar-days',
            self::CONSENT => 'heroicon-o-document-check',
            self::CUSTOM => 'heroicon-o-cog-6-tooth',
        };
    }

    public function getDefaultFields(): array
    {
        return match($this) {
            self::MEDICAL => [
                ['name' => 'symptoms', 'type' => FieldTypeEnum::TEXTAREA, 'label' => 'Symptoms', 'required' => true],
                ['name' => 'allergies', 'type' => FieldTypeEnum::TEXT, 'label' => 'Allergies', 'required' => false],
                ['name' => 'medications', 'type' => FieldTypeEnum::TEXT, 'label' => 'Current Medications', 'required' => false],
            ],
            self::REGISTRATION => [
                ['name' => 'first_name', 'type' => FieldTypeEnum::TEXT, 'label' => 'First Name', 'required' => true],
                ['name' => 'last_name', 'type' => FieldTypeEnum::TEXT, 'label' => 'Last Name', 'required' => true],
                ['name' => 'email', 'type' => FieldTypeEnum::EMAIL, 'label' => 'Email Address', 'required' => true],
                ['name' => 'phone', 'type' => FieldTypeEnum::TEL, 'label' => 'Phone Number', 'required' => false],
            ],
            self::CONTACT => [
                ['name' => 'name', 'type' => FieldTypeEnum::TEXT, 'label' => 'Name', 'required' => true],
                ['name' => 'email', 'type' => FieldTypeEnum::EMAIL, 'label' => 'Email', 'required' => true],
                ['name' => 'subject', 'type' => FieldTypeEnum::TEXT, 'label' => 'Subject', 'required' => true],
                ['name' => 'message', 'type' => FieldTypeEnum::TEXTAREA, 'label' => 'Message', 'required' => true],
            ],
            self::FEEDBACK => [
                ['name' => 'rating', 'type' => FieldTypeEnum::SELECT, 'label' => 'Rating', 'required' => true],
                ['name' => 'comment', 'type' => FieldTypeEnum::TEXTAREA, 'label' => 'Comment', 'required' => false],
            ],
            self::SURVEY => [
                ['name' => 'question_1', 'type' => FieldTypeEnum::TEXT, 'label' => 'Question 1', 'required' => true],
                ['name' => 'question_2', 'type' => FieldTypeEnum::TEXT, 'label' => 'Question 2', 'required' => false],
            ],
            self::APPOINTMENT => [
                ['name' => 'preferred_date', 'type' => FieldTypeEnum::DATE, 'label' => 'Preferred Date', 'required' => true],
                ['name' => 'preferred_time', 'type' => FieldTypeEnum::TIME, 'label' => 'Preferred Time', 'required' => true],
                ['name' => 'reason', 'type' => FieldTypeEnum::TEXTAREA, 'label' => 'Reason for Visit', 'required' => true],
            ],
            self::CONSENT => [
                ['name' => 'agree_terms', 'type' => FieldTypeEnum::CHECKBOX, 'label' => 'I agree to the terms and conditions', 'required' => true],
                ['name' => 'agree_privacy', 'type' => FieldTypeEnum::CHECKBOX, 'label' => 'I agree to the privacy policy', 'required' => true],
            ],
            self::CUSTOM => [],
        };
    }

    public static function getSelectOptions(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->getLabel()];
        })->toArray();
    }
}
```

### 4. ValidationRuleEnum
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Enums;

enum ValidationRuleEnum: string
{
    case REQUIRED = 'required';
    case EMAIL = 'email';
    case URL = 'url';
    case NUMERIC = 'numeric';
    case INTEGER = 'integer';
    case STRING = 'string';
    case ARRAY = 'array';
    case BOOLEAN = 'boolean';
    case DATE = 'date';
    case DATE_FORMAT = 'date_format';
    case BEFORE = 'before';
    case AFTER = 'after';
    case MIN = 'min';
    case MAX = 'max';
    case BETWEEN = 'between';
    case SIZE = 'size';
    case ALPHA = 'alpha';
    case ALPHA_NUM = 'alpha_num';
    case ALPHA_DASH = 'alpha_dash';
    case REGEX = 'regex';
    case UNIQUE = 'unique';
    case EXISTS = 'exists';
    case CONFIRMED = 'confirmed';
    case DIFFERENT = 'different';
    case SAME = 'same';
    case IN = 'in';
    case NOT_IN = 'not_in';
    case FILLED = 'filled';
    case PRESENT = 'present';
    case ACCEPTED = 'accepted';
    case DECLINED = 'declined';
    case ACTIVE_URL = 'active_url';
    case IP = 'ip';
    case IPV4 = 'ipv4';
    case IPV6 = 'ipv6';
    case JSON = 'json';
    case NULLABLE = 'nullable';
    case SOMETIMES = 'sometimes';

    public function getLabel(): string
    {
        return match($this) {
            self::REQUIRED => 'Required',
            self::EMAIL => 'Email',
            self::URL => 'URL',
            self::NUMERIC => 'Numeric',
            self::INTEGER => 'Integer',
            self::STRING => 'String',
            self::ARRAY => 'Array',
            self::BOOLEAN => 'Boolean',
            self::DATE => 'Date',
            self::DATE_FORMAT => 'Date Format',
            self::BEFORE => 'Before',
            self::AFTER => 'After',
            self::MIN => 'Minimum',
            self::MAX => 'Maximum',
            self::BETWEEN => 'Between',
            self::SIZE => 'Size',
            self::ALPHA => 'Alpha',
            self::ALPHA_NUM => 'Alpha Numeric',
            self::ALPHA_DASH => 'Alpha Dash',
            self::REGEX => 'Regular Expression',
            self::UNIQUE => 'Unique',
            self::EXISTS => 'Exists',
            self::CONFIRMED => 'Confirmed',
            self::DIFFERENT => 'Different',
            self::SAME => 'Same',
            self::IN => 'In',
            self::NOT_IN => 'Not In',
            self::FILLED => 'Filled',
            self::PRESENT => 'Present',
            self::ACCEPTED => 'Accepted',
            self::DECLINED => 'Declined',
            self::ACTIVE_URL => 'Active URL',
            self::IP => 'IP Address',
            self::IPV4 => 'IPv4 Address',
            self::IPV6 => 'IPv6 Address',
            self::JSON => 'JSON',
            self::NULLABLE => 'Nullable',
            self::SOMETIMES => 'Sometimes',
        };
    }

    public function getDescription(): string
    {
        return match($this) {
            self::REQUIRED => 'The field must be present and not empty',
            self::EMAIL => 'The field must be a valid email address',
            self::URL => 'The field must be a valid URL',
            self::NUMERIC => 'The field must be a number',
            self::INTEGER => 'The field must be an integer',
            self::STRING => 'The field must be a string',
            self::ARRAY => 'The field must be an array',
            self::BOOLEAN => 'The field must be a boolean',
            self::DATE => 'The field must be a valid date',
            self::DATE_FORMAT => 'The field must match the specified date format',
            self::BEFORE => 'The field must be a date before the given date',
            self::AFTER => 'The field must be a date after the given date',
            self::MIN => 'The field must have a minimum value',
            self::MAX => 'The field must have a maximum value',
            self::BETWEEN => 'The field must be between the given values',
            self::SIZE => 'The field must have the exact size',
            self::ALPHA => 'The field must contain only alphabetic characters',
            self::ALPHA_NUM => 'The field must contain only alphanumeric characters',
            self::ALPHA_DASH => 'The field must contain only alphanumeric characters, dashes, and underscores',
            self::REGEX => 'The field must match the given regular expression',
            self::UNIQUE => 'The field must be unique in the database',
            self::EXISTS => 'The field must exist in the database',
            self::CONFIRMED => 'The field must have a matching confirmation field',
            self::DIFFERENT => 'The field must be different from another field',
            self::SAME => 'The field must be the same as another field',
            self::IN => 'The field must be in the given list',
            self::NOT_IN => 'The field must not be in the given list',
            self::FILLED => 'The field must be present when the form is submitted',
            self::PRESENT => 'The field must be present in the input data',
            self::ACCEPTED => 'The field must be accepted (checkbox)',
            self::DECLINED => 'The field must be declined (checkbox)',
            self::ACTIVE_URL => 'The field must be a valid, active URL',
            self::IP => 'The field must be a valid IP address',
            self::IPV4 => 'The field must be a valid IPv4 address',
            self::IPV6 => 'The field must be a valid IPv6 address',
            self::JSON => 'The field must be a valid JSON string',
            self::NULLABLE => 'The field may be null',
            self::SOMETIMES => 'The field is validated only if it is present',
        };
    }

    public function requiresParameter(): bool
    {
        return in_array($this, [
            self::MIN,
            self::MAX,
            self::BETWEEN,
            self::SIZE,
            self::DATE_FORMAT,
            self::BEFORE,
            self::AFTER,
            self::REGEX,
            self::UNIQUE,
            self::EXISTS,
            self::IN,
            self::NOT_IN,
        ]);
    }

    public static function getSelectOptions(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->getLabel()];
        })->toArray();
    }

    public static function getBasicRules(): array
    {
        return collect(self::cases())
            ->filter(fn ($case) => !$case->requiresParameter())
            ->mapWithKeys(function ($case) {
                return [$case->value => $case->getLabel()];
            })->toArray();
    }

    public static function getParameterRules(): array
    {
        return collect(self::cases())
            ->filter(fn ($case) => $case->requiresParameter())
            ->mapWithKeys(function ($case) {
                return [$case->value => $case->getLabel()];
            })->toArray();
    }
}
```

## Utilizzo negli Model

### 1. Casting negli Model
```php
// Form.php
protected $casts = [
    'status' => FormStatusEnum::class,
    'settings' => 'array',
    'is_active' => 'boolean',
];

// FormField.php
protected $casts = [
    'type' => FieldTypeEnum::class,
    'required' => 'boolean',
    'is_visible' => 'boolean',
    'validation_rules' => 'array',
    'options' => 'array',
];

// FormTemplate.php
protected $casts = [
    'category' => FormCategoryEnum::class,
    'fields_config' => 'array',
    'is_system' => 'boolean',
];
```

### 2. Scopes con Enum
```php
// Form.php
public function scopeByStatus($query, FormStatusEnum $status)
{
    return $query->where('status', $status);
}

public function scopeActive($query)
{
    return $query->where('status', FormStatusEnum::ACTIVE);
}

// FormField.php
public function scopeByType($query, FieldTypeEnum $type)
{
    return $query->where('type', $type);
}

public function scopeSelectTypes($query)
{
    return $query->whereIn('type', [
        FieldTypeEnum::SELECT,
        FieldTypeEnum::RADIO,
        FieldTypeEnum::CHECKBOX,
    ]);
}
```

## Utilizzo in Filament

### 1. Form Schema con Enum
```php
// FormResource.php
'status' => Forms\Components\Select::make('status')
    ->options(FormStatusEnum::class)
    ->default(FormStatusEnum::DRAFT)
    ->required(),

'type' => Forms\Components\Select::make('type')
    ->options(FieldTypeEnum::getGroupedOptions())
    ->required()
    ->searchable(),

'category' => Forms\Components\Select::make('category')
    ->options(FormCategoryEnum::class)
    ->searchable(),
```

### 2. Table Columns con Enum
```php
// FormResource.php
'status' => Tables\Columns\TextColumn::make('status')
    ->badge()
    ->color(fn (FormStatusEnum $state): string => $state->getColor()),

'type' => Tables\Columns\TextColumn::make('type')
    ->badge()
    ->color(fn (FieldTypeEnum $state): string => $state->getColor()),

'category' => Tables\Columns\TextColumn::make('category')
    ->badge()
    ->color(fn (FormCategoryEnum $state): string => $state->getColor()),
```

### 3. Filters con Enum
```php
// FormResource.php
'status' => Tables\Filters\SelectFilter::make('status')
    ->options(FormStatusEnum::class),

'type' => Tables\Filters\SelectFilter::make('type')
    ->options(FieldTypeEnum::class),

'category' => Tables\Filters\SelectFilter::make('category')
    ->options(FormCategoryEnum::class),
```

## Best Practices

### 1. Type Safety
- **Sempre** usare enum per valori fissi
- **Sempre** definire metodi helper negli enum
- **Sempre** usare match expressions per logica complessa
- **Mai** usare stringhe hardcoded

### 2. Filament Integration
- **Sempre** usare enum nei form schema
- **Sempre** implementare colori e icone negli enum
- **Sempre** usare enum nei filtri e colonne
- **Mai** duplicare logica di enum

### 3. Database Integration
- **Sempre** castare enum nei model
- **Sempre** usare enum negli scope
- **Sempre** validare enum nei form request
- **Mai** salvare enum come stringhe senza cast

### 4. Validation
- **Sempre** usare enum per regole di validazione
- **Sempre** implementare messaggi di errore specifici
- **Sempre** validare enum con regole appropriate
- **Mai** permettere valori non validi

## Collegamenti Correlati

### Documentazione Moduli
- [Form Implementation](form-implementation.md) - Implementazione dettagliata form
- [Field Management](field-management.md) - Gestione campi form
- [Architecture](architecture.md) - Architettura modulo
- [Filament Integration](filament-integration.md) - Integrazione Filament

### Documentazione Generale
- [PHP 8.1+ Enums](../../Xot/docs/php-enums.md) - Best practices enum PHP
- [Filament Best Practices](../../Xot/docs/filament-best-practices.md) - Best practices Filament
- [PHPStan Guidelines](../../../docs/phpstan_usage.md) - Linee guida PHPStan

---

**Ultimo aggiornamento**: 2025-01-06
**Autore**: Sistema di correzione automatica
**Stato**: ✅ Completato