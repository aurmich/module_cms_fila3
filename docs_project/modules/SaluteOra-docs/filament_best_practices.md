# Best Practices per Filament in Progetti Modulari

## Collegamenti correlati
- [Indice documentazione](/laravel/Modules/Patient/docs/INDEX.md)
- [Filament Resources Implementation](/laravel/Modules/Patient/docs/FILAMENT_RESOURCES_IMPLEMENTATION.md)
- [Filament Customization](/laravel/Modules/Patient/docs/FILAMENT_CUSTOMIZATION.md)
- [XotBaseResource Usage](/laravel/Modules/Patient/docs/XOT_BASE_RESOURCE_USAGE.md)
- [Regole per le traduzioni](/laravel/Modules/Patient/docs/TRANSLATIONS.md)
- [Namespace Conventions](/laravel/Modules/Patient/docs/NAMESPACE_CONVENTIONS.md)

## Introduzione

Questo documento descrive le best practices per l'utilizzo di Filament in progetti modulari Laravel. Filament è un potente framework per la creazione di pannelli amministrativi, ma richiede un'implementazione strutturata per garantire manutenibilità, scalabilità e coerenza in un contesto modulare.

## Principi Fondamentali

### Estensione delle Classi Base

#### Non Estendere Direttamente le Classi Filament

**REGOLA CRITICA**: Non estendere mai direttamente le classi Filament. Utilizzare sempre le classi base con prefisso "XotBase" dal modulo Xot.

```php
// ERRATO
use Filament\Resources\Resource;

class DoctorResource extends Resource
{
    // Implementazione...
}

// CORRETTO
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    // Implementazione...
}
```

#### Motivazioni

1. **Personalizzazione Centralizzata**: Le classi XotBase forniscono funzionalità specifiche per l'applicazione
2. **Aggiornamenti Semplificati**: Quando Filament viene aggiornato, è possibile adattare solo le classi XotBase
3. **Funzionalità Aggiuntive**: Le classi XotBase includono metodi e proprietà aggiuntivi
4. **Gestione delle Dipendenze**: Le classi XotBase gestiscono dipendenze specifiche del progetto
5. **Consistenza del Codice**: Garantisce che tutti i componenti seguano lo stesso pattern

### Struttura delle Risorse

#### Organizzazione delle Classi

Le classi Filament devono essere organizzate secondo la seguente struttura:

```
Modules/Patient/app/Filament/
├── Resources/
│   ├── DoctorResource.php
│   ├── PatientResource.php
│   └── DoctorResource/
│       ├── Pages/
│       │   ├── CreateDoctor.php
│       │   ├── EditDoctor.php
│       │   └── ListDoctors.php
│       └── Widgets/
│           └── DoctorStats.php
├── Pages/
│   └── Dashboard.php
└── Widgets/
    └── PatientStatsOverview.php
```

#### Convenzioni di Naming

- Le risorse devono seguire il pattern `{Model}Resource`
- Le pagine devono seguire i pattern standard di Filament (`List{Models}`, `Create{Model}`, `Edit{Model}`)
- I widget devono avere nomi descrittivi che indicano chiaramente la loro funzione

## XotBaseResource Guidelines

### Proprietà e Metodi

#### Rimuovere Metodi e Proprietà Non Necessari

- Non definire `navigationIcon` se la classe estende `XotBaseResource`
- Rimuovere `getRelations()` se restituisce un array vuoto
- Rimuovere `getPages()` se contiene solo route standard
- `getFormSchema()` deve restituire un array associativo con chiavi string

```php
// ERRATO
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('name'),
        Forms\Components\TextInput::make('email'),
    ];
}

// CORRETTO
public static function getFormSchema(): array
{
    return [
        'name' => Forms\Components\TextInput::make('name'),
        'email' => Forms\Components\TextInput::make('email'),
    ];
}
```

### XotBaseListRecords Guidelines

- Rimuovere `Actions()` se restituisce solo `createAction`
- `getListTableColumns()` deve restituire un array associativo con chiavi string

```php
// ERRATO
public function getListTableColumns(): array
{
    return [
        Tables\Columns\TextColumn::make('name'),
        Tables\Columns\TextColumn::make('email'),
    ];
}

// CORRETTO
public function getListTableColumns(): array
{
    return [
        'name' => Tables\Columns\TextColumn::make('name'),
        'email' => Tables\Columns\TextColumn::make('email'),
    ];
}
```

## Traduzioni in Filament

### Regole per le Traduzioni

#### Non Utilizzare il Metodo `->label()`

**REGOLA CRITICA**: Non utilizzare mai il metodo `->label()` nei componenti Filament. Le etichette sono gestite automaticamente dal `LangServiceProvider`.

```php
// ERRATO
Forms\Components\TextInput::make('first_name')
    ->label('Nome')

// CORRETTO
Forms\Components\TextInput::make('first_name')
    // Il LangServiceProvider gestirà automaticamente la traduzione
```

#### Convenzione per le Chiavi di Traduzione

Le chiavi di traduzione seguono la convenzione:

```
{modulo}::{risorsa}.fields.{campo}.label
```

Esempio:
- Campo: `first_name` in DoctorResource
- Chiave di traduzione: `patient::doctor-resource.fields.first_name.label`

Per maggiori dettagli sulle regole di traduzione, consultare la [documentazione delle traduzioni](/laravel/Modules/Patient/docs/TRANSLATIONS.md).

## Form Schema

### Struttura dei Form Schema

I form schema devono essere organizzati in modo logico, raggruppando campi correlati:

```php
public static function getFormSchema(): array
{
    return [
        'personal_info' => Forms\Components\Section::make('Informazioni Personali')
            ->schema([
                'first_name' => Forms\Components\TextInput::make('first_name')
                    ->required(),
                'last_name' => Forms\Components\TextInput::make('last_name')
                    ->required(),
                'email' => Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignorable: fn ($record) => $record),
            ]),
        'professional_info' => Forms\Components\Section::make('Informazioni Professionali')
            ->schema([
                'specialization' => Forms\Components\TextInput::make('specialization'),
                'certifications' => Forms\Components\TagsInput::make('certifications'),
            ]),
    ];
}
```

### Riutilizzo dei Form Schema

Per promuovere il riutilizzo del codice, è consigliabile estrarre parti comuni dei form schema in metodi separati:

```php
public static function getAddressFormSchema(): array
{
    return [
        'address' => Forms\Components\TextInput::make('address')
            ->required(),
        'city' => Forms\Components\TextInput::make('city')
            ->required(),
        'postal_code' => Forms\Components\TextInput::make('postal_code')
            ->required(),
        'country' => Forms\Components\Select::make('country')
            ->options(Countries::getSelectOptions())
            ->required(),
    ];
}

public static function getFormSchema(): array
{
    return [
        'personal_info' => Forms\Components\Section::make('Informazioni Personali')
            ->schema([
                'first_name' => Forms\Components\TextInput::make('first_name')
                    ->required(),
                'last_name' => Forms\Components\TextInput::make('last_name')
                    ->required(),
            ]),
        'address_info' => Forms\Components\Section::make('Indirizzo')
            ->schema(self::getAddressFormSchema()),
    ];
}
```

## Table Columns

### Struttura delle Table Columns

Le table columns devono essere organizzate in modo logico, con chiavi string:

```php
public function getListTableColumns(): array
{
    return [
        'name' => Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),
        'email' => Tables\Columns\TextColumn::make('email')
            ->searchable()
            ->sortable(),
        'status' => Tables\Columns\BadgeColumn::make('status')
            ->colors([
                'danger' => 'rejected',
                'warning' => 'pending',
                'success' => 'approved',
            ]),
        'created_at' => Tables\Columns\TextColumn::make('created_at')
            ->dateTime()
            ->sortable(),
    ];
}
```

### Personalizzazione delle Columns

Per personalizzare la visualizzazione dei dati nelle colonne, utilizzare i metodi di formattazione:

```php
'full_name' => Tables\Columns\TextColumn::make('full_name')
    ->getStateUsing(function ($record) {
        return $record->first_name . ' ' . $record->last_name;
    })
    ->searchable(['first_name', 'last_name'])
    ->sortable(),
```

## Actions

### Organizzazione delle Actions

Le actions devono essere organizzate in modo logico, raggruppando actions correlate:

```php
protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make(),
        Actions\ImportAction::make(),
        Actions\ExportAction::make(),
    ];
}

protected function getActions(): array
{
    return [
        Actions\ActionGroup::make([
            Actions\ViewAction::make(),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ]),
        Actions\ActionGroup::make([
            Actions\ReplicateAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ])
        ->dropdown(true)
        ->label('Advanced'),
    ];
}
```

### Personalizzazione delle Actions

Per personalizzare il comportamento delle actions, utilizzare i metodi di configurazione:

```php
Actions\DeleteAction::make()
    ->requiresConfirmation()
    ->modalHeading('Conferma eliminazione')
    ->modalDescription('Sei sicuro di voler eliminare questo record? Questa azione non può essere annullata.')
    ->modalSubmitActionLabel('Elimina')
    ->modalCancelActionLabel('Annulla')
```

## Widgets

### Organizzazione dei Widgets

I widgets devono essere organizzati in modo logico, con nomi descrittivi:

```php
protected function getHeaderWidgets(): array
{
    return [
        Widgets\DoctorStatsOverview::class,
        Widgets\RecentAppointments::class,
    ];
}

protected function getFooterWidgets(): array
{
    return [
        Widgets\AppointmentChart::class,
    ];
}
```

### Personalizzazione dei Widgets

Per personalizzare i widgets, utilizzare i metodi di configurazione:

```php
class DoctorStatsOverview extends Widget
{
    protected static string $view = 'patient::filament.widgets.doctor-stats-overview';
    
    protected int|string|array $columnSpan = 'full';
    
    protected function getViewData(): array
    {
        return [
            'totalDoctors' => Doctor::count(),
            'activeDoctors' => Doctor::where('status', DoctorStatus::APPROVED)->count(),
            'pendingDoctors' => Doctor::where('status', DoctorStatus::PENDING)->count(),
        ];
    }
}
```

## Relazioni

### Definizione delle Relazioni

Le relazioni devono essere definite in modo chiaro, utilizzando i manager di relazione:

```php
public static function getRelations(): array
{
    return [
        'appointments' => RelationManagers\AppointmentsRelationManager::class,
        'patients' => RelationManagers\PatientsRelationManager::class,
    ];
}
```

### Personalizzazione delle Relazioni

Per personalizzare le relazioni, utilizzare i metodi di configurazione:

```php
class PatientsRelationManager extends RelationManager
{
    protected static string $relationship = 'patients';
    
    protected function getTableColumns(): array
    {
        return [
            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'email' => Tables\Columns\TextColumn::make('email')
                ->searchable()
                ->sortable(),
        ];
    }
    
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }
}
```

## Performance

### Ottimizzazione delle Query

Per migliorare le performance, ottimizzare le query utilizzate nelle risorse Filament:

```php
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->withCount('appointments')
        ->with(['specializations', 'clinic']);
}
```

### Lazy Loading dei Componenti

Per migliorare le performance delle pagine con molti componenti, utilizzare il lazy loading:

```php
protected function getHeaderWidgets(): array
{
    return [
        Widgets\DoctorStatsOverview::class,
        Widgets\RecentAppointments::class => [
            'lazy' => true,
        ],
    ];
}
```

## Errori Comuni da Evitare

1. **Estendere Direttamente le Classi Filament**: Utilizzare sempre le classi XotBase
2. **Utilizzare il Metodo `->label()`**: Lasciare che il LangServiceProvider gestisca le traduzioni
3. **Restituire Array Sequenziali nei Form Schema**: Utilizzare array associativi con chiavi string
4. **Duplicare Logica tra Risorse**: Estrarre parti comuni in metodi o classi riutilizzabili
5. **Hardcodare Testo nelle Risorse**: Utilizzare il sistema di traduzione

## Conclusione

Seguendo queste best practices, è possibile creare risorse Filament manutenibili, scalabili e coerenti in un contesto modulare. La standardizzazione dell'approccio a Filament garantisce una base solida per lo sviluppo di interfacce amministrative efficaci.

## Riferimenti

- [Documentazione Ufficiale Filament](https://filamentphp.com/docs)
- [Laravel Best Practices](https://laravel.com/docs/master)
- [Filament Resources Implementation](/laravel/Modules/Patient/docs/FILAMENT_RESOURCES_IMPLEMENTATION.md)
- [Filament Customization](/laravel/Modules/Patient/docs/FILAMENT_CUSTOMIZATION.md)
- [XotBaseResource Guidelines](/laravel/Modules/Patient/docs/XOTBASE_RESOURCE_GUIDELINES.md)
