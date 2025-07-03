<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\States\Appointment\Confirmed;
use Modules\SaluteOra\States\Appointment\Pending;
use Modules\SaluteOra\States\Appointment\Rejected;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Widget per gestire gli appuntamenti del dottore.
 * 
 * Mostra gli appuntamenti in stato pending per il dottore loggato
 * con azioni per confermare o rifiutare gli appuntamenti.
 */
class DoctorAppointmentsWidget extends XotBaseWidget
{
    /**
     * Vista del widget.
     */
    protected static string $view = 'saluteora::filament.widgets.doctor-appointments-widget';

    /**
     * Schema del form per il widget.
     * 
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        // Questo widget non ha form, restituisce array vuoto
        return [];
    }

    /**
     * Ordinamento del widget.
     */
    protected static ?int $sort = 2;

    /**
     * Altezza massima del widget.
     */
    protected static ?string $maxHeight = '400px';

    /**
     * Appuntamenti caricati.
     *
     * @var Collection<int, Appointment>
     */
    public Collection $appointments;

    /**
     * Monta il widget.
     */
    public function mount(): void
    {
        $this->loadAppointments();
    }

    /**
     * Controlla se l'utente può visualizzare il widget.
     */
    public static function canView(): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        // Solo i dottori possono vedere questo widget
        if ($user->type !== UserTypeEnum::DOCTOR) {
            return false;
        }

        // Verificare tenancy per il dottore
        $tenant = Filament::getTenant();
        if (!$tenant) {
            return false;
        }

        return true;
    }

    /**
     * Carica gli appuntamenti pending per il dottore corrente.
     */
    private function loadAppointments(): void
    {
        $user = auth()->user();
        $tenant = Filament::getTenant();

        if (!$user || !$tenant) {
            $this->appointments = collect();
            return;
        }

        $cacheKey = $this->getCacheKey();

        $this->appointments = Cache::remember($cacheKey, 300, function () use ($user, $tenant) {
            return Appointment::query()
                ->with(['patient', 'doctor', 'studio'])
                ->where('doctor_id', $user->id)
                ->where('studio_id', $tenant->id)
                ->whereState('state', Pending::class)
                ->orderBy('starts_at', 'asc')
                ->limit(10)
                ->get();
        });
    }

    /**
     * Genera la chiave di cache per gli appuntamenti.
     */
    private function getCacheKey(): string
    {
        $user = auth()->user();
        $tenant = Filament::getTenant();

        return sprintf(
            'doctor_appointments_%d_%d',
            $user?->id ?? 0,
            $tenant?->id ?? 0
        );
    }

    /**
     * Conferma un appuntamento (transizione da Pending a Confirmed).
     */
    public function confirmAppointment(int $appointmentId): void
    {
        try {
            $appointment = $this->findAppointment($appointmentId);

            if (!$appointment || !$appointment->state->canTransitionTo(Confirmed::class)) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => __('saluteora::widgets.doctor_appointments.errors.cannot_confirm'),
                ]);
                return;
            }

            $appointment->state->transitionTo(Confirmed::class);

            $this->invalidateCache();
            $this->loadAppointments();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => __('saluteora::widgets.doctor_appointments.messages.appointment_confirmed'),
            ]);

        } catch (\Exception $e) {
            logger()->error('Error confirming appointment', [
                'appointment_id' => $appointmentId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('saluteora::widgets.doctor_appointments.errors.confirm_failed'),
            ]);
        }
    }

    /**
     * Rifiuta un appuntamento (transizione da Pending a Rejected).
     */
    public function rejectAppointment(int $appointmentId): void
    {
        try {
            $appointment = $this->findAppointment($appointmentId);

            if (!$appointment || !$appointment->state->canTransitionTo(Rejected::class)) {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => __('saluteora::widgets.doctor_appointments.errors.cannot_reject'),
                ]);
                return;
            }

            $appointment->state->transitionTo(Rejected::class);

            $this->invalidateCache();
            $this->loadAppointments();

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => __('saluteora::widgets.doctor_appointments.messages.appointment_rejected'),
            ]);

        } catch (\Exception $e) {
            logger()->error('Error rejecting appointment', [
                'appointment_id' => $appointmentId,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            $this->dispatch('notify', [
                'type' => 'error',
                'message' => __('saluteora::widgets.doctor_appointments.errors.reject_failed'),
            ]);
        }
    }

    /**
     * Trova un appuntamento per ID verificando che appartenga al dottore corrente.
     */
    private function findAppointment(int $appointmentId): ?Appointment
    {
        return $this->appointments->firstWhere('id', $appointmentId);
    }

    /**
     * Invalida la cache degli appuntamenti.
     */
    private function invalidateCache(): void
    {
        Cache::forget($this->getCacheKey());
    }

    /**
     * Refresh del widget quando ci sono cambiamenti.
     */
    #[On('appointment-updated')]
    public function refresh(): void
    {
        $this->invalidateCache();
        $this->loadAppointments();
    }
}
