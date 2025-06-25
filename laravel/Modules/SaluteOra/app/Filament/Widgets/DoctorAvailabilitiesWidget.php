<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Collection;
use Modules\SaluteOra\Models\User;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Group;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Modules\SaluteOra\Models\StudioUser;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Filament\Actions\Concerns\InteractsWithActions;
use Modules\UI\Filament\Forms\Components\OpeningHoursField;

/**
 * DoctorAvailabilitiesWidget
 *
 * Widget per visualizzare tutti gli studi in cui lavora il dottore
 * e i relativi orari di disponibilità (schedule) configurati.
 * 
 * Caratteristiche:
 * - Multi-studio overview per dottori
 * - Visualizzazione schedule dal pivot studio_user
 * - Link diretti per modifica orari per studio
 * - Studio principale evidenziato
 * - Gestione empty states
 * - Security: solo per UserType::DOCTOR
 * 
 * @property-read Collection<int, array> $studios_schedules
 * @property-read User $doctor
 */
class DoctorAvailabilitiesWidget extends XotBaseWidget implements HasActions
{
    use InteractsWithActions;
    /**
     * Vista del widget.
     */
    protected static string $view = 'saluteora::filament.widgets.doctor-availabilities';

   

    public function getFormSchema(): array
    {
        return [
            //OpeningHoursField::make('schedule')
            //    ->columnSpanFull(),
        ];
    }
    /**
     * Determina se il widget può essere visualizzato.
     * Solo dottori autenticati possono vedere questo widget.
     */
    public static function canView(): bool
    {
        $user = auth()->user();
        
        return $user instanceof User 
            && $user->type === UserTypeEnum::DOCTOR->value;
    }

    /**
     * Ottiene i dati per la vista.
     * 
     * Recupera tutti gli studi associati al dottore con i relativi
     * schedule dalla tabella pivot studio_user.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
       
        /** @var User $doctor */
        $doctor = auth()->user();
        
        // Recupera tutti gli studi con schedule dal pivot
        // con eager loading per evitare query N+1
        $studiosWithSchedules = $doctor->studios()
            ->withPivot(['schedule', 'is_primary'])
            ->orderBy('studio_user.is_primary', 'desc') // Studio principale in cima
            ->get()
            ->map(function ($studio) {
                return [
                    'studio' => $studio,
                    'schedule' => $studio->pivot->schedule ?? [],
                    'is_primary' => $studio->pivot->is_primary ?? false,
                ];
            });
        
        return [
            'studios_schedules' => $studiosWithSchedules,
            'doctor' => $doctor,
        ];
    }

    /**
     * Formatta un orario per la visualizzazione.
     * 
     * @param array<string, string|null> $timeSlot
     * @return string
     */
    protected function formatTimeSlot(array $timeSlot): string
    {
        $from = $timeSlot['from'] ?? $timeSlot['morning_from'] ?? $timeSlot['afternoon_from'] ?? null;
        $to = $timeSlot['to'] ?? $timeSlot['morning_to'] ?? $timeSlot['afternoon_to'] ?? null;
        
        if (empty($from) || empty($to)) {
            return 'Chiuso';
        }
        
        return "{$from} - {$to}";
    }

    /**
     * Determina se un giorno ha orari configurati.
     * 
     * @param array<string, mixed> $daySchedule
     * @return bool
     */
    protected function hasDaySchedule(array $daySchedule): bool
    {
        return !empty($daySchedule['morning_from']) && !empty($daySchedule['morning_to'])
            || !empty($daySchedule['afternoon_from']) && !empty($daySchedule['afternoon_to']);
    }

    /**
     * Ottiene l'etichetta localizzata per un giorno.
     * 
     * @param string $dayKey
     * @return string
     */
    protected function getDayLabel(string $dayKey): string
    {
        return ucfirst(__('ui::opening_hours.days.' . $dayKey));
    }

    /**
     * Conta il numero totale di studi configurati.
     * 
     * @return int
     */
    protected function getTotalConfiguredStudios(): int
    {
        $data = $this->getViewData();
        
        return $data['studios_schedules']->filter(function ($studioData) {
            return !empty($studioData['schedule']);
        })->count();
    }

    /**
     * Ottiene statistiche rapide per il widget.
     * 
     * @return array<string, mixed>
     */
    protected function getQuickStats(): array
    {
        $data = $this->getViewData();
        $studiosSchedules = $data['studios_schedules'];
        
        $totalStudios = $studiosSchedules->count();
        $configuredStudios = $studiosSchedules->filter(fn($studio) => !empty($studio['schedule']))->count();
        $primaryStudio = $studiosSchedules->firstWhere('is_primary', true);
        
        return [
            'total_studios' => $totalStudios,
            'configured_studios' => $configuredStudios,
            'unconfigured_studios' => $totalStudios - $configuredStudios,
            'has_primary_studio' => !is_null($primaryStudio),
            'primary_studio_name' => $primaryStudio['studio']->name ?? null,
        ];
    }

   

    /**
     * Ottiene tutti gli studi del dottore con le disponibilità.
     *
     * @return Collection<int, StudioUser>
     */
    public function getDoctorStudios(): Collection
    {
        /** @var User $doctor */
        $doctor = auth()->user();
        
        return StudioUser::where('user_id', $doctor->id)
            ->with(['studio'])
            ->get();
    }

    /**
     * Formatta gli orari per la visualizzazione.
     */
    public function formatSchedule(?array $schedule): string
    {
        if (empty($schedule)) {
            return __('saluteora::doctor_availability.widget.no_schedule');
        }

        $formatted = [];
        $daysTranslation = [
            'monday' => __('saluteora::days.monday'),
            'tuesday' => __('saluteora::days.tuesday'),
            'wednesday' => __('saluteora::days.wednesday'),
            'thursday' => __('saluteora::days.thursday'),
            'friday' => __('saluteora::days.friday'),
            'saturday' => __('saluteora::days.saturday'),
            'sunday' => __('saluteora::days.sunday'),
        ];

        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
            if (!empty($schedule[$day])) {
                $daySchedule = $schedule[$day];
                $times = [];
                
                if (!empty($daySchedule['morning'])) {
                    $times[] = __('saluteora::doctor_availability.widget.morning') . ': ' . $daySchedule['morning'];
                }
                
                if (!empty($daySchedule['afternoon'])) {
                    $times[] = __('saluteora::doctor_availability.widget.afternoon') . ': ' . $daySchedule['afternoon'];
                }
                
                if (!empty($times)) {
                    $formatted[] = $daysTranslation[$day] . ' (' . implode(', ', $times) . ')';
                }
            }
        }

        return !empty($formatted) 
            ? implode(' | ', $formatted)
            : __('saluteora::doctor_availability.widget.no_schedule');
    }

    /**
     * Azione per modificare gli orari di uno studio.
     */
    public function editScheduleAction(): Action
    {
        return Action::make('editSchedule')
            ->label(__('saluteora::doctor_availability.actions.edit_schedule'))
            ->icon('heroicon-o-clock')
            ->color('primary')
            ->form([
                OpeningHoursField::make('schedule')
                    ->columnSpanFull(),
            ])
            ->fillForm(function (array $arguments): array {
                
                $studioUserId = $arguments['studioUserId'] ?? null;
                
                if (!$studioUserId) {
                    return ['schedule' => []];
                }
                
                $studioUser = StudioUser::find($studioUserId);
                
                return [
                    'schedule' => $studioUser?->schedule ?? [],
                ];
            })
            ->action(function (array $data, array $arguments): void {
                $studioUserId = $arguments['studioUserId'] ?? null;
                
                if (!$studioUserId) {
                    Notification::make()
                        ->title(__('saluteora::doctor_availability.notifications.error.title'))
                        ->body(__('saluteora::doctor_availability.notifications.error.invalid_studio'))
                        ->danger()
                        ->send();
                    return;
                }

                try {
                    $studioUser = StudioUser::findOrFail($studioUserId);
                    $studioUser->update(['schedule' => $data['schedule']]);

                    Notification::make()
                        ->title(__('saluteora::doctor_availability.notifications.saved.title'))
                        ->body(__('saluteora::doctor_availability.notifications.saved.body'))
                        ->success()
                        ->send();

                    // Refresh del widget
                    $this->dispatch('$refresh');
                    
                } catch (\Exception $e) {
                    Notification::make()
                        ->title(__('saluteora::doctor_availability.notifications.error.title'))
                        ->body(__('saluteora::doctor_availability.notifications.error.body') . ': ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    /**
     * Azione per impostare uno studio come primario.
     */
    public function setPrimaryAction(): Action
    {
        return Action::make('setPrimary')
            ->label(__('saluteora::doctor_availability.actions.set_primary'))
            ->icon('heroicon-o-star')
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading(__('saluteora::doctor_availability.actions.set_primary'))
            ->modalDescription(__('saluteora::doctor_availability.modals.set_primary_description'))
            ->action(function (array $arguments): void {
                $studioUserId = $arguments['studioUserId'] ?? null;
                
                if (!$studioUserId) {
                    return;
                }

                try {
                    /** @var User $doctor */
                    $doctor = auth()->user();
                    
                    // Rimuovi il flag primario da tutti gli altri studi
                    StudioUser::where('user_id', $doctor->id)
                        ->where('id', '!=', $studioUserId)
                        ->update(['is_primary' => false]);
                    
                    // Imposta questo studio come primario
                    StudioUser::where('id', $studioUserId)
                        ->update(['is_primary' => true]);

                    Notification::make()
                        ->title(__('saluteora::doctor_availability.notifications.primary_set.title'))
                        ->body(__('saluteora::doctor_availability.notifications.primary_set.body'))
                        ->success()
                        ->send();

                    // Refresh del widget
                    $this->dispatch('$refresh');
                    
                } catch (\Exception $e) {
                    Notification::make()
                        ->title(__('saluteora::doctor_availability.notifications.error.title'))
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    /**
     * Ottiene le azioni disponibili.
     *
     * @return array<Action>
     */
    protected function getActions(): array
    {
        return [
            $this->editScheduleAction(),
            $this->setPrimaryAction(),
        ];
    }

    /**
     * Crea un form per un studio specifico.
     * Utilizzato per forms inline nei template.
     * 
     * @param int $studioId
     * @return Form
     */
    public function studioForm(int $studioId): Form
    {
        return Form::make()
            ->schema([
                OpeningHoursField::make('schedule')
                    ->default($this->getStudioSchedule($studioId))
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (array $state) use ($studioId) {
                        $this->saveStudioSchedule($studioId, $state);
                    })
                    ->columnSpanFull(),
            ])
            ->statePath("studio_schedules.{$studioId}");
    }

    /**
     * Ottiene il schedule corrente per uno studio.
     * 
     * @param int $studioId
     * @return array<string, mixed>
     */
    public function getStudioSchedule(int $studioId): array
    {
        /** @var User $doctor */
        $doctor = auth()->user();
        
        $studioUser = StudioUser::where('user_id', $doctor->id)
            ->where('studio_id', $studioId)
            ->first();
            
        return $studioUser?->schedule ?? [];
    }

    /**
     * Salva il schedule per uno studio specifico.
     * 
     * @param int $studioId
     * @param array<string, mixed> $schedule
     * @return void
     */
    public function saveStudioSchedule(int $studioId, array $schedule): void
    {
        try {
            /** @var User $doctor */
            $doctor = auth()->user();
            
            // Verifica che lo studio appartenga al dottore (security)
            $studioUser = StudioUser::where('user_id', $doctor->id)
                ->where('studio_id', $studioId)
                ->first();
                
            if (!$studioUser) {
                throw new \Exception(__('saluteora::doctor_availability.notifications.error.unauthorized'));
            }
            
            // Aggiorna il schedule
            $studioUser->update(['schedule' => $schedule]);
            
            // Notifica successo
            Notification::make()
                ->title(__('saluteora::doctor_availability.notifications.saved.title'))
                ->body(__('saluteora::doctor_availability.notifications.saved.body'))
                ->success()
                ->send();
                
        } catch (\Exception $e) {
            // Notifica errore
            Notification::make()
                ->title(__('saluteora::doctor_availability.notifications.error.title'))
                ->body($e->getMessage())
                ->danger()
                ->send();
                
            // Log dell'errore per debugging
            Log::error('Failed to save studio schedule', [
                'studio_id' => $studioId,
                'doctor_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);
        }
    }

   
} 