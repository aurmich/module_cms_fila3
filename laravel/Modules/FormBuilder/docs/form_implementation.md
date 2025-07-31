# Implementazione Form - Modulo FormBuilder

## Data: 2025-01-06

## Panoramica

L'implementazione dei form nel modulo FormBuilder segue un pattern architetturale robusto che garantisce flessibilità, riutilizzabilità e manutenibilità del codice.

## Modello Form

### 1. Form Model Base
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FormBuilder\Enums\FormStatusEnum;
use Modules\Xot\Models\XotBaseModel;

class Form extends XotBaseModel
{
    protected $fillable = [
        'name',
        'description',
        'template_id',
        'status',
        'is_active',
        'settings',
        'created_by',
        'updated_by',
    ];
    
    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'status' => FormStatusEnum::class,
    ];
    
    // Relationships
    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class)->orderBy('order');
    }
    
    public function template(): BelongsTo
    {
        return $this->belongsTo(FormTemplate::class);
    }
    
    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeByStatus($query, FormStatusEnum $status)
    {
        return $query->where('status', $status);
    }
    
    // Accessors
    public function getFieldsCountAttribute(): int
    {
        return $this->fields()->count();
    }
    
    public function getSubmissionsCountAttribute(): int
    {
        return $this->submissions()->count();
    }
    
    // Methods
    public function isActive(): bool
    {
        return $this->is_active && $this->status === FormStatusEnum::ACTIVE;
    }
    
    public function canBeSubmitted(): bool
    {
        return $this->isActive() && $this->fields()->count() > 0;
    }
    
    public function getValidationRules(): array
    {
        return $this->fields->mapWithKeys(function ($field) {
            return [$field->name => $field->getValidationRules()];
        })->toArray();
    }
}
```

### 2. FormField Model
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FormBuilder\Enums\FieldTypeEnum;
use Modules\Xot\Models\XotBaseModel;

class FormField extends XotBaseModel
{
    protected $fillable = [
        'form_id',
        'name',
        'type',
        'label',
        'placeholder',
        'help_text',
        'required',
        'validation_rules',
        'options',
        'order',
        'is_visible',
        'default_value',
    ];
    
    protected $casts = [
        'required' => 'boolean',
        'is_visible' => 'boolean',
        'validation_rules' => 'array',
        'options' => 'array',
    ];
    
    // Relationships
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
    
    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
    
    public function scopeRequired($query)
    {
        return $query->where('required', true);
    }
    
    public function scopeByType($query, FieldTypeEnum $type)
    {
        return $query->where('type', $type);
    }
    
    // Methods
    public function getValidationRules(): array
    {
        $rules = $this->validation_rules ?? [];
        
        if ($this->required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }
        
        // Add type-specific rules
        $rules = array_merge($rules, $this->getTypeSpecificRules());
        
        return $rules;
    }
    
    private function getTypeSpecificRules(): array
    {
        return match($this->type) {
            FieldTypeEnum::EMAIL => ['email'],
            FieldTypeEnum::URL => ['url'],
            FieldTypeEnum::NUMBER => ['numeric'],
            FieldTypeEnum::DATE => ['date'],
            FieldTypeEnum::DATETIME => ['date'],
            FieldTypeEnum::FILE => ['file'],
            default => [],
        };
    }
    
    public function getOptions(): array
    {
        return $this->options ?? [];
    }
    
    public function hasOptions(): bool
    {
        return !empty($this->options);
    }
    
    public function isSelectType(): bool
    {
        return in_array($this->type, [
            FieldTypeEnum::SELECT,
            FieldTypeEnum::RADIO,
            FieldTypeEnum::CHECKBOX,
        ]);
    }
}
```

### 3. FormTemplate Model
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Xot\Models\XotBaseModel;

class FormTemplate extends XotBaseModel
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'fields_config',
        'is_system',
        'version',
        'created_by',
    ];
    
    protected $casts = [
        'fields_config' => 'array',
        'is_system' => 'boolean',
    ];
    
    // Relationships
    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }
    
    // Scopes
    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }
    
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
    
    // Methods
    public function getFieldsConfig(): array
    {
        return $this->fields_config ?? [];
    }
    
    public function applyToForm(Form $form): Form
    {
        $form->template()->associate($this);
        $form->save();
        
        // Create fields from template
        foreach ($this->getFieldsConfig() as $fieldConfig) {
            $form->fields()->create($fieldConfig);
        }
        
        return $form;
    }
}
```

## Service Implementation

### 1. FormBuilderService
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Services;

use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\Models\FormField;
use Modules\FormBuilder\Contracts\FormRepositoryInterface;
use Modules\FormBuilder\Exceptions\FormCreationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormBuilderService
{
    public function __construct(
        private FormRepositoryInterface $formRepository,
        private ValidationService $validationService,
        private TemplateService $templateService
    ) {}
    
    public function createForm(array $data): Form
    {
        // Validate input data
        $this->validateFormData($data);
        
        try {
            DB::beginTransaction();
            
            // Create form
            $form = $this->formRepository->create($data);
            
            // Create fields if provided
            if (isset($data['fields']) && is_array($data['fields'])) {
                $this->createFields($form, $data['fields']);
            }
            
            // Apply template if specified
            if (isset($data['template_id'])) {
                $template = $this->templateService->findById($data['template_id']);
                if ($template) {
                    $template->applyToForm($form);
                }
            }
            
            DB::commit();
            
            return $form->load('fields');
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw new FormCreationException(
                "Failed to create form: {$e->getMessage()}"
            );
        }
    }
    
    public function updateForm(Form $form, array $data): Form
    {
        // Validate input data
        $this->validateFormData($data, $form->id);
        
        try {
            DB::beginTransaction();
            
            // Update form
            $form = $this->formRepository->update($form, $data);
            
            // Update fields if provided
            if (isset($data['fields']) && is_array($data['fields'])) {
                $this->updateFields($form, $data['fields']);
            }
            
            DB::commit();
            
            return $form->load('fields');
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw new FormCreationException(
                "Failed to update form: {$e->getMessage()}"
            );
        }
    }
    
    public function deleteForm(Form $form): bool
    {
        try {
            DB::beginTransaction();
            
            // Delete form (cascade will handle fields)
            $deleted = $this->formRepository->delete($form);
            
            DB::commit();
            
            return $deleted;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw new FormCreationException(
                "Failed to delete form: {$e->getMessage()}"
            );
        }
    }
    
    private function validateFormData(array $data, ?int $formId = null): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'template_id' => 'nullable|exists:form_templates,id',
            'is_active' => 'boolean',
            'status' => 'nullable|string|in:' . implode(',', FormStatusEnum::values()),
        ];
        
        if ($formId) {
            $rules['name'] .= "|unique:forms,name,{$formId}";
        } else {
            $rules['name'] .= '|unique:forms,name';
        }
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            throw new FormCreationException(
                'Form data validation failed: ' . $validator->errors()->first()
            );
        }
    }
    
    private function createFields(Form $form, array $fields): void
    {
        foreach ($fields as $index => $fieldData) {
            $fieldData['form_id'] = $form->id;
            $fieldData['order'] = $fieldData['order'] ?? $index;
            
            $this->validateFieldData($fieldData);
            
            $form->fields()->create($fieldData);
        }
    }
    
    private function updateFields(Form $form, array $fields): void
    {
        // Delete existing fields
        $form->fields()->delete();
        
        // Create new fields
        $this->createFields($form, $fields);
    }
    
    private function validateFieldData(array $data): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', FieldTypeEnum::values()),
            'label' => 'required|string|max:255',
            'placeholder' => 'nullable|string|max:255',
            'help_text' => 'nullable|string|max:500',
            'required' => 'boolean',
            'is_visible' => 'boolean',
            'order' => 'integer|min:0',
            'validation_rules' => 'nullable|array',
            'options' => 'nullable|array',
            'default_value' => 'nullable|string',
        ];
        
        $validator = Validator::make($data, $rules);
        
        if ($validator->fails()) {
            throw new FormCreationException(
                'Field data validation failed: ' . $validator->errors()->first()
            );
        }
    }
}
```

### 2. ValidationService
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Services;

use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\DataTransferObjects\ValidationResult;
use Illuminate\Support\Facades\Validator;

class ValidationService
{
    public function validate(Form $form, array $data): ValidationResult
    {
        $rules = $this->buildValidationRules($form);
        $messages = $this->buildValidationMessages($form);
        
        $validator = Validator::make($data, $rules, $messages);
        
        return new ValidationResult($validator);
    }
    
    private function buildValidationRules(Form $form): array
    {
        return $form->fields->mapWithKeys(function ($field) {
            return [$field->name => $field->getValidationRules()];
        })->toArray();
    }
    
    private function buildValidationMessages(Form $form): array
    {
        return $form->fields->mapWithKeys(function ($field) {
            return [
                "{$field->name}.required" => "Il campo {$field->label} è obbligatorio.",
                "{$field->name}.email" => "Il campo {$field->label} deve essere un indirizzo email valido.",
                "{$field->name}.url" => "Il campo {$field->label} deve essere un URL valido.",
                "{$field->name}.numeric" => "Il campo {$field->label} deve essere numerico.",
                "{$field->name}.date" => "Il campo {$field->label} deve essere una data valida.",
                "{$field->name}.file" => "Il campo {$field->label} deve essere un file.",
            ];
        })->toArray();
    }
}
```

### 3. TemplateService
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Services;

use Modules\FormBuilder\Models\FormTemplate;
use Modules\FormBuilder\Contracts\TemplateRepositoryInterface;
use Modules\FormBuilder\Exceptions\TemplateNotFoundException;

class TemplateService
{
    public function __construct(
        private TemplateRepositoryInterface $templateRepository
    ) {}
    
    public function createTemplate(array $data): FormTemplate
    {
        $this->validateTemplateData($data);
        
        return $this->templateRepository->create($data);
    }
    
    public function findById(int $id): ?FormTemplate
    {
        return $this->templateRepository->findById($id);
    }
    
    public function findByCategory(string $category): \Illuminate\Database\Eloquent\Collection
    {
        return $this->templateRepository->findByCategory($category);
    }
    
    public function getSystemTemplates(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->templateRepository->getSystemTemplates();
    }
    
    private function validateTemplateData(array $data): void
    {
        $rules = [
            'name' => 'required|string|max:255|unique:form_templates,name',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:100',
            'fields_config' => 'required|array',
            'is_system' => 'boolean',
        ];
        
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        
        if ($validator->fails()) {
            throw new \InvalidArgumentException(
                'Template data validation failed: ' . $validator->errors()->first()
            );
        }
    }
}
```

## Data Transfer Objects

### 1. ValidationResult
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\DataTransferObjects;

use Illuminate\Validation\Validator;

class ValidationResult
{
    public function __construct(
        private Validator $validator
    ) {}
    
    public function passes(): bool
    {
        return !$this->validator->fails();
    }
    
    public function fails(): bool
    {
        return $this->validator->fails();
    }
    
    public function errors(): array
    {
        return $this->validator->errors()->toArray();
    }
    
    public function getFirstError(): ?string
    {
        return $this->validator->errors()->first();
    }
    
    public function getValidator(): Validator
    {
        return $this->validator;
    }
}
```

## Exceptions

### 1. FormCreationException
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Exceptions;

use Exception;

class FormCreationException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
```

### 2. TemplateNotFoundException
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Exceptions;

use Exception;

class TemplateNotFoundException extends Exception
{
    public function __construct(string $templateName)
    {
        parent::__construct("Template '{$templateName}' not found.");
    }
}
```

## Usage Examples

### 1. Creating a Form
```php
use Modules\FormBuilder\Services\FormBuilderService;

$formBuilder = app(FormBuilderService::class);

$form = $formBuilder->createForm([
    'name' => 'Patient Registration',
    'description' => 'Form for patient registration',
    'is_active' => true,
    'status' => FormStatusEnum::ACTIVE,
    'fields' => [
        [
            'name' => 'first_name',
            'type' => FieldTypeEnum::TEXT,
            'label' => 'First Name',
            'required' => true,
            'order' => 1,
        ],
        [
            'name' => 'last_name',
            'type' => FieldTypeEnum::TEXT,
            'label' => 'Last Name',
            'required' => true,
            'order' => 2,
        ],
        [
            'name' => 'email',
            'type' => FieldTypeEnum::EMAIL,
            'label' => 'Email Address',
            'required' => true,
            'order' => 3,
        ],
        [
            'name' => 'phone',
            'type' => FieldTypeEnum::TEL,
            'label' => 'Phone Number',
            'required' => false,
            'order' => 4,
        ],
    ]
]);
```

### 2. Validating Form Data
```php
use Modules\FormBuilder\Services\ValidationService;

$validationService = app(ValidationService::class);

$data = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
    'phone' => '+1234567890',
];

$result = $validationService->validate($form, $data);

if ($result->passes()) {
    // Process form submission
    $form->submissions()->create($data);
} else {
    // Handle validation errors
    $errors = $result->errors();
}
```

### 3. Using Templates
```php
use Modules\FormBuilder\Services\TemplateService;

$templateService = app(TemplateService::class);

// Create template
$template = $templateService->createTemplate([
    'name' => 'Medical Form Template',
    'description' => 'Standard medical form template',
    'category' => 'medical',
    'fields_config' => [
        [
            'name' => 'symptoms',
            'type' => FieldTypeEnum::TEXTAREA,
            'label' => 'Symptoms',
            'required' => true,
            'order' => 1,
        ],
        [
            'name' => 'allergies',
            'type' => FieldTypeEnum::TEXT,
            'label' => 'Allergies',
            'required' => false,
            'order' => 2,
        ],
        [
            'name' => 'medications',
            'type' => FieldTypeEnum::TEXT,
            'label' => 'Current Medications',
            'required' => false,
            'order' => 3,
        ],
    ]
]);

// Apply template to form
$form = $template->applyToForm($form);
```

## Best Practices

### 1. Form Creation
- **Sempre** validare input prima della creazione
- **Sempre** usare transazioni database per operazioni complesse
- **Sempre** gestire eccezioni specifiche
- **Mai** creare form senza validazione

### 2. Field Management
- **Sempre** definire regole di validazione per ogni campo
- **Sempre** usare enum per tipi campo
- **Sempre** implementare ordinamento campi
- **Mai** permettere campi senza tipo definito

### 3. Template Usage
- **Sempre** creare template per form riutilizzabili
- **Sempre** categorizzare template
- **Sempre** versionare template
- **Mai** modificare template di sistema

### 4. Validation
- **Sempre** validare lato server
- **Sempre** fornire messaggi di errore chiari
- **Sempre** sanitizzare input
- **Mai** fidarsi di validazione solo lato client

## Collegamenti Correlati

### Documentazione Moduli
- [Field Management](field-management.md) - Gestione dettagliata campi
- [Template System](template-system.md) - Sistema template
- [Validation System](validation-system.md) - Sistema validazione
- [Architecture](architecture.md) - Architettura modulo

### Documentazione Generale
- [Laraxot Models](../../Xot/docs/models.md) - Modelli Laraxot
- [Filament Resources](../../Xot/docs/filament-resources.md) - Risorse Filament
- [PHPStan Guidelines](../../../docs/phpstan_usage.md) - Linee guida PHPStan

---

**Ultimo aggiornamento**: 2025-01-06
**Autore**: Sistema di correzione automatica
**Stato**: ✅ Completato