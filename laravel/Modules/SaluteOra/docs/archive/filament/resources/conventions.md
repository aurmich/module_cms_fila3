# Convenzioni Filament in SaluteOra

## Principi generali

1. **Non estendere mai direttamente le classi di Filament**
   - Estendere sempre classi base personalizzate con prefisso `XotBase` 
   - Esempio: `XotBasePage`, `XotBaseResource`, `XotBaseListRecords`

2. **Evitare la duplicazione di codice**
   - Utilizzare traits per funzionalità riutilizzabili
   - Sfruttare classi base e pattern di ereditarietà

3. **Traduzione e Localizzazione**
   - MAI utilizzare il metodo `->label()` nei componenti Filament
   - Le etichette sono gestite automaticamente dal LangServiceProvider
   - Usare sempre `__('modulo::risorsa.fields.campo.label')` per le traduzioni

4. **Architettura del codice**
   - Seguire PSR-12 per lo stile del codice
   - Type hints obbligatori
   - Return types obbligatori
   - Utilizzare enums per stati e tipi

## Struttura delle classi

### Resources

```php
namespace Modules\SaluteOra\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    // NO navigationIcon se estende XotBaseResource
    // protected static ?string $navigationIcon = 'heroicon-o-document';

    // Rimuovere getRelations() se restituisce array vuoto
    // Rimuovere getPages() se contiene solo route standard

    // getFormSchema() deve restituire array associativo con chiavi stringhe
    public static function getFormSchema(): array
    {
        return [
            'title' => Forms\Components\TextInput::make('title'),
            'content' => Forms\Components\RichEditor::make('content'),
        ];
    }
}
```

### Pages

```php
namespace Modules\SaluteOra\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class DoctorDashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'saluteora::filament.pages.doctor-dashboard';

    // Utilizzare sempre chiavi di traduzione
    public function getTitle(): string
    {
        return __('saluteora::dashboard.title');
    }
}
```

### Widgets

```php
namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Widgets\Widget;

class StatsOverview extends Widget
{
    protected static string $view = 'saluteora::filament.widgets.stats-overview';
    
    // getViewData() restituisce dati per la vista
    protected function getViewData(): array
    {
        return [
            'stats' => [
                // ...
            ],
        ];
    }
}
```

## Convenzioni di Naming

### Risorse

- Singolare: `PatientResource`, `DoctorResource`
- Namespace: `Modules\SaluteOra\Filament\Resources`
- Pagine: `ListPatients`, `CreatePatient`, `EditPatient`

### Widget

- Nome descrittivo: `AppointmentStatsWidget`, `DoctorAvailabilityCalendarWidget`
- Namespace: `Modules\SaluteOra\Filament\Widgets`
- View: `saluteora::filament.widgets.nome-widget`

### Panels

- Nome descrittivo: `AdminPanel`, `DoctorPanel`
- ID univoco: `saluteora::admin`, `saluteora::doctor`

## Form Schema

### Utilizzare array associativi con chiavi stringhe

```php
// CORRETTO ✅
public static function getFormSchema(): array
{
    return [
        'title' => Forms\Components\TextInput::make('title'),
        'content' => Forms\Components\RichEditor::make('content'),
    ];
}

// ERRATO ❌
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('title'),
        Forms\Components\RichEditor::make('content'),
    ];
}
```

### Tradurre tutti i campi

```php
// CORRETTO ✅ - Non usa ->label() direttamente
'name' => Forms\Components\TextInput::make('name'),

// ERRATO ❌ - Usa ->label() direttamente
'name' => Forms\Components\TextInput::make('name')
    ->label('Nome'),
```

## List Table Columns

```php
// CORRETTO ✅
public function getListTableColumns(): array
{
    return [
        'name' => Tables\Columns\TextColumn::make('name')
            ->sortable()
            ->searchable(),
        'email' => Tables\Columns\TextColumn::make('email')
            ->sortable()
            ->searchable(),
    ];
}
```

## URL Localizzati

### Regola fondamentale

Tutti gli URL devono includere il prefisso della lingua come primo segmento del percorso:

```
/{locale}/{sezione}/{risorsa}
```

### Implementazione

```php
// CORRETTO ✅
<a href="{{ url('/' . app()->getLocale() . '/pages/' . $page->slug) }}">{{ $page->title }}</a>

// ERRATO ❌
<a href="{{ url('/pages/' . $page->slug) }}">{{ $page->title }}</a>
```

## Multi-Tenancy

### Ottenere il tenant corrente

```php
$studio = Filament::getTenant();

// Filtrare query per tenant
->where('studio_id', $studio->id)
```

### Verificare appartenenza al tenant

```php
$doctor->studios()->where('id', $studio->id)->exists()
```

## Widget FullCalendar

### Utilizzo corretto

```php
// CORRETTO ✅
FullCalendarWidget::make()
    ->config([
        'headerToolbar' => [
            'start' => 'prev,next today',
            'center' => 'title',
            'end' => 'dayGridMonth,timeGridWeek,timeGridDay',
        ],
        // altre opzioni...
    ]);

// ERRATO ❌
FullCalendarWidget::make()
    ->options([
        // configurazioni
    ]);
```

## Gestione Single Table Inheritance

### Con Parental

```php
// Modello principale
class User extends Model
{
    use HasChildren;
    protected $fillable = ['type'];
}

// Modello figlio
class Doctor extends User
{
    use HasParent;
    
    // Metodi specifici per Doctor
}

// Ottenere un Doctor
$doctor = Doctor::find(1); // Restituisce un'istanza di Doctor
$user = User::find(1);     // Restituisce un'istanza di Doctor se l'utente è un medico
```

## Riferimenti

- [Documentazione Filament](https://filamentphp.com/docs)
- [Documentazione Saade FilamentFullCalendar](https://github.com/saade/filament-fullcalendar)
- [Documentazione Parental](https://github.com/tighten/parental)
- [Convenzioni PSR-12](https://www.php-fig.org/psr/psr-12/)
