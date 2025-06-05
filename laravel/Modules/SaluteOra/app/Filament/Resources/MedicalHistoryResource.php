<?php

namespace Modules\SaluteOra\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class MedicalHistoryResource extends XotBaseResource
{
    protected static ?string $model = \Modules\SaluteOra\Models\MedicalHistory::class;

    public static function getFormSchema(): array
    {
        return [
            'condition' => Forms\Components\TextInput::make('condition')
                ->required()
                ->maxLength(255),
            'diagnosis_date' => Forms\Components\DatePicker::make('diagnosis_date')
                ->required(),
            'notes' => Forms\Components\RichEditor::make('notes')
                ->nullable(),
        ];
    }
}
