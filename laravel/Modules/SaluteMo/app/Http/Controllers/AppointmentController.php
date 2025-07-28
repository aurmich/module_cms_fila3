<?php

declare(strict_types=1);

namespace Modules\SaluteMo\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\SaluteMo\Models\Appointment;
use Filament\Notifications\Notification;

class AppointmentController extends \Illuminate\Routing\Controller
{
    /**
     * Metodo per testare le azioni
     */
    public function prova(int $id): RedirectResponse
    {
        $appointment = Appointment::findOrFail($id);
        
        Notification::make()
            ->title('Test Azione')
            ->body("Record ID: {$id}")
            ->success()
            ->send();
            
        return back()->with('success', 'Azione eseguita con successo');
    }
} 