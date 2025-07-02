# Esempi Pratici di Utilizzo Traduzioni - SaluteOra

## Widget DoctorAvailabilities Corretto

### ✅ IMPLEMENTAZIONE CORRETTA

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;

class DoctorAvailabilitiesWidget extends Widget
{
    protected static string $view = 'saluteora::filament.widgets.doctor-availabilities';

    /**
     * Azioni del widget.
     */
    protected function getActions(): array
    {
        return [
            Action::make('edit_schedule')
                // ✅ CORRETTO: Usa traduzioni dalla struttura espansa
                ->label(__('saluteora::widgets.doctor_availabilities.actions.edit_schedule.label'))
                ->tooltip(__('saluteora::widgets.doctor_availabilities.actions.edit_schedule.tooltip'))
                ->modalHeading(__('saluteora::widgets.doctor_availabilities.actions.edit_schedule.modal_heading'))
                ->modalDescription(__('saluteora::widgets.doctor_availabilities.actions.edit_schedule.modal_description'))
                ->successNotificationTitle(__('saluteora::widgets.doctor_availabilities.actions.edit_schedule.success'))
                ->action(function () {
                    // Logica per modificare gli orari
                    $this->editSchedule();
                }),
        ];
    }

    /**
     * Dati per la view.
     */
    protected function getViewData(): array
    {
        return [
            'hasSchedule' => $this->hasConfiguredSchedule(),
            'emptyStateHeading' => __('saluteora::widgets.doctor_availabilities.empty_state.heading'),
            'emptyStateDescription' => __('saluteora::widgets.doctor_availabilities.empty_state.description'),
            'noScheduleMessage' => __('saluteora::widgets.doctor_availabilities.schedule.no_schedule.label'),
            'clickEditMessage' => __('saluteora::widgets.doctor_availabilities.schedule.click_edit_to_configure.description'),
        ];
    }

    private function hasConfiguredSchedule(): bool
    {
        // Logica per verificare se ci sono orari configurati
        return false;
    }

    private function editSchedule(): void
    {
        // Logica per modificare gli orari
    }
}
```

### ❌ IMPLEMENTAZIONE ERRATA (da evitare)

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Actions\Action;

class DoctorAvailabilitiesWidget extends Widget
{
    protected function getActions(): array
    {
        return [
            Action::make('edit_schedule')
                // ❌ ERRATO: Stringhe hardcoded
                ->label('Modifica Orari')
                ->tooltip('Configura orari')
                ->modalHeading('Modifica Schedule')
                ->successNotificationTitle('Orari salvati'),
        ];
    }
}
```

## Form per Orari di Apertura

### ✅ IMPLEMENTAZIONE CORRETTA

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\OpeningHoursResource\Pages;

use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;

class CreateOpeningHours extends CreateRecord
{
    protected static string $resource = OpeningHoursResource::class;

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make()
                // ✅ CORRETTO: Usa traduzioni dalla struttura espansa
                ->label(__('saluteora::opening_hours.sections.weekly_schedule.label'))
                ->description(__('saluteora::opening_hours.sections.weekly_schedule.description'))
                ->schema([
                    Forms\Components\Select::make('day_of_week')
                        // ✅ CORRETTO: MAI usare ->label(), ->placeholder(), ->helperText()
                        ->options([
                            'monday' => __('saluteora::opening_hours.fields.day_of_week.options.monday'),
                            'tuesday' => __('saluteora::opening_hours.fields.day_of_week.options.tuesday'),
                            'wednesday' => __('saluteora::opening_hours.fields.day_of_week.options.wednesday'),
                            'thursday' => __('saluteora::opening_hours.fields.day_of_week.options.thursday'),
                            'friday' => __('saluteora::opening_hours.fields.day_of_week.options.friday'),
                            'saturday' => __('saluteora::opening_hours.fields.day_of_week.options.saturday'),
                            'sunday' => __('saluteora::opening_hours.fields.day_of_week.options.sunday'),
                        ])
                        ->required(),

                    Forms\Components\TimePicker::make('opening_time')
                        ->required(),

                    Forms\Components\TimePicker::make('closing_time')
                        ->required(),

                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TimePicker::make('break_start'),
                            Forms\Components\TimePicker::make('break_end'),
                        ]),

                    Forms\Components\Toggle::make('is_closed'),

                    Forms\Components\Textarea::make('notes')
                        ->rows(3),
                ]),

            Forms\Components\Section::make()
                ->label(__('saluteora::opening_hours.sections.special_hours.label'))
                ->description(__('saluteora::opening_hours.sections.special_hours.description'))
                ->schema([
                    // Campi per orari speciali
                ]),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('save')
                ->label(__('saluteora::opening_hours.actions.save_schedule.label'))
                ->action('save'),

            Forms\Components\Actions\Action::make('reset')
                ->label(__('saluteora::opening_hours.actions.reset_schedule.label'))
                ->requiresConfirmation()
                ->modalDescription(__('saluteora::opening_hours.actions.reset_schedule.confirmation'))
                ->action('reset'),
        ];
    }
}
```

## View Blade Template

### ✅ IMPLEMENTAZIONE CORRETTA

```blade
{{-- resources/views/filament/widgets/doctor-availabilities.blade.php --}}
<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('saluteora::widgets.doctor_availabilities.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('saluteora::widgets.doctor_availabilities.description') }}
        </x-slot>

        <div class="space-y-4">
            @if($hasSchedule)
                {{-- Visualizza gli orari configurati --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Schedule display --}}
                </div>
            @else
                {{-- Stato vuoto --}}
                <div class="text-center py-8">
                    <div class="mx-auto w-16 h-16 text-gray-400 mb-4">
                        <svg>{{-- Icon --}}</svg>
                    </div>
                    
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        {{ $emptyStateHeading }}
                    </h3>
                    
                    <p class="text-gray-500 mb-4">
                        {{ $emptyStateDescription }}
                    </p>
                    
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600">
                            {{ $noScheduleMessage }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $clickEditMessage }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament::widget>
```

### ❌ IMPLEMENTAZIONE ERRATA (da evitare)

```blade
{{-- ❌ ERRATO: Testi hardcoded --}}
<x-filament::widget>
    <x-filament::section>
        <x-slot name="heading">
            Disponibilità Dottori {{-- ❌ Hardcoded --}}
        </x-slot>

        <div class="text-center py-8">
            <h3>Nessun orario configurato</h3> {{-- ❌ Hardcoded --}}
            <p>Clicca Modifica per configurare</p> {{-- ❌ Hardcoded --}}
        </div>
    </x-filament::section>
</x-filament::widget>
```

## Messaggi di Validazione

### ✅ IMPLEMENTAZIONE CORRETTA

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpeningHoursRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'opening_time' => ['required', 'date_format:H:i'],
            'closing_time' => ['required', 'date_format:H:i', 'after:opening_time'],
            'break_start' => ['nullable', 'date_format:H:i'],
            'break_end' => ['nullable', 'date_format:H:i', 'after:break_start'],
        ];
    }

    public function messages(): array
    {
        return [
            // ✅ CORRETTO: Usa traduzioni strutturate
            'opening_time.required' => __('saluteora::opening_hours.validation.opening_time_required'),
            'closing_time.required' => __('saluteora::opening_hours.validation.closing_time_required'),
            'closing_time.after' => __('saluteora::opening_hours.validation.closing_before_opening'),
            'opening_time.date_format' => __('saluteora::opening_hours.validation.invalid_time_format'),
            'closing_time.date_format' => __('saluteora::opening_hours.validation.invalid_time_format'),
        ];
    }
}
```

## Checklist di Controllo

### ✅ Traduzioni Corrette
- [ ] Utilizzata struttura espansa per tutti i campi
- [ ] Inclusi `label`, `placeholder`, `help` per ogni campo
- [ ] Utilizzata sintassi array breve `[]`
- [ ] Incluso `declare(strict_types=1);`
- [ ] MAI utilizzato `->label()`, `->placeholder()`, `->helperText()` hardcoded
- [ ] Messaggi di validazione tradotti
- [ ] Sezioni e azioni completamente tradotte

### ❌ Errori da Evitare
- [ ] Stringhe hardcoded nei componenti
- [ ] Struttura piatta invece di espansa
- [ ] Mancanza di `placeholder` o `help`
- [ ] Utilizzo di `array()` invece di `[]`
- [ ] Mancanza di `declare(strict_types=1);`

## Comandi Utili

```bash
# Verifica traduzioni mancanti
php artisan trans:missing-keys --module=SaluteOra

# Cerca stringhe hardcoded
grep -r "->label(" Modules/SaluteOra/app/ --include="*.php"
grep -r "->placeholder(" Modules/SaluteOra/app/ --include="*.php"
grep -r "->helperText(" Modules/SaluteOra/app/ --include="*.php"

# Verifica struttura file traduzioni
php artisan translation:validate --module=SaluteOra
```

## Collegamenti

- [File Traduzioni Widget](../lang/it/widgets.php)
- [File Traduzioni Orari](../lang/it/opening_hours.php)
- [Documentazione Traduzioni](./traduzioni_orari.md)
- [Regole Generali](../../Xot/docs/TRANSLATION_RULES.md)

*Ultimo aggiornamento: dicembre 2024* 