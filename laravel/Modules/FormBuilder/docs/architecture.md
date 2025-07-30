# Architettura Modulo FormBuilder

## Data: 2025-01-06

## Panoramica Architetturale

Il modulo FormBuilder segue l'architettura modulare di Laraxot, implementando pattern di design moderni per la gestione di form dinamici e personalizzabili.

## Struttura del Modulo

### Directory Structure
```
Modules/FormBuilder/
├── app/
│   ├── Models/           # Modelli Eloquent
│   ├── Services/         # Business logic services
│   ├── Filament/         # Risorse Filament
│   ├── Http/            # Controllers e middleware
│   ├── Providers/       # Service providers
│   ├── Enums/           # Enumerazioni
│   ├── Actions/         # Single responsibility actions
│   ├── Events/          # Eventi del modulo
│   ├── Listeners/       # Listener per eventi
│   ├── Notifications/   # Notifiche
│   ├── Traits/          # Traits riutilizzabili
│   └── Contracts/       # Interfacce e contratti
├── config/              # Configurazioni
├── database/            # Migrazioni, seeders, factories
├── resources/           # Views, assets, lang
├── routes/              # Definizioni route
├── tests/               # Test unitari e feature
└── docs/                # Documentazione
```

## Pattern Architetturali

### 1. Service Layer Pattern
```php
// FormBuilderService.php
class FormBuilderService
{
    public function createForm(array $data): Form
    {
        // Business logic per creazione form
    }
    
    public function validateForm(Form $form, array $data): ValidationResult
    {
        // Business logic per validazione
    }
}
```

### 2. Repository Pattern
```php
// FormRepository.php
interface FormRepositoryInterface
{
    public function findById(int $id): ?Form;
    public function findByTemplate(string $template): Collection;
    public function save(Form $form): Form;
}

class FormRepository implements FormRepositoryInterface
{
    // Implementazione repository
}
```

### 3. Factory Pattern
```php
// FormFactory.php
class FormFactory
{
    public function createFromTemplate(string $templateName): Form
    {
        // Creazione form da template
    }
    
    public function createFromArray(array $data): Form
    {
        // Creazione form da array
    }
}
```

## Modelli Core

### 1. Form Model
```php
class Form extends Model
{
    protected $fillable = [
        'name',
        'description',
        'template_id',
        'is_active',
        'settings',
    ];
    
    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];
    
    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }
    
    public function template(): BelongsTo
    {
        return $this->belongsTo(FormTemplate::class);
    }
}
```

### 2. FormField Model
```php
class FormField extends Model
{
    protected $fillable = [
        'form_id',
        'name',
        'type',
        'label',
        'required',
        'validation_rules',
        'options',
        'order',
    ];
    
    protected $casts = [
        'required' => 'boolean',
        'validation_rules' => 'array',
        'options' => 'array',
    ];
    
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
```

### 3. FormTemplate Model
```php
class FormTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'fields_config',
        'is_system',
    ];
    
    protected $casts = [
        'fields_config' => 'array',
        'is_system' => 'boolean',
    ];
    
    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }
}
```

## Services Architecture

### 1. FormBuilderService
Responsabile per la creazione e gestione dei form:
```php
class FormBuilderService
{
    public function __construct(
        private FormRepositoryInterface $formRepository,
        private ValidationService $validationService,
        private TemplateService $templateService
    ) {}
    
    public function createForm(array $data): Form
    {
        // Validazione input
        $this->validateFormData($data);
        
        // Creazione form
        $form = $this->formRepository->create($data);
        
        // Creazione campi
        $this->createFields($form, $data['fields'] ?? []);
        
        return $form;
    }
    
    public function validateForm(Form $form, array $data): ValidationResult
    {
        return $this->validationService->validate($form, $data);
    }
}
```

### 2. ValidationService
Gestisce la validazione dinamica dei form:
```php
class ValidationService
{
    public function validate(Form $form, array $data): ValidationResult
    {
        $rules = $this->buildValidationRules($form);
        $validator = Validator::make($data, $rules);
        
        return new ValidationResult($validator);
    }
    
    private function buildValidationRules(Form $form): array
    {
        return $form->fields->mapWithKeys(function ($field) {
            return [$field->name => $field->validation_rules];
        })->toArray();
    }
}
```

### 3. TemplateService
Gestisce i template di form riutilizzabili:
```php
class TemplateService
{
    public function createTemplate(array $data): FormTemplate
    {
        // Validazione template data
        $this->validateTemplateData($data);
        
        // Creazione template
        return FormTemplate::create($data);
    }
    
    public function applyTemplate(Form $form, FormTemplate $template): Form
    {
        // Applicazione template al form
        $form->template()->associate($template);
        $form->save();
        
        // Creazione campi dal template
        $this->createFieldsFromTemplate($form, $template);
        
        return $form;
    }
}
```

## Filament Integration

### 1. FormResource
```php
class FormResource extends XotBaseResource
{
    protected static ?string $model = Form::class;
    protected static ?string $navigationGroup = "FormBuilder";
    
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            'description' => Forms\Components\Textarea::make('description')
                ->maxLength(1000),
            'template_id' => Forms\Components\Select::make('template_id')
                ->options(FormTemplate::pluck('name', 'id'))
                ->searchable(),
            'is_active' => Forms\Components\Toggle::make('is_active')
                ->default(true),
        ];
    }
}
```

### 2. FormFieldResource
```php
class FormFieldResource extends XotBaseResource
{
    protected static ?string $model = FormField::class;
    protected static ?string $navigationGroup = "FormBuilder";
    
    public static function getFormSchema(): array
    {
        return [
            'form_id' => Forms\Components\Select::make('form_id')
                ->options(Form::pluck('name', 'id'))
                ->required(),
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            'type' => Forms\Components\Select::make('type')
                ->options(FieldTypeEnum::toArray())
                ->required(),
            'label' => Forms\Components\TextInput::make('label')
                ->required()
                ->maxLength(255),
            'required' => Forms\Components\Toggle::make('required')
                ->default(false),
            'validation_rules' => Forms\Components\KeyValue::make('validation_rules'),
            'options' => Forms\Components\KeyValue::make('options'),
            'order' => Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0),
        ];
    }
}
```

## Enums Implementation

### 1. FieldTypeEnum
```php
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
        };
    }
}
```

### 2. FormStatusEnum
```php
enum FormStatusEnum: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case ARCHIVED = 'archived';
    
    public function getColor(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::ACTIVE => 'success',
            self::INACTIVE => 'warning',
            self::ARCHIVED => 'danger',
        };
    }
}
```

## Database Schema

### 1. Forms Table
```sql
CREATE TABLE forms (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    template_id BIGINT UNSIGNED NULL,
    is_active BOOLEAN DEFAULT TRUE,
    settings JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (template_id) REFERENCES form_templates(id)
        ON DELETE SET NULL
);
```

### 2. Form Fields Table
```sql
CREATE TABLE form_fields (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    form_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    label VARCHAR(255) NOT NULL,
    required BOOLEAN DEFAULT FALSE,
    validation_rules JSON NULL,
    options JSON NULL,
    order INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (form_id) REFERENCES forms(id)
        ON DELETE CASCADE
);
```

### 3. Form Templates Table
```sql
CREATE TABLE form_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    category VARCHAR(100) NULL,
    fields_config JSON NOT NULL,
    is_system BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## Best Practices

### 1. Type Safety
- **Sempre** usare tipizzazione rigorosa
- **Sempre** definire interfacce per services
- **Sempre** usare enum per valori fissi
- **Mai** usare mixed senza documentazione

### 2. Error Handling
- **Sempre** gestire eccezioni specifiche
- **Sempre** validare input
- **Sempre** loggare errori critici
- **Mai** esporre dettagli interni

### 3. Performance
- **Sempre** usare eager loading per relazioni
- **Sempre** implementare caching per template
- **Sempre** ottimizzare query database
- **Mai** caricare dati non necessari

### 4. Security
- **Sempre** sanitizzare input utente
- **Sempre** validare file upload
- **Sempre** implementare CSRF protection
- **Mai** fidarsi di input non validato

## Collegamenti Correlati

### Documentazione Moduli
- [Form Implementation](form-implementation.md) - Implementazione dettagliata form
- [Field Management](field-management.md) - Gestione campi form
- [Template System](template-system.md) - Sistema template
- [Validation System](validation-system.md) - Sistema validazione

### Documentazione Generale
- [Laraxot Architecture](../../Xot/docs/architecture.md) - Architettura Laraxot
- [Filament Best Practices](../../Xot/docs/filament-best-practices.md) - Best practices Filament
- [PHPStan Guidelines](../../../docs/phpstan_usage.md) - Linee guida PHPStan

---

**Ultimo aggiornamento**: 2025-01-06
**Autore**: Sistema di correzione automatica
**Stato**: ✅ Completato