<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\ReportResource\Pages;

use Filament\Actions;
use Filament\Infolists;
use Modules\SaluteOra\Models\Report;
use Illuminate\Notifications\Notifiable;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Filament\Notifications\Notification;

class ViewReport extends XotBaseViewRecord
{
    use Notifiable;

    protected static string $resource = \Modules\SaluteOra\Filament\Resources\ReportResource::class;

    protected function getInfolistSchema(): array
    {
        return [
            // Informazioni Generali
            Infolists\Components\Section::make('Informazioni Generali')
                ->schema([
                    Infolists\Components\TextEntry::make('patient.full_name')
                        ->label('Paziente')
                        ->placeholder('Paziente non specificato'),
                    Infolists\Components\TextEntry::make('appointment.scheduled_at')
                        ->label('Data Appuntamento')
                        ->dateTime()
                        ->placeholder('Appuntamento non specificato'),
                    Infolists\Components\TextEntry::make('created_at')
                        ->label('Data Creazione')
                        ->dateTime(),
                ])
                ->columns(3),

            // Dati Anagrafici
            Infolists\Components\Section::make('Dati Anagrafici')
                ->schema([
                    Infolists\Components\TextEntry::make('age')
                        ->label('Età')
                        ->placeholder('Età non specificata'),
                    Infolists\Components\TextEntry::make('gender')
                        ->label('Sesso')
                        ->badge()
                        ->formatStateUsing(fn (?string $state): string => $state === 'M' ? 'Maschio' : 'Femmina')
                        ->color(fn (?string $state): string => $state === 'M' ? 'blue' : 'pink'),
                    Infolists\Components\TextEntry::make('occupation')
                        ->label('Occupazione')
                        ->placeholder('Occupazione non specificata'),
                    Infolists\Components\TextEntry::make('education_level')
                        ->label('Livello di Istruzione')
                        ->placeholder('Livello di istruzione non specificato'),
                ])
                ->columns(2),

            // Stile di Vita
            Infolists\Components\Section::make('Stile di Vita')
                ->schema([
                    Infolists\Components\TextEntry::make('smoking_status')
                        ->label('Stato Fumatore')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Fumatore' : 'Non Fumatore')
                        ->color(fn (?bool $state): string => $state ? 'danger' : 'success'),
                    Infolists\Components\TextEntry::make('alcohol_consumption')
                        ->label('Consumo di Alcol')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Consumatore' : 'Non Consumatore')
                        ->color(fn (?bool $state): string => $state ? 'warning' : 'success'),
                    Infolists\Components\TextEntry::make('diet_type')
                        ->label('Tipo di Dieta')
                        ->placeholder('Tipo di dieta non specificato'),
                    Infolists\Components\TextEntry::make('physical_activity')
                        ->label('Attività Fisica')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Attivo' : 'Sedentario')
                        ->color(fn (?bool $state): string => $state ? 'success' : 'gray'),
                ])
                ->columns(2),

            // Condizioni Mediche
            Infolists\Components\Section::make('Condizioni Mediche')
                ->schema([
                    Infolists\Components\TextEntry::make('has_diseases')
                        ->label('Ha malattie')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Sì' : 'No')
                        ->color(fn (?bool $state): string => $state ? 'warning' : 'success'),
                    Infolists\Components\TextEntry::make('specify_diseases')
                        ->label('Malattie specificate')
                        ->formatStateUsing(function (?array $state): string {
                            if ($state === null || count($state) === 0) {
                                return 'Nessuna malattia specificata';
                            }
                            return collect($state)
                                ->map(fn ($disease) => is_string($disease) ? $disease : $disease->getLabel())
                                ->join(', ');
                        })
                        ->visible(fn (Report $record): bool => (bool) $record->has_diseases),
                ])
                ->columns(1)
                ->visible(fn (Report $record): bool => (bool) $record->has_diseases),

            // Denti Mancanti
            Infolists\Components\Section::make('Denti Mancanti')
                ->schema([
                    Infolists\Components\TextEntry::make('missing_teeth')
                        ->label('Ha denti mancanti')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Sì' : 'No')
                        ->color(fn (?bool $state): string => $state ? 'warning' : 'success'),
                    Infolists\Components\TextEntry::make('specify_missing_teeth')
                        ->label('Denti mancanti specificati')
                        ->formatStateUsing(function (?array $state): string {
                            if ($state === null || count($state) === 0) {
                                return 'Nessun dente specificato';
                            }
                            return collect($state)
                                ->map(fn ($tooth) => is_string($tooth) ? $tooth : $tooth->getLabel())
                                ->join(', ');
                        }),
                    Infolists\Components\TextEntry::make('more_info_missing_teeth')
                        ->label('Informazioni aggiuntive')
                        ->placeholder('Nessuna informazione aggiuntiva')
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->visible(fn (Report $record): bool => (bool) $record->missing_teeth),

            // Denti Cariati
            Infolists\Components\Section::make('Denti Cariati')
                ->schema([
                    Infolists\Components\TextEntry::make('decayed_teeth')
                        ->label('Ha denti cariati')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Sì' : 'No')
                        ->color(fn (?bool $state): string => $state ? 'danger' : 'success'),
                    Infolists\Components\TextEntry::make('specify_decayed_teeth')
                        ->label('Denti cariati specificati')
                        ->formatStateUsing(function (?array $state): string {
                            if ($state === null || count($state) === 0) {
                                return 'Nessun dente specificato';
                            }
                            return collect($state)
                                ->map(fn ($tooth) => is_string($tooth) ? $tooth : $tooth->getLabel())
                                ->join(', ');
                        }),
                    Infolists\Components\TextEntry::make('more_info_decayed_teeth')
                        ->label('Informazioni aggiuntive')
                        ->placeholder('Nessuna informazione aggiuntiva')
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->visible(fn (Report $record): bool => (bool) $record->decayed_teeth),

            // Protesi e Impianti
            Infolists\Components\Section::make('Protesi e Impianti')
                ->schema([
                    Infolists\Components\TextEntry::make('has_fixed_prosthesis_or_implants')
                        ->label('Ha protesi fissa o impianti')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Sì' : 'No')
                        ->color(fn (?bool $state): string => $state ? 'info' : 'gray'),
                    Infolists\Components\TextEntry::make('specify_prosthesis_or_implants')
                        ->label('Protesi/impianti specificati')
                        ->formatStateUsing(function (?array $state): string {
                            if ($state === null || count($state) === 0) {
                                return 'Nessuna protesi/impianto specificato';
                            }
                            return collect($state)
                                ->map(fn ($item) => is_string($item) ? $item : $item->getLabel())
                                ->join(', ');
                        }),
                    Infolists\Components\TextEntry::make('more_info_prosthesis')
                        ->label('Informazioni aggiuntive')
                        ->placeholder('Nessuna informazione aggiuntiva')
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->visible(fn (Report $record): bool => (bool) $record->has_fixed_prosthesis_or_implants),

            // Tartaro
            Infolists\Components\Section::make('Tartaro')
                ->schema([
                    Infolists\Components\TextEntry::make('has_tartar')
                        ->label('Ha tartaro')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Sì' : 'No')
                        ->color(fn (?bool $state): string => $state ? 'warning' : 'success'),
                    Infolists\Components\TextEntry::make('specify_tartar')
                        ->label('Tartaro specificato')
                        ->formatStateUsing(function (?array $state): string {
                            if ($state === null || count($state) === 0) {
                                return 'Nessun tartaro specificato';
                            }
                            return collect($state)
                                ->map(fn ($tooth) => is_string($tooth) ? $tooth : $tooth->getLabel())
                                ->join(', ');
                        }),
                    Infolists\Components\TextEntry::make('more_info_tartar')
                        ->label('Informazioni aggiuntive')
                        ->placeholder('Nessuna informazione aggiuntiva')
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->visible(fn (Report $record): bool => (bool) $record->has_tartar),

            // Placca
            Infolists\Components\Section::make('Placca')
                ->schema([
                    Infolists\Components\TextEntry::make('has_plaque')
                        ->label('Ha placca')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Sì' : 'No')
                        ->color(fn (?bool $state): string => $state ? 'warning' : 'success'),
                    Infolists\Components\TextEntry::make('specify_plaque')
                        ->label('Placca specificata')
                        ->formatStateUsing(function (?array $state): string {
                            if ($state === null || count($state) === 0) {
                                return 'Nessuna placca specificata';
                            }
                            return collect($state)
                                ->map(fn ($tooth) => is_string($tooth) ? $tooth : $tooth->getLabel())
                                ->join(', ');
                        }),
                    Infolists\Components\TextEntry::make('more_info_plaque')
                        ->label('Informazioni aggiuntive')
                        ->placeholder('Nessuna informazione aggiuntiva')
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->visible(fn (Report $record): bool => (bool) $record->has_plaque),

            // Necessità di Cure
            Infolists\Components\Section::make('Necessità di Cure Aggiuntive')
                ->schema([
                    Infolists\Components\TextEntry::make('needs_more_dental_care')
                        ->label('Necessita di ulteriori cure odontoiatriche')
                        ->badge()
                        ->formatStateUsing(fn (?bool $state): string => $state ? 'Sì' : 'No')
                        ->color(fn (?bool $state): string => $state ? 'warning' : 'success'),
                    Infolists\Components\TextEntry::make('further_notes')
                        ->label('Note aggiuntive')
                        ->placeholder('Nessuna nota aggiuntiva')
                        ->columnSpanFull(),
                ])
                ->columns(1)
                ->visible(fn (Report $record): bool => (bool) $record->needs_more_dental_care),

            // Informazioni Amministrative
            Infolists\Components\Section::make('Informazioni Amministrative')
                ->schema([
                    Infolists\Components\TextEntry::make('invoice')
                        ->label('Fattura')
                        ->placeholder('Nessuna fattura allegata'),
                    Infolists\Components\TextEntry::make('updated_at')
                        ->label('Ultimo Aggiornamento')
                        ->dateTime(),
                ])
                ->columns(2),
        ];
    }

    /**
     * Definisce le azioni disponibili nell'intestazione della pagina.
     *
     * @return array<\Filament\Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Modifica Questionario')
                ->icon('heroicon-o-pencil'),
                
            Actions\Action::make('view_patient')
                ->label('Visualizza Paziente')
                ->icon('heroicon-o-user')
                ->color('info')
                ->url(fn (Report $record): string => 
                    $record->patient ? 
                        route('filament.admin.resources.patients.view', ['record' => $record->patient]) : 
                        '#'
                )
                ->visible(fn (Report $record): bool => $record->patient !== null),
                
            Actions\Action::make('view_appointment')
                ->label('Visualizza Appuntamento')
                ->icon('heroicon-o-calendar')
                ->color('info')
                ->url(fn (Report $record): string => 
                    $record->appointment ? 
                        route('filament.admin.resources.appointments.view', ['record' => $record->appointment]) : 
                        '#'
                )
                ->visible(fn (Report $record): bool => $record->appointment !== null),
              /*  
            Actions\Action::make('print_report')
                ->label('Stampa Questionario')
                ->icon('heroicon-o-printer')
                ->color('gray')
                ->action(function (Report $record) {
                    // Implementazione stampa/PDF del questionario
                    Notification::make()
                        ->title('Funzionalità di stampa in sviluppo')
                        ->info()
                        ->send();
                }),
            */
        ];
    }
}
