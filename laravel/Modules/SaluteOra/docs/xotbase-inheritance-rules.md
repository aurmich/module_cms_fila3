# Regole di Ereditarietà delle Classi XotBase in SaluteOra

## Introduzione

Il framework Laraxot implementa un pattern architetturale specifico dove **non si estendono mai direttamente le classi Filament**, ma si utilizzano sempre classi wrapper con prefisso `XotBase`. Questa documentazione definisce le regole critiche da seguire per evitare errori gravi.

## Classi XotBase Disponibili

### Pagine Filament
- `Modules\Xot\Filament\Pages\XotBasePage`
- `Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage`

### Risorse Filament
- `Modules\Xot\Filament\Resources\XotBaseResource`

### Widget Filament
- `Modules\Xot\Filament\Widgets\XotBaseWidget`

## ⚠️ REGOLA CRITICA: NO DUPLICAZIONE TRAIT/INTERFACCE

### Errore Grave Comune

**❌ ERRORE GRAVE**: Ridichiarare trait e interfacce già presenti nelle classi XotBase

```php
// ❌ ERRORE GRAVE
class DoctorAvailabilityPage extends XotBasePage implements HasForms
{
    use InteractsWithForms;  // GRAVE: Già presente in XotBasePage
    
    // ...
}
```

### Implementazione Corretta

**✅ CORRETTO**: Estendere solo la classe base senza ridichiarazioni

```php
// ✅ CORRETTO
class DoctorAvailabilityPage extends XotBasePage
{
    // Nessuna ridichiarazione di trait/interfacce
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                OpeningHoursField::make('schedule')
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }
}
```

## Cosa Forniscono le Classi XotBase

### XotBasePage

Implementa automaticamente:
- `HasForms` interface
- `InteractsWithForms` trait
- `NavigationLabelTrait` trait
- `TransTrait` trait
- `InteractsWithFormActions` trait

### XotBaseResource

Implementa automaticamente:
- Gestione automatica navigationGroup/navigationLabel
- Configurazione centralizzata delle tabelle
- Pattern standardizzati per le risorse

### XotBaseWidget

Implementa automaticamente:
- `HasForms` interface
- `InteractsWithForms` trait
- `InteractsWithPageFilters` trait
- Proprietà critiche come `$data`

## Conseguenze della Violazione

### Errori Tecnici
1. **Conflitti di Trait**: Errori runtime difficili da debuggare
2. **Duplicazione di Memoria**: Caricamento doppio degli stessi trait
3. **Comportamento Imprevedibile**: Override accidentali di metodi
4. **Errori di Compilazione**: Conflitti nel sistema di autoloading

### Problemi Architetturali
1. **Violazione DRY**: Duplicazione di codice
2. **Manutenibilità Compromessa**: Cambiamenti difficili da propagare
3. **Inconsistenza**: Comportamento diverso tra pagine simili
4. **Debug Complesso**: Tracciamento problematico degli errori

## Checklist di Verifica

Prima di pubblicare una classe che estende XotBase:

- [ ] ✅ La classe NON ridichiarah `implements HasForms`
- [ ] ✅ La classe NON ridichiarah `use InteractsWithForms`
- [ ] ✅ La classe NON ridichiarah altri trait già presenti nella base
- [ ] ✅ L'import include solo le classi effettivamente necessarie
- [ ] ✅ La documentazione è aggiornata
- [ ] ✅ I test passano correttamente

## Esempi Pratici SaluteOra

### DoctorAvailabilityPage - Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Pages;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Modules\UI\Filament\Forms\Components\OpeningHoursField;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * ✅ IMPLEMENTAZIONE CORRETTA
 * 
 * Estende XotBasePage senza ridichiarare trait/interfacce
 */
class DoctorAvailabilityPage extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static string $view = 'saluteora::filament.pages.doctor-availability';
    
    public array $data = [];

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label(__('saluteora::doctor_availability.actions.save'))
                ->action('save')
                ->color('success'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                OpeningHoursField::make('schedule')
                    ->label(__('saluteora::doctor_availability.sections.weekly_availability'))
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        // Logica di salvataggio
        $this->validateForm();
        $this->saveAvailability();
        $this->sendSuccessNotification();
    }
}
```

### CalendarWidget - Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

/**
 * ✅ IMPLEMENTAZIONE CORRETTA per FullCalendar
 * 
 * Per i widget FullCalendar, estendere direttamente la classe del package
 * ma seguire i pattern di configurazione Laraxot
 */
class DoctorCalendarWidget extends FullCalendarWidget
{
    protected static ?int $sort = 1;
    
    public function fetchEvents(array $fetchInfo): array
    {
        // Implementazione per recuperare eventi
        return [];
    }
    
    public function config(): array
    {
        return [
            'initialView' => 'timeGridWeek',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
        ];
    }
}
```

## Troubleshooting

### Se si verificano errori del tipo "Class not found"

1. **Verificare gli import**: Controllare che tutti gli import siano corretti
2. **Rimuovere duplicazioni**: Eliminare trait/interfacce già presenti nella base
3. **Cache clear**: Eseguire `php artisan cache:clear`
4. **Autoload refresh**: Eseguire `composer dump-autoload`

### Se si verificano conflitti di trait

1. **Identificare la fonte**: Controllare quale classe base fornisce già il trait
2. **Rimuovere duplicazione**: Eliminare la ridichiarazione del trait
3. **Testare funzionalità**: Verificare che tutto funzioni correttamente

## Collegamenti

- [XotBasePage Documentation](../../Xot/docs/filament/pages/xotbasepage.md)
- [Filament Best Practices](../../Xot/docs/filament/filament_best_practices.md)
- [SaluteOra Architecture](README.md)
- [Doctor Availability Management](doctor-availability-management.md)

---

*Ultimo aggiornamento: Dicembre 2024*

**Regola creata in seguito alla correzione dell'errore grave in DoctorAvailabilityPage** 