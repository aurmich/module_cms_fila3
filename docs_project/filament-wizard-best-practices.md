# Best practices per Wizard multi-step in Filament

> **NOTA IMPORTANTE**: Questa doc DEVE sempre contenere un collegamento alla fonte di design (md/blade/html) se presente. Per il caso DoctorResource vedi [errore-form-schema-widget-doctor.md](errore-form-schema-widget-doctor.md).

## Regola sulle Actions

## Regola sulla gestione dello stato (Spatie Model States)
- **Vietato** aggiornare direttamente il campo `status` nei modelli di workflow o processo.
- **Obbligatorio** usare [Spatie Model States](https://spatie.be/docs/laravel-model-states/v2/01-introduction) e le sue transizioni dichiarate.
- Le transizioni devono essere definite nella classe di stato e mai bypassate.

**Esempio:**
```php
$workflow->status->transitionTo(Approved::class);
```

- Ogni stato può avere metodi e logica specifica.
- Documentare sempre le regole di transizione nella doc tecnica e nel codice.

Vedi dettagli in [wizard-moderation-flow.md](wizard-moderation-flow.md) e nella [doc ufficiale Spatie](https://spatie.be/docs/laravel-model-states/v2/01-introduction).
- **Non usare mai Service class custom** per la business logic nei Wizard.
- Utilizzare sempre [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action) per logica asincrona, di dominio o che coinvolge side-effect (es. moderazione, invio email, aggiornamento stato).

**Esempio:**
```php
use Modules\Patient\Actions\ProcessDoctorModerationAction;

app(ProcessDoctorModerationAction::class)->execute($workflow, true, $notes, $moderatorId);
```

Vedi dettagli e pseudo-codice in [wizard-moderation-flow.md](wizard-moderation-flow.md).

## Struttura Base
```php
Forms\Components\Wizard::make('Nome Wizard')
    ->steps([
        Forms\Components\Wizard\Step::make('step_name')
            ->label('Label Step')
            ->description('Descrizione Step')
            ->schema([
                // Schema dello step
            ]),
    ]);
```

## Best Practices

1. **Organizzazione degli Step**
   - Ogni step deve avere uno scopo chiaro e specifico
   - Limitare il numero di campi per step (max 5-7)
   - Raggruppare campi correlati nello stesso step
   - Usare sezioni per organizzare i campi all'interno dello step

2. **Validazione**
   - Implementare validazione per ogni step
   - Mostrare errori in modo chiaro
   - Validare i dati prima di procedere allo step successivo
   - Usare regole di validazione appropriate

3. **UI/UX**
   - Aggiungere icone agli step
   - Fornire descrizioni chiare
   - Mostrare progresso
   - Implementare navigazione intuitiva

4. **Traduzioni**
   - Usare file di traduzione per tutte le stringhe
   - Mantenere coerenza linguistica
   - Evitare testo hardcoded

## Gestione Label e Traduzioni

### Step Labels
- NON utilizzare mai `->label()` negli step del wizard
- Utilizzare i file di traduzione per le etichette degli step
```php
// ✅ CORRETTO
Forms\Components\Wizard\Step::make('personal_data_step')
    ->schema(self::getPersonalDataStepSchema());

// ❌ ERRATO
Forms\Components\Wizard\Step::make('personal_data_step')
    ->label('Dati Personali')
    ->schema(self::getPersonalDataStepSchema());
```

### File di Traduzione per Wizard
```php
// lang/it/patient-resource.php
return [
    'steps' => [
        'personal_data_step' => [
            'label' => 'Dati Personali',
            'description' => 'Inserisci i tuoi dati personali'
        ]
    ]
];
```

## Struttura del Wizard

### Separazione degli Step
```php
class PatientResource extends XotBaseResource
{
    public static function getFormSchemaWidget(): array
    {
        return [
            Forms\Components\Wizard::make([
                self::getPersonalDataStep(),
                self::getDocumentsStep(),
                self::getPreVisitStep(),
                self::getPrivacyStep(),
            ])
            ->skippable(false)
            ->columnSpan('full')
        ];
    }

    protected static function getPersonalDataStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('personal_data_step')
            ->schema(self::getPersonalDataStepSchema());
    }
}
```

## Validazione e Salvataggio

### Validazione per Step
```php
protected static function getPersonalDataStepSchema(): array
{
    return [
        Forms\Components\TextInput::make('first_name')
            ->required()
            ->maxLength(255),
        Forms\Components\TextInput::make('last_name')
            ->required()
            ->maxLength(255),
    ];
}
```

## Esempio di Implementazione
```php
public static function getFormSchemaWidget(): array
{
    $prefix = static::$translationPrefix;
    
    return [
        'wizard' => Forms\Components\Wizard::make('Dottore')
            ->steps([
                Forms\Components\Wizard\Step::make('personal_info')
                    ->label(trans("$prefix.steps.personal_info.label"))
                    ->description(trans("$prefix.steps.personal_info.description"))
                    ->icon('heroicon-o-user')
                    ->schema([
                        // Schema dello step
                    ]),
                // Altri step...
            ]),
    ];
}
```

## Collegamenti
- [README](README.md)
- [Filament Resources](filament-resources.md)
- [Form Components](filament-form-components.md)

## Vedi Anche
- [Filament Wizard Documentation](https://filamentphp.com/docs/forms/layout#wizard)
- [Best Practices](../../Xot/docs/filament-best-practices.md)
- [LangServiceProvider Labels](langserviceprovider-labels.md)
- [Traduzioni](translations.md)
- [Wizard Structure](filament-wizard-structure.md) 