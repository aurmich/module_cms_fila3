<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\PatientResource\Pages;

//use Filament\Resources\Pages\Page;
use Filament\Pages\Page;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class PreviewAttachment extends Page
{

    public function mount($record, $type)
    {
        /*
        $this->record = Patient::findOrFail($record);
        $this->type = $type;
        $this->media = $this->record->getFirstMedia($type);

        if (!$this->media) {
            Notification::make()
                ->title('Documento non trovato')
                ->danger()
                ->send();
            abort(404);
        }
        */
        exit('ciao');
    }

    /*
    public function getDownloadUrl(): string
    {
        // Genera un URL temporaneo solo per l'utente autenticato
        return Storage::disk($this->media->disk)->temporaryUrl(
            $this->media->getPathRelativeToRoot(),
            now()->addMinutes(5)
        );
    }
        */
}