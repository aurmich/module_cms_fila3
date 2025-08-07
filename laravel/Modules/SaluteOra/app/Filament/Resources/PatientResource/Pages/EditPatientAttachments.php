<?php

namespace Modules\SaluteOra\Filament\Resources\PatientResource\Pages;



use Filament\Actions;
use Webmozart\Assert\Assert;
use Spatie\MediaLibrary\HasMedia;
use Modules\SaluteOra\Models\Patient;
use Modules\Media\Actions\SaveAttachmentsAction;
use Modules\SaluteOra\Filament\Resources\PatientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPatientAttachments extends XotBaseEditRecord
{
    protected static string $resource = PatientResource::class;

    
    public function getFormSchema(): array{
        return static::$resource::getAttachmentsSchema();
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $record = $this->record;
        $attachments = Patient::getAttachments();
        Assert::isInstanceOf($record,HasMedia::class);
        app(SaveAttachmentsAction::class)->execute($record,$attachments,$data);
    }
}
