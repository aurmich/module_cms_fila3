<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources\AppointmentResource\Pages;

use Modules\SaluteMo\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

/**
 * Pagina di modifica per gli appuntamenti.
 * 
 * Estende XotBaseEditRecord per ereditare le funzionalità di base
 * e personalizzare la gestione della modifica degli appuntamenti.
 */
class EditAppointment extends XotBaseEditRecord
{
    protected static string $resource = AppointmentResource::class;


    
}
