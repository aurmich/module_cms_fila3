<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\AppointmentWorkflowResource\Pages;

use Filament\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Resources\Pages\ListRecords;
use Modules\SaluteOra\Actions\InitiateAppointmentWorkflowAction;
use Modules\SaluteOra\Filament\Resources\AppointmentWorkflowResource;
use Modules\SaluteOra\Models\AppointmentWorkflow;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListAppointmentWorkflows extends XotBaseListRecords
{
    protected static string $resource = AppointmentWorkflowResource::class;

    /**
     * Define the table columns for the appointment workflows list.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),

            'patient' => TextColumn::make('patient.last_name')
                ->searchable()
                ->sortable(),

            'current_step' => TextColumn::make('current_step')
                ->formatStateUsing(function (string $state): string {
                    return match ($state) {
                        'patient_info' => 'Informazioni Paziente',
                        'dentist_selection' => 'Selezione Dentista',
                        'date_selection' => 'Selezione Data',
                        'treatment_definition' => 'Definizione Trattamento',
                        'confirmation' => 'Conferma',
                        default => ucfirst(str_replace('_', ' ', $state))
                    };
                })
                ->sortable(),

            'status' => BadgeColumn::make('status')
                ->colors([
                    'secondary' => AppointmentWorkflow::STATUS_DRAFT,
                    'warning' => AppointmentWorkflow::STATUS_PATIENT_INFO,
                    'info' => AppointmentWorkflow::STATUS_DENTIST_SELECTED,
                    'primary' => AppointmentWorkflow::STATUS_DATE_SELECTED,
                    'warning' => AppointmentWorkflow::STATUS_TREATMENT_DEFINED,
                    'success' => AppointmentWorkflow::STATUS_CONFIRMED,
                    'danger' => AppointmentWorkflow::STATUS_CANCELLED,
                ])
                ->formatStateUsing(function (string $state): string {
                    return match ($state) {
                        AppointmentWorkflow::STATUS_DRAFT => 'Bozza',
                        AppointmentWorkflow::STATUS_PATIENT_INFO => 'Info Paziente',
                        AppointmentWorkflow::STATUS_DENTIST_SELECTED => 'Dentista Selezionato',
                        AppointmentWorkflow::STATUS_DATE_SELECTED => 'Data Selezionata',
                        AppointmentWorkflow::STATUS_TREATMENT_DEFINED => 'Trattamento Definito',
                        AppointmentWorkflow::STATUS_CONFIRMED => 'Confermato',
                        AppointmentWorkflow::STATUS_CANCELLED => 'Cancellato',
                        default => ucfirst($state)
                    };
                })
                ->sortable(),

            'appointment' => TextColumn::make('appointment.title')
                ->searchable()
                ->sortable()
                ->placeholder('Non associato'),

            'started_at' => TextColumn::make('started_at')
                ->dateTime()
                ->sortable(),

            'completed_at' => TextColumn::make('completed_at')
                ->dateTime()
                ->sortable()
                ->placeholder('Non completato'),

            'session_id' => TextColumn::make('session_id')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Definisce le azioni nell'header della pagina.
     *
     * @return array<Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->after(function (array $data, $record): void {
                    // Dopo la creazione del record, inizializza il workflow
                    // con l'action Spatie QueueableAction
                    app(InitiateAppointmentWorkflowAction::class)->execute(
                        patient: $record->patient,
                        initialData: [],
                        userId: auth()->id()
                    );
                }),
        ];
    }
}
