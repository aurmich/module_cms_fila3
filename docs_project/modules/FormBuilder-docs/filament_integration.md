# Integrazione Filament - Modulo FormBuilder

## Data: 2025-01-06

## Panoramica

L'integrazione Filament del modulo FormBuilder fornisce un'interfaccia amministrativa completa per la gestione di form dinamici, campi e template, seguendo le best practices Laraxot.

## Provider Filament

### AdminPanelProvider

Il modulo FormBuilder include un provider Filament dedicato per la configurazione del panel amministrativo:

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers\Filament;

use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

/**
 * Admin Panel Provider per il modulo FormBuilder.
 *
 * Gestisce la configurazione del panel Filament per il modulo FormBuilder,
 * estendendo XotBasePanelProvider per garantire coerenza e funzionalità standard.
 */
class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'FormBuilder';

    /**
     * Configura il panel Filament per il modulo FormBuilder.
     *
     * @param \Filament\Panel $panel
     * @return \Filament\Panel
     */
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        // Configurazioni specifiche del modulo FormBuilder
        // Qui possono essere aggiunte configurazioni specifiche per form builder
        // come plugin, widget, o altre personalizzazioni

        return $panel;
    }
}
```

### Registrazione Provider

Il provider è registrato nei file di configurazione del modulo:

**module.json:**
```json
{
    "name": "FormBuilder",
    "alias": "formbuilder",
    "description": "Modulo per la gestione dinamica di form personalizzabili con integrazione Filament",
    "keywords": ["forms", "form-builder", "dynamic-forms", "filament", "validation"],
    "priority": 0,
    "providers": [
        "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider",
        "Modules\\FormBuilder\\Providers\\Filament\\AdminPanelProvider"
    ],
    "files": []
}
```

**composer.json:**
```json
{
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider",
                "Modules\\FormBuilder\\Providers\\Filament\\AdminPanelProvider"
            ],
            "aliases": {}
        }
    }
}
```

## Dashboard

### Dashboard Principale
La dashboard del modulo FormBuilder deve estendere `XotBaseDashboard` e fornire una panoramica completa delle statistiche dei form.

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'FormBuilder';
    protected static ?int $navigationSort = 1;

    /**
     * Ottiene i widget da visualizzare nella dashboard.
     * 
     * @return array<class-string<Widget>|WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        return [
            // Widget statistiche principali
            Widgets\FormStatsWidget::class,
            Widgets\RecentSubmissionsWidget::class,
            
            // Widget grafici
            Widgets\FormSubmissionsChartWidget::make(['chart_id' => 'submissions_chart']),
            Widgets\FormFieldsDistributionWidget::make(['chart_id' => 'fields_distribution']),
            
            // Widget template
            Widgets\PopularTemplatesWidget::class,
            Widgets\TemplateUsageWidget::class,
        ];
    }

    /**
     * Configura il form dei filtri per la dashboard.
     * 
     * @param Form $form
     * @return Form
     */
    public function getFiltersFormSchema(): array
    {
        return [
            DatePicker::make('startDate')
                ->label('Data Inizio')
                ->native(false)
                ->maxDate(fn (Get $get) => $get('endDate') ?: now())
                ->placeholder('Seleziona data inizio'),
                
            DatePicker::make('endDate')
                ->label('Data Fine')
                ->native(false)
                ->minDate(fn (Get $get) => $get('startDate') ?: now())
                ->maxDate(now())
                ->placeholder('Seleziona data fine'),
                
            Select::make('formStatus')
                ->label('Stato Form')
                ->options([
                    'all' => 'Tutti gli stati',
                    'active' => 'Attivi',
                    'inactive' => 'Inattivi',
                    'draft' => 'Bozza',
                    'archived' => 'Archiviati',
                ])
                ->default('all'),
                
            Select::make('formCategory')
                ->label('Categoria Form')
                ->options([
                    'all' => 'Tutte le categorie',
                    'medical' => 'Medico',
                    'registration' => 'Registrazione',
                    'contact' => 'Contatto',
                    'feedback' => 'Feedback',
                    'survey' => 'Sondaggio',
                    'appointment' => 'Appuntamento',
                    'consent' => 'Consenso',
                    'custom' => 'Personalizzato',
                ])
                ->default('all'),
        ];
    }

    /**
     * Ottiene il titolo della pagina.
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return __('formbuilder::dashboard.title');
    }

    /**
     * Ottiene la descrizione della pagina.
     * 
     * @return string
     */
    public function getDescription(): string
    {
        return __('formbuilder::dashboard.description');
    }
}
```

### Caratteristiche Dashboard
- **Filtri Temporali**: Filtra i dati per periodo specifico
- **Filtri Form**: Filtra per stato e categoria form
- **Widget Statistiche**: Mostra metriche principali
- **Widget Grafici**: Visualizza trend e distribuzioni
- **Widget Template**: Mostra template più utilizzati
- **Widget Submission**: Visualizza submission recenti

### Traduzioni Richieste
```php
// Modules/FormBuilder/resources/lang/it/dashboard.php
return [
    'title' => 'Dashboard FormBuilder',
    'description' => 'Panoramica completa dei form, template e submission',
    'filters' => [
        'start_date' => 'Data Inizio',
        'end_date' => 'Data Fine',
        'form_status' => 'Stato Form',
        'form_category' => 'Categoria Form',
    ],
    'stats' => [
        'total_forms' => 'Form Totali',
        'active_forms' => 'Form Attivi',
        'total_submissions' => 'Submission Totali',
        'total_templates' => 'Template Totali',
    ],
];
```

## Dashboard del Modulo

La pagina dashboard del modulo **deve estendere** `Modules\Xot\Filament\Pages\XotBaseDashboard` e **non** `XotBasePage`.

### Pattern corretto
```php
namespace Modules\FormBuilder\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    // Definisci i widget, i filtri e le azioni secondo la documentazione XotBaseDashboard
}
```

- I filtri vanno definiti tramite `getFiltersFormSchema()`
- I widget vanno restituiti da `getWidgets()`
- Le azioni header/footer sono opzionali e vanno definite secondo le policy
- La view custom (se serve) va in `resources/views/filament/pages/dashboard.blade.php`

### Note
- Segui sempre la documentazione e i commenti di XotBaseDashboard
- Consulta anche la documentazione in `docs/roadmap/ui/dashboard.md` per pattern UI/UX
- Aggiorna questa sezione se cambiano le regole di XotBaseDashboard

---

**Ultimo aggiornamento**: 2025-01-06
**Nota**: La dashboard deve sempre estendere XotBaseDashboard per coerenza architetturale.

## Risorse Filament

### 1. FormResource
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Tables\Table;
use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\Models\FormTemplate;
use Modules\FormBuilder\Enums\FormStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\FormBuilder\Filament\Resources\FormResource\Pages;

class FormResource extends XotBaseResource
{
    protected static ?string $model = Form::class;
    protected static ?string $navigationGroup = "FormBuilder";
    protected static ?int $navigationSort = 1;

    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            'description' => Forms\Components\Textarea::make('description')
                ->maxLength(1000)
                ->columnSpanFull(),

            'template_id' => Forms\Components\Select::make('template_id')
                ->label('Template')
                ->options(FormTemplate::pluck('name', 'id'))
                ->searchable()
                ->placeholder('Select a template (optional)')
                ->columnSpan(2),

            'status' => Forms\Components\Select::make('status')
                ->options(FormStatusEnum::class)
                ->default(FormStatusEnum::DRAFT)
                ->required(),

            'is_active' => Forms\Components\Toggle::make('is_active')
                ->default(true)
                ->label('Active'),

            'settings' => Forms\Components\KeyValue::make('settings')
                ->label('Additional Settings')
                ->columnSpanFull(),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),

            'description' => Tables\Columns\TextColumn::make('description')
                ->limit(50)
                ->searchable(),

            'status' => Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (FormStatusEnum $state): string => match ($state) {
                    FormStatusEnum::DRAFT => 'gray',
                    FormStatusEnum::ACTIVE => 'success',
                    FormStatusEnum::INACTIVE => 'warning',
                    FormStatusEnum::ARCHIVED => 'danger',
                }),

            'is_active' => Tables\Columns\IconColumn::make('is_active')
                ->boolean()
                ->label('Active'),

            'fields_count' => Tables\Columns\TextColumn::make('fields_count')
                ->label('Fields')
                ->counts('fields')
                ->sortable(),

            'submissions_count' => Tables\Columns\TextColumn::make('submissions_count')
                ->label('Submissions')
                ->counts('submissions')
                ->sortable(),

            'template' => Tables\Columns\TextColumn::make('template.name')
                ->label('Template')
                ->sortable(),

            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getTableFilters(): array
    {
        return [
            'status' => Tables\Filters\SelectFilter::make('status')
                ->options(FormStatusEnum::class),

            'is_active' => Tables\Filters\TernaryFilter::make('is_active')
                ->label('Active'),

            'template' => Tables\Filters\SelectFilter::make('template_id')
                ->label('Template')
                ->options(FormTemplate::pluck('name', 'id')),

            'created_at' => Tables\Filters\Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from'),
                    Forms\Components\DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),
        ];
    }

    public static function getTableActions(): array
    {
        return [
            'edit' => Tables\Actions\EditAction::make(),
            'view' => Tables\Actions\ViewAction::make(),
            'delete' => Tables\Actions\DeleteAction::make(),

            'manage_fields' => Tables\Actions\Action::make('manage_fields')
                ->label('Manage Fields')
                ->icon('heroicon-o-cog-6-tooth')
                ->url(fn (Form $record): string => route('filament.admin.resources.forms.fields.index', $record))
                ->openUrlInNewTab(),

            'preview' => Tables\Actions\Action::make('preview')
                ->label('Preview Form')
                ->icon('heroicon-o-eye')
                ->url(fn (Form $record): string => route('forms.preview', $record))
                ->openUrlInNewTab()
                ->visible(fn (Form $record): bool => $record->isActive()),
        ];
    }

    public static function getTableBulkActions(): array
    {
        return [
            'bulk_activate' => Tables\Actions\BulkAction::make('activate')
                ->label('Activate Selected')
                ->icon('heroicon-o-check-circle')
                ->action(function (Collection $records): void {
                    $records->each(function ($record) {
                        $record->update([
                            'status' => FormStatusEnum::ACTIVE,
                            'is_active' => true,
                        ]);
                    });
                })
                ->requiresConfirmation(),

            'bulk_deactivate' => Tables\Actions\BulkAction::make('deactivate')
                ->label('Deactivate Selected')
                ->icon('heroicon-o-x-circle')
                ->action(function (Collection $records): void {
                    $records->each(function ($record) {
                        $record->update([
                            'status' => FormStatusEnum::INACTIVE,
                            'is_active' => false,
                        ]);
                    });
                })
                ->requiresConfirmation(),
        ];
    }
}
```

### 2. FormFieldResource
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Tables\Table;
use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\Models\FormField;
use Modules\FormBuilder\Enums\FieldTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\FormBuilder\Filament\Resources\FormFieldResource\Pages;

class FormFieldResource extends XotBaseResource
{
    protected static ?string $model = FormField::class;
    protected static ?string $navigationGroup = "FormBuilder";
    protected static ?int $navigationSort = 2;

    public static function getFormSchema(): array
    {
        return [
            'form_id' => Forms\Components\Select::make('form_id')
                ->label('Form')
                ->options(Form::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn (Set $set) => $set('name', null)),

            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->live()
                ->afterStateUpdated(function (Set $set, Get $get) {
                    $name = $get('name');
                    if ($name && !$get('label')) {
                        $set('label', ucwords(str_replace('_', ' ', $name)));
                    }
                }),

            'type' => Forms\Components\Select::make('type')
                ->options(FieldTypeEnum::class)
                ->required()
                ->live()
                ->afterStateUpdated(function (Set $set) {
                    $set('options', []);
                    $set('validation_rules', []);
                }),

            'label' => Forms\Components\TextInput::make('label')
                ->required()
                ->maxLength(255),

            'placeholder' => Forms\Components\TextInput::make('placeholder')
                ->maxLength(255),

            'help_text' => Forms\Components\Textarea::make('help_text')
                ->maxLength(500)
                ->columnSpanFull(),

            'required' => Forms\Components\Toggle::make('required')
                ->default(false),

            'is_visible' => Forms\Components\Toggle::make('is_visible')
                ->default(true)
                ->label('Visible'),

            'order' => Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0)
                ->required(),

            'default_value' => Forms\Components\TextInput::make('default_value')
                ->maxLength(255),

            'validation_rules' => Forms\Components\KeyValue::make('validation_rules')
                ->label('Validation Rules')
                ->columnSpanFull(),

            'options' => Forms\Components\KeyValue::make('options')
                ->label('Options')
                ->visible(fn (Get $get): bool => in_array($get('type'), [
                    FieldTypeEnum::SELECT,
                    FieldTypeEnum::RADIO,
                    FieldTypeEnum::CHECKBOX,
                ]))
                ->columnSpanFull(),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            'form' => Tables\Columns\TextColumn::make('form.name')
                ->label('Form')
                ->searchable()
                ->sortable(),

            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),

            'type' => Tables\Columns\TextColumn::make('type')
                ->badge()
                ->color(fn (FieldTypeEnum $state): string => match ($state) {
                    FieldTypeEnum::TEXT => 'gray',
                    FieldTypeEnum::EMAIL => 'blue',
                    FieldTypeEnum::PASSWORD => 'red',
                    FieldTypeEnum::TEXTAREA => 'green',
                    FieldTypeEnum::SELECT => 'purple',
                    FieldTypeEnum::CHECKBOX => 'yellow',
                    FieldTypeEnum::RADIO => 'orange',
                    FieldTypeEnum::FILE => 'indigo',
                    FieldTypeEnum::DATE => 'cyan',
                    FieldTypeEnum::DATETIME => 'pink',
                    FieldTypeEnum::NUMBER => 'teal',
                    FieldTypeEnum::TEL => 'lime',
                    FieldTypeEnum::URL => 'emerald',
                }),

            'label' => Tables\Columns\TextColumn::make('label')
                ->searchable()
                ->sortable(),

            'required' => Tables\Columns\IconColumn::make('required')
                ->boolean(),

            'is_visible' => Tables\Columns\IconColumn::make('is_visible')
                ->boolean()
                ->label('Visible'),

            'order' => Tables\Columns\TextColumn::make('order')
                ->sortable(),

            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getTableFilters(): array
    {
        return [
            'form' => Tables\Filters\SelectFilter::make('form_id')
                ->label('Form')
                ->options(Form::pluck('name', 'id')),

            'type' => Tables\Filters\SelectFilter::make('type')
                ->options(FieldTypeEnum::class),

            'required' => Tables\Filters\TernaryFilter::make('required'),

            'is_visible' => Tables\Filters\TernaryFilter::make('is_visible')
                ->label('Visible'),
        ];
    }

    public static function getTableActions(): array
    {
        return [
            'edit' => Tables\Actions\EditAction::make(),
            'view' => Tables\Actions\ViewAction::make(),
            'delete' => Tables\Actions\DeleteAction::make(),

            'duplicate' => Tables\Actions\Action::make('duplicate')
                ->label('Duplicate')
                ->icon('heroicon-o-document-duplicate')
                ->action(function (FormField $record): void {
                    $newField = $record->replicate();
                    $newField->name = $newField->name . '_copy';
                    $newField->label = $newField->label . ' (Copy)';
                    $newField->save();
                })
                ->requiresConfirmation(),
        ];
    }
}
```

### 3. FormTemplateResource
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Tables\Table;
use Modules\FormBuilder\Models\FormTemplate;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\FormBuilder\Filament\Resources\FormTemplateResource\Pages;

class FormTemplateResource extends XotBaseResource
{
    protected static ?string $model = FormTemplate::class;
    protected static ?string $navigationGroup = "FormBuilder";
    protected static ?int $navigationSort = 3;

    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            'description' => Forms\Components\Textarea::make('description')
                ->maxLength(1000)
                ->columnSpanFull(),

            'category' => Forms\Components\Select::make('category')
                ->options([
                    'medical' => 'Medical',
                    'registration' => 'Registration',
                    'contact' => 'Contact',
                    'feedback' => 'Feedback',
                    'survey' => 'Survey',
                    'custom' => 'Custom',
                ])
                ->searchable()
                ->placeholder('Select category'),

            'is_system' => Forms\Components\Toggle::make('is_system')
                ->default(false)
                ->label('System Template'),

            'version' => Forms\Components\TextInput::make('version')
                ->default('1.0.0')
                ->maxLength(20),

            'fields_config' => Forms\Components\KeyValue::make('fields_config')
                ->label('Fields Configuration')
                ->columnSpanFull()
                ->help('Configure the fields for this template. Use JSON format.'),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),

            'description' => Tables\Columns\TextColumn::make('description')
                ->limit(50)
                ->searchable(),

            'category' => Tables\Columns\TextColumn::make('category')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'medical' => 'red',
                    'registration' => 'blue',
                    'contact' => 'green',
                    'feedback' => 'yellow',
                    'survey' => 'purple',
                    'custom' => 'gray',
                    default => 'gray',
                }),

            'is_system' => Tables\Columns\IconColumn::make('is_system')
                ->boolean()
                ->label('System'),

            'version' => Tables\Columns\TextColumn::make('version')
                ->sortable(),

            'forms_count' => Tables\Columns\TextColumn::make('forms_count')
                ->label('Forms')
                ->counts('forms')
                ->sortable(),

            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getTableFilters(): array
    {
        return [
            'category' => Tables\Filters\SelectFilter::make('category')
                ->options([
                    'medical' => 'Medical',
                    'registration' => 'Registration',
                    'contact' => 'Contact',
                    'feedback' => 'Feedback',
                    'survey' => 'Survey',
                    'custom' => 'Custom',
                ]),

            'is_system' => Tables\Filters\TernaryFilter::make('is_system')
                ->label('System Template'),
        ];
    }

    public static function getTableActions(): array
    {
        return [
            'edit' => Tables\Actions\EditAction::make(),
            'view' => Tables\Actions\ViewAction::make(),
            'delete' => Tables\Actions\DeleteAction::make()
                ->visible(fn (FormTemplate $record): bool => !$record->is_system),

            'apply' => Tables\Actions\Action::make('apply')
                ->label('Apply Template')
                ->icon('heroicon-o-check-circle')
                ->action(function (FormTemplate $record): void {
                    // Logic to apply template to a new form
                })
                ->requiresConfirmation(),
        ];
    }
}
```

## Widget Filament

### 1. FormBuilderWidget
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\Models\FormField;
use Modules\FormBuilder\Models\FormTemplate;
use Modules\FormBuilder\Enums\FormStatusEnum;

class FormBuilderWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Forms', Form::count())
                ->description('All forms in the system')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Active Forms', Form::where('is_active', true)->count())
                ->description('Currently active forms')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Fields', FormField::count())
                ->description('All form fields')
                ->descriptionIcon('heroicon-m-cog-6-tooth')
                ->color('info'),

            Stat::make('Templates', FormTemplate::count())
                ->description('Available templates')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('warning'),
        ];
    }
}
```

### 2. FormSubmissionsWidget
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\FormBuilder\Models\FormSubmission;
use Illuminate\Support\Carbon;

class FormSubmissionsWidget extends ChartWidget
{
    protected static ?string $heading = 'Form Submissions';

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(function ($day) {
            $date = Carbon::now()->subDays($day);
            
            return [
                'date' => $date->format('M d'),
                'submissions' => FormSubmission::whereDate('created_at', $date)->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Submissions',
                    'data' => $days->pluck('submissions')->toArray(),
                ],
            ],
            'labels' => $days->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
```

## Pagine Filament

### 1. ListForms
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Resources\FormResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\FormBuilder\Filament\Resources\FormResource;

class ListForms extends XotBaseListRecords
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->label('Create Form'),
        ];
    }
}
```

### 2. CreateForm
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Resources\FormResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\FormBuilder\Filament\Resources\FormResource;

class CreateForm extends XotBaseCreateRecord
{
    protected static string $resource = FormResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
```

### 3. EditForm
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Resources\FormResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Modules\FormBuilder\Filament\Resources\FormResource;

class EditForm extends XotBaseEditRecord
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
            \Filament\Actions\Action::make('manage_fields')
                ->label('Manage Fields')
                ->url(fn (): string => route('filament.admin.resources.forms.fields.index', $this->record))
                ->openUrlInNewTab(),
        ];
    }
}
```

## Componenti Filament

### 1. FormBuilder Component
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Components;

use Filament\Forms\Components\Component;
use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\Services\FormBuilderService;

class FormBuilder extends Component
{
    protected static string $view = 'formbuilder::components.form-builder';

    public Form $form;
    public array $data = [];
    public array $errors = [];

    public function mount(Form $form): void
    {
        $this->form = $form;
    }

    public function submit(): void
    {
        $formBuilder = app(FormBuilderService::class);
        
        try {
            $result = $formBuilder->validateForm($this->form, $this->data);
            
            if ($result->passes()) {
                // Process form submission
                $this->form->submissions()->create($this->data);
                
                $this->dispatch('form-submitted', [
                    'form_id' => $this->form->id,
                    'data' => $this->data,
                ]);
                
                $this->data = [];
                $this->errors = [];
                
            } else {
                $this->errors = $result->errors();
            }
            
        } catch (\Exception $e) {
            $this->errors = ['general' => $e->getMessage()];
        }
    }

    public function render()
    {
        return view(static::$view, [
            'form' => $this->form,
            'fields' => $this->form->fields()->visible()->orderBy('order')->get(),
            'data' => $this->data,
            'errors' => $this->errors,
        ]);
    }
}
```

### 2. Form Builder View
```blade
{{-- resources/views/formbuilder/components/form-builder.blade.php --}}
<div class="form-builder">
    <form wire:submit="submit" class="space-y-6">
        @foreach($fields as $field)
            <div class="form-field">
                <label for="{{ $field->name }}" class="block text-sm font-medium text-gray-700">
                    {{ $field->label }}
                    @if($field->required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>
                
                @switch($field->type)
                    @case('text')
                        <input 
                            type="text" 
                            id="{{ $field->name }}"
                            name="{{ $field->name }}"
                            wire:model="data.{{ $field->name }}"
                            placeholder="{{ $field->placeholder }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @if($field->required) required @endif
                        >
                        @break
                        
                    @case('email')
                        <input 
                            type="email" 
                            id="{{ $field->name }}"
                            name="{{ $field->name }}"
                            wire:model="data.{{ $field->name }}"
                            placeholder="{{ $field->placeholder }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @if($field->required) required @endif
                        >
                        @break
                        
                    @case('textarea')
                        <textarea 
                            id="{{ $field->name }}"
                            name="{{ $field->name }}"
                            wire:model="data.{{ $field->name }}"
                            placeholder="{{ $field->placeholder }}"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @if($field->required) required @endif
                        ></textarea>
                        @break
                        
                    @case('select')
                        <select 
                            id="{{ $field->name }}"
                            name="{{ $field->name }}"
                            wire:model="data.{{ $field->name }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @if($field->required) required @endif
                        >
                            <option value="">Select an option</option>
                            @foreach($field->getOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @break
                        
                    @default
                        <input 
                            type="text" 
                            id="{{ $field->name }}"
                            name="{{ $field->name }}"
                            wire:model="data.{{ $field->name }}"
                            placeholder="{{ $field->placeholder }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            @if($field->required) required @endif
                        >
                @endswitch
                
                @if($field->help_text)
                    <p class="mt-1 text-sm text-gray-500">{{ $field->help_text }}</p>
                @endif
                
                @if(isset($errors[$field->name]))
                    <p class="mt-1 text-sm text-red-600">{{ $errors[$field->name][0] }}</p>
                @endif
            </div>
        @endforeach
        
        <div class="flex justify-end">
            <button 
                type="submit"
                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                Submit Form
            </button>
        </div>
    </form>
</div>
```

## Best Practices

### 1. Resource Design
- **Sempre** estendere XotBaseResource
- **Sempre** definire navigationGroup e navigationSort
- **Sempre** implementare form schema completo
- **Mai** duplicare logica tra risorse

### 2. Form Schema
- **Sempre** validare input con regole appropriate
- **Sempre** usare live updates per campi correlati
- **Sempre** fornire placeholder e help text
- **Mai** permettere campi senza validazione

### 3. Table Design
- **Sempre** implementare filtri appropriati
- **Sempre** usare badge per stati
- **Sempre** implementare azioni bulk
- **Mai** mostrare troppe colonne di default

### 4. Widget Integration
- **Sempre** creare widget informativi
- **Sempre** usare grafici per dati temporali
- **Sempre** implementare statistiche utili
- **Mai** sovraccaricare dashboard

## Collegamenti Correlati

### Documentazione Moduli
- [Form Implementation](form-implementation.md) - Implementazione dettagliata form
- [Field Management](field-management.md) - Gestione campi form
- [Template System](template-system.md) - Sistema template
- [Architecture](architecture.md) - Architettura modulo

### Documentazione Generale
- [Filament Best Practices](../../Xot/docs/filament-best-practices.md) - Best practices Filament
- [XotBaseResource Guidelines](../../Xot/docs/xotbase-resource-guidelines.md) - Linee guida XotBaseResource
- [PHPStan Guidelines](../../../docs/phpstan_usage.md) - Linee guida PHPStan

---

**Ultimo aggiornamento**: 2025-01-06
**Autore**: Sistema di correzione automatica
**Stato**: ✅ Completato