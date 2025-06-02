<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Pages;

use Carbon\CarbonInterval;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Filament\Widgets\DoctorAvailabilityCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\User;
use Modules\Xot\Filament\Pages\XotBasePage;
use Filament\Actions\Action as FilamentAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

/**
 * DoctorAvailabilityCalendar
 *
 * Pagina Filament che implementa un calendario FullCalendar per permettere ai dottori di:
 * 1. Gestire le proprie disponibilità (aggiungere/modificare/eliminare)
 * 2. Visualizzare gli appuntamenti dei pazienti
 * 3. Approvare o rifiutare gli appuntamenti
 */
class DoctorAvailabilityCalendar extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'saluteora::appointment.pages.availability.navigation_label';
    protected static ?string $navigationGroup = 'saluteora::appointment.navigation.agenda';

    protected static string $view = 'saluteora::filament.pages.doctor-availability-calendar';

    /**
     * Ottenere il titolo della pagina.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return __('saluteora::appointment.pages.availability.title');
    }

    /**
     * Ottenere la descrizione dell'header.
     *
     * @return string
     */
    public function getHeading(): string
    {
        return __('saluteora::appointment.pages.availability.heading');
    }

    /**
     * Ottenere la descrizione della pagina.
     *
     * @return string|null
     */
    public function getSubheading(): ?string
    {
        return __('saluteora::appointment.pages.availability.subheading');
    }

    /**
     * Registrare le azioni della pagina.
     *
     * @return array<FilamentAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            FilamentAction::make('refresh')
                ->label(__('saluteora::appointment.actions.refresh'))
                ->action(fn () => $this->refresh())
                ->icon('heroicon-o-arrow-path'),
            FilamentAction::make('legenda')
                ->label(__('saluteora::appointment.actions.legend.label'))
                ->modalHeading(__('saluteora::appointment.actions.legend.modal_heading'))
                ->modalContent(view('saluteora::components.appointment-legend')),
        ];
    }

    /**
     * Crea il widget del calendario.
     *
     * @return DoctorAvailabilityCalendarWidget
     */
    protected function calendarWidget(): DoctorAvailabilityCalendarWidget
    {
        $doctor = $this->getCurrentDoctor();
        $studio = Filament::getTenant();

        return new DoctorAvailabilityCalendarWidget($doctor, $studio);
    }

    /**
     * Registrare i widget della pagina.
     *
     * @return array
     */
    protected function getHeaderWidgets(): array
    {
        return [
            $this->calendarWidget(),
        ];
    }

    /**
     * Restituisce l'utente autenticato come dottore (STI/Parental).
     * Doctor non è una tabella separata, ma un tipo di User (campo type o enum).
     * Motivazione: un solo punto di verità, nessuna duplicazione, DRY, KISS, serenità del codice.
     */
    protected function getCurrentDoctor(): User
    {
        $user = Filament::auth()->user();
        if (!$user || $user->type->value !== 'doctor') { // oppure enum UserTypeEnum::DOCTOR->value
            throw new \Exception('L\'utente corrente non è un dottore è un ['.$user->type->value.']');
        }
        return $user;
    }
}
