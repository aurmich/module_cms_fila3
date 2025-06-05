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
     * Registrare le azioni della pagina.
     *
     * @return array<FilamentAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            FilamentAction::make('refresh')
                ->action(fn () => $this->refresh())
                ->icon('heroicon-o-arrow-path'),
            FilamentAction::make('legenda')
                ->modalHeading(__('saluteora::appointment.actions.legend.modal_heading'))
                ->modalContent(view('saluteora::components.appointment-legend')),
        ];
    }


    /**
     * Registrare i widget della pagina.
     *
     * @return array
     */
    protected function getHeaderWidgets(): array
    {
        return [

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
