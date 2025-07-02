<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Pages;

use Filament\Forms\Form;
use Filament\Actions\Action;
use Webmozart\Assert\Assert;
use function Safe\preg_match;
use Filament\Facades\Filament;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Filament\Forms\ComponentContainer;
use Filament\Notifications\Notification;
use Modules\SaluteOra\Models\StudioUser;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\UI\Filament\Forms\Components\OpeningHoursField;

/**
 * DoctorAvailabilityPage
 *
 * Pagina Filament per permettere ai dottori di gestire le proprie disponibilità
 * presso uno studio specifico nel contesto multi-tenant.
 * 
 * Caratteristiche:
 * - Utilizza il componente OpeningHoursField per la gestione degli orari
 * - Integrazione completa con la tenancy (studio come tenant)
 * - Salvataggio automatico nella tabella pivot studio_user
 * - Validazione in tempo reale degli orari
 * - Supporto per dottori con più studi
 * 
 * @property array $data
 * @property ComponentContainer $form
 */
class DoctorAvailabilityPage extends XotBasePage
{

    /**
     * Icona di navigazione.
     */
    //protected static ?string $navigationIcon = 'heroicon-o-clock';

    /**
     * Gruppo di navigazione.
     */
    //protected static ?string $navigationGroup = 'Agenda';

    /**
     * Ordinamento nella navigazione.
     */
    //protected static ?int $navigationSort = 6;

    /**
     * Slug della pagina.
     */
    //protected static string $routePath = '/doctor-availability';

    /**
     * Vista della pagina.
     */
    protected static string $view = 'saluteora::filament.pages.doctor-availability';

    /**
     * Dati del form.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * Determina se l'utente può accedere alla pagina.
     */
    public static function canAccess(): bool
    {
        return true;
        /*
        $user = auth()->user();
        
        return $user instanceof User && 
               $user->type === 'doctor' && 
               $user->studios()->where('studio_id', Filament::getTenant()->id)->exists();
            */
    }

    /**
     * Ottiene l'etichetta di navigazione.
     */
    public static function getNavigationLabel(): string
    {
        return __('saluteora::doctor_availability.navigation.label');
    }

    /**
     * Ottiene il titolo della pagina.
     */
    public function getTitle(): string|Htmlable
    {
        return __('saluteora::doctor_availability.navigation.label');
    }

    /**
     * Ottiene il sottotitolo della pagina.
     */
    public function getSubheading(): string|Htmlable|null
    {
        $studio = $this->getCurrentStudio();
        return __('saluteora::doctor_availability.sections.weekly_availability') . 
               ' - ' . $studio->name;
    }

    /**
     * Ottiene le azioni dell'header.
     *
     * @return array<Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                //->label(__('saluteora::doctor_availability.actions.save'))
                ->icon('heroicon-o-check')
                ->color('success')
                ->action('save')
                ->keyBindings(['cmd+s', 'ctrl+s']),
        ];
    }

    /**
     * Monta il componente.
     */
    public function mount(): void
    {
        $this->authorizeAccess();
        $this->loadCurrentAvailability();
    }

    /**
     * Schema del form.
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                'schedule'=>OpeningHoursField::make('schedule')
                    //->label(__('saluteora::doctor_availability.sections.weekly_availability'))
                    //->helperText(__('saluteora::doctor_availability.fields.is_available.help'))
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    /**
     * Salva la disponibilità.
     */
    public function save(): void
    {
        try {
            $this->validateForm();
            $this->saveAvailability();
            $this->sendSuccessNotification();
        } catch (\Exception $e) {
            $this->sendErrorNotification($e->getMessage());
        }
    }

    /**
     * Ottiene l'utente dottore corrente.
     */
    protected function getCurrentDoctor(): Doctor
    {
        /** @var User $user */
        $user = auth()->user();
        
        //if (!$user instanceof User || $user->type !== 'doctor') {
        //    abort(403, __('saluteora::doctor_availability.notifications.not_doctor.body'));
        //}
        Assert::isInstanceOf($user, Doctor::class);
        return $user;
    }

    /**
     * Ottiene lo studio corrente (tenant).
     */
    protected function getCurrentStudio(): Studio
    {
        /** @var Studio $studio */
        $studio = Filament::getTenant();
        
        if (!$studio instanceof Studio) {
            abort(404, 'Studio non trovato');
        }
        
        return $studio;
    }

    /**
     * Ottiene il record pivot dottore-studio.
     */
    protected function getDoctorStudioPivot(): ?StudioUser
    {
        $doctor = $this->getCurrentDoctor();
        $studio = $this->getCurrentStudio();
        
        return StudioUser::where([
            'user_id' => $doctor->id,
            'studio_id' => $studio->id,
        ])->first();
    }

    /**
     * Autorizza l'accesso alla pagina.
     */
    protected function authorizeAccess(): void
    {
        $doctor = $this->getCurrentDoctor();
        $studio = $this->getCurrentStudio();
        
        if (!$doctor->studios()->where('studio_id', $studio->id)->exists()) {
            abort(403, 'Accesso negato: dottore non appartiene a questo studio');
        }
    }

    /**
     * Carica la disponibilità corrente.
     */
    protected function loadCurrentAvailability(): void
    {
        $pivot = $this->getDoctorStudioPivot();
        
        $this->data = [
            'schedule' => $pivot->schedule ?? $this->getDefaultSchedule(),
        ];
    }

    /**
     * Ottiene un orario di default.
     *
     * @return array<string, array<string, string|null>>
     */
    protected function getDefaultSchedule(): array
    {
        return [
            'monday' => ['morning' => null, 'afternoon' => null],
            'tuesday' => ['morning' => null, 'afternoon' => null],
            'wednesday' => ['morning' => null, 'afternoon' => null],
            'thursday' => ['morning' => null, 'afternoon' => null],
            'friday' => ['morning' => null, 'afternoon' => null],
            'saturday' => ['morning' => null, 'afternoon' => null],
        ];
    }

    /**
     * Valida il form.
     */
    protected function validateForm(): void
    {
        $this->form->getState();
        
        // Validazione custom per orari sovrapposti
        $schedule = $this->data['schedule'] ?? [];
        $this->validateTimeRanges($schedule);
    }

    /**
     * Valida i range di orari.
     *
     * @param array<string, array<string, string|null>> $schedule
     */
    protected function validateTimeRanges(array $schedule): void
    {
        foreach ($schedule as $day => $slots) {
            if (!is_array($slots)) {
                continue;
            }
            
            $morning = $slots['morning'] ?? null;
            $afternoon = $slots['afternoon'] ?? null;
            
            // Valida formato morning
            if ($morning && !$this->isValidTimeRange($morning)) {
                throw new \InvalidArgumentException(
                    "Orario mattutino non valido per {$day}: {$morning}"
                );
            }
            
            // Valida formato afternoon
            if ($afternoon && !$this->isValidTimeRange($afternoon)) {
                throw new \InvalidArgumentException(
                    "Orario pomeridiano non valido per {$day}: {$afternoon}"
                );
            }
            
            // Valida sovrapposizioni
            if ($morning && $afternoon && $this->timesOverlap($morning, $afternoon)) {
                throw new \InvalidArgumentException(
                    "Gli orari di mattina e pomeriggio si sovrappongono per {$day}"
                );
            }
        }
    }

    /**
     * Verifica se un range di orari è valido.
     */
    protected function isValidTimeRange(string $timeRange): bool
    {
        if (!preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $timeRange)) {
            return false;
        }
        
        [$start, $end] = explode('-', $timeRange);
        
        try {
            $startTime = \Carbon\Carbon::createFromFormat('H:i', $start);
            $endTime = \Carbon\Carbon::createFromFormat('H:i', $end);
            
            return $startTime < $endTime;
        } catch (\Exception) {
            return false;
        }
    }

    /**
     * Verifica se due range di orari si sovrappongono.
     */
    protected function timesOverlap(string $range1, string $range2): bool
    {
        [$start1, $end1] = explode('-', $range1);
        [$start2, $end2] = explode('-', $range2);
        
        try {
            $start1 = \Carbon\Carbon::createFromFormat('H:i', $start1);
            $end1 = \Carbon\Carbon::createFromFormat('H:i', $end1);
            $start2 = \Carbon\Carbon::createFromFormat('H:i', $start2);
            $end2 = \Carbon\Carbon::createFromFormat('H:i', $end2);
            
            return $start1 < $end2 && $end1 > $start2;
        } catch (\Exception) {
            return false;
        }
    }

    /**
     * Salva la disponibilità.
     */
    protected function saveAvailability(): void
    {
        $doctor = $this->getCurrentDoctor();
        $studio = $this->getCurrentStudio();
        $schedule = $this->data['schedule'] ?? [];
        
        // Trova o crea il record pivot
        $pivot = StudioUser::updateOrCreate([
            'user_id' => $doctor->id,
            'studio_id' => $studio->id,
        ], [
            'schedule' => $schedule,
        ]);
        
        // Log dell'operazione
        \Log::info('Doctor availability updated', [
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Invia notifica di successo.
     */
    protected function sendSuccessNotification(): void
    {
        Notification::make()
            ->title(__('saluteora::doctor_availability.notifications.saved.title'))
            ->body(__('saluteora::doctor_availability.notifications.saved.body'))
            ->success()
            ->send();
    }

    /**
     * Invia notifica di errore.
     */
    protected function sendErrorNotification(string $message): void
    {
        Notification::make()
            ->title(__('saluteora::doctor_availability.notifications.error.title'))
            ->body(__('saluteora::doctor_availability.notifications.error.body') . ': ' . $message)
            ->danger()
            ->send();
    }
}
