# FormBuilder - Services Layer

## Introduzione

Il layer Services del modulo FormBuilder implementa la logica di business seguendo il Service Pattern, una delle best practice architetturali identificate negli altri moduli del progetto SaluteOra.

## Architettura Services

### Principi di Design

1. **Single Responsibility**: Ogni service ha una responsabilità specifica
2. **Dependency Injection**: Utilizzo del container Laravel per le dipendenze
3. **Interface Segregation**: Interfacce specifiche per ogni service
4. **Type Safety**: Tipizzazione rigorosa con PHPStan level 9+

## Services Principali

### 1. FormBuilderService

Service principale per la creazione e gestione dei form dinamici.

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Services;

use Modules\FormBuilder\Data\FormData;
use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\Contracts\FormBuilderServiceInterface;

/**
 * Service for form building operations.
 */
class FormBuilderService implements FormBuilderServiceInterface
{
    /**
     * Create a new form.
     *
     * @param FormData $data
     * @return Form
     */
    public function createForm(FormData $data): Form
    {
        // Implementation
    }

    /**
     * Update an existing form.
     *
     * @param Form $form
     * @param FormData $data
     * @return Form
     */
    public function updateForm(Form $form, FormData $data): Form
    {
        // Implementation
    }

    /**
     * Delete a form.
     *
     * @param Form $form
     * @return bool
     */
    public function deleteForm(Form $form): bool
    {
        // Implementation
    }
}
```

**Responsabilità**:

- Creazione di form dinamici
- Aggiornamento configurazioni form
- Gestione lifecycle dei form
- Validazione struttura form

### 2. ValidationService

Service per la gestione della validazione dinamica dei form.

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Services;

use Modules\FormBuilder\Data\ValidationRuleData;
use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\Contracts\ValidationServiceInterface;

/**
 * Service for dynamic form validation.
 */
class ValidationService implements ValidationServiceInterface
{
    /**
     * Validate form data against form configuration.
     *
     * @param Form $form
     * @param array<string, mixed> $data
     * @return array<string, list<string>>
     */
    public function validateFormData(Form $form, array $data): array
    {
        // Implementation
    }

    /**
     * Get validation rules for a form.
     *
     * @param Form $form
     * @return array<string, list<string>>
     */
    public function getValidationRules(Form $form): array
    {
        // Implementation
    }

    /**
     * Add custom validation rule.
     *
     * @param ValidationRuleData $rule
     * @return void
     */
    public function addCustomRule(ValidationRuleData $rule): void
    {
        // Implementation
    }
}
```

**Responsabilità**:

- Validazione dinamica dei dati form
- Gestione regole di validazione custom
- Sanitizzazione input
- Generazione messaggi di errore

### 3. TemplateService

Service per la gestione dei template form riutilizzabili.

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Services;

use Modules\FormBuilder\Data\TemplateData;
use Modules\FormBuilder\Models\FormTemplate;
use Modules\FormBuilder\Contracts\TemplateServiceInterface;

/**
 * Service for form template management.
 */
class TemplateService implements TemplateServiceInterface
{
    /**
     * Create a new template.
     *
     * @param TemplateData $data
     * @return FormTemplate
     */
    public function createTemplate(TemplateData $data): FormTemplate
    {
        // Implementation
    }

    /**
     * Apply template to form.
     *
     * @param FormTemplate $template
     * @param Form $form
     * @return Form
     */
    public function applyTemplate(FormTemplate $template, Form $form): Form
    {
        // Implementation
    }

    /**
     * Get available templates.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, FormTemplate>
     */
    public function getAvailableTemplates(): Collection
    {
        // Implementation
    }
}
```

**Responsabilità**:
- Creazione template riutilizzabili
- Applicazione template a form esistenti
- Gestione libreria template
- Versionamento template

### 4. SubmissionService

Service per la gestione delle submission dei form.

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Services;

use Modules\FormBuilder\Data\SubmissionData;
use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\Models\FormSubmission;
use Modules\FormBuilder\Contracts\SubmissionServiceInterface;

/**
 * Service for form submission management.
 */
class SubmissionService implements SubmissionServiceInterface
{
    /**
     * Process form submission.
     *
     * @param Form $form
     * @param SubmissionData $data
     * @return FormSubmission
     */
    public function processSubmission(Form $form, SubmissionData $data): FormSubmission
    {
        // Implementation
    }

    /**
     * Get submissions for a form.
     *
     * @param Form $form
     * @return \Illuminate\Database\Eloquent\Collection<int, FormSubmission>
     */
    public function getSubmissions(Form $form): Collection
    {
        // Implementation
    }

    /**
     * Export submissions to CSV.
     *
     * @param Form $form
     * @return string
     */
    public function exportToCsv(Form $form): string
    {
        // Implementation
    }
}
```

**Responsabilità**:
- Elaborazione submission form
- Archiviazione dati submission
- Export dati in vari formati
- Analisi statistiche submission

## Contracts (Interfacce)

### Struttura delle Interfacce

Ogni service implementa un'interfaccia specifica per garantire la testabilità e la flessibilità:

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Contracts;

use Modules\FormBuilder\Data\FormData;
use Modules\FormBuilder\Models\Form;

/**
 * Interface for form builder service.
 */
interface FormBuilderServiceInterface
{
    /**
     * Create a new form.
     *
     * @param FormData $data
     * @return Form
     */
    public function createForm(FormData $data): Form;

    /**
     * Update an existing form.
     *
     * @param Form $form
     * @param FormData $data
     * @return Form
     */
    public function updateForm(Form $form, FormData $data): Form;

    /**
     * Delete a form.
     *
     * @param Form $form
     * @return bool
     */
    public function deleteForm(Form $form): bool;
}
```

## Registrazione Services

### ServiceProvider Registration

I services vengono registrati nel `FormBuilderServiceProvider`:

```php
/**
 * Register the service provider.
 */
public function register(): void
{
    parent::register();

    // Bind interfaces to implementations
    $this->app->bind(
        FormBuilderServiceInterface::class,
        FormBuilderService::class
    );

    $this->app->bind(
        ValidationServiceInterface::class,
        ValidationService::class
    );

    $this->app->bind(
        TemplateServiceInterface::class,
        TemplateService::class
    );

    $this->app->bind(
        SubmissionServiceInterface::class,
        SubmissionService::class
    );
}
```

## Utilizzo nei Controller

### Dependency Injection

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Http\Controllers;

use Modules\FormBuilder\Contracts\FormBuilderServiceInterface;
use Modules\FormBuilder\Data\FormData;
use Illuminate\Http\JsonResponse;

class FormController extends Controller
{
    public function __construct(
        private readonly FormBuilderServiceInterface $formBuilderService
    ) {
    }

    /**
     * Create a new form.
     *
     * @param FormData $data
     * @return JsonResponse
     */
    public function store(FormData $data): JsonResponse
    {
        $form = $this->formBuilderService->createForm($data);

        return response()->json([
            'success' => true,
            'data' => $form,
            'message' => 'Form created successfully',
        ]);
    }
}
```

## Testing

### Unit Testing dei Services

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Tests\Unit\Services;

use Tests\TestCase;
use Modules\FormBuilder\Services\FormBuilderService;
use Modules\FormBuilder\Data\FormData;

class FormBuilderServiceTest extends TestCase
{
    private FormBuilderService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(FormBuilderService::class);
    }

    /** @test */
    public function it_can_create_a_form(): void
    {
        $data = new FormData(
            name: 'Test Form',
            description: 'A test form',
            fields: []
        );

        $form = $this->service->createForm($data);

        $this->assertInstanceOf(Form::class, $form);
        $this->assertEquals('Test Form', $form->name);
    }
}
```

## Best Practices

### 1. Error Handling
- Utilizzo di custom exceptions
- Logging degli errori
- Messaggi di errore user-friendly

### 2. Performance
- Caching delle configurazioni
- Lazy loading delle relazioni
- Batch processing quando possibile

### 3. Security
- Validazione rigorosa degli input
- Sanitizzazione dei dati
- Controllo permessi per ogni operazione

## Collegamenti Correlati

- [Architecture Overview](../architecture/overview.md)
- [Model Design Patterns](../models/design-patterns.md)
- [Data Objects](../data/README.md)
- [API Documentation](../api/README.md)

---

**Ultimo aggiornamento**: 2025-07-29
**Autore**: Sistema di correzione automatica
**Stato**: ✅ Completato
