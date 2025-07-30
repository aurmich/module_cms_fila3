<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

/**
 * Dashboard principale del modulo FormBuilder.
 *
 * Estende XotBaseDashboard per garantire:
 * - Filtri standardizzati e persistenti
 * - Gestione widget centralizzata
 * - Coerenza UI/UX tra moduli
 * - Pattern di navigazione uniforme
 *
 * Filosofia: "Una sola base per tutte le dashboard"
 * Politica: "Non avrai altra dashboard all'infuori di XotBase"
 * Religione: "La centralizzazione dei filtri porta alla serenità del codice"
 * Zen: "Semplicità nella dashboard, potenza nei widget"
 *
 * @see \Modules\FormBuilder\docs\filament\dashboard-implementation.md Documentazione completa
 */
class Dashboard extends XotBaseDashboard
{
    // ✅ NIENTE proprietà di navigazione - le Dashboard sono pagine speciali

    /**
     * Schema dei filtri specifici per il modulo FormBuilder.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public function getFiltersFormSchema(): array
    {
        return [
            DatePicker::make('startDate')
                ->label('Data Inizio')
                ->maxDate(fn (Get $get) => $get('endDate') ?: now()),
                
            DatePicker::make('endDate')
                ->label('Data Fine')
                ->minDate(fn (Get $get) => $get('startDate') ?: now())
                ->maxDate(now()),
                
            Select::make('formStatus')
                ->label('Stato Form')
                ->options([
                    'all' => 'Tutti gli stati',
                    'active' => 'Attivi',
                    'inactive' => 'Inattivi',
                    'draft' => 'Bozza',
                    'archived' => 'Archiviati',
                ])
                ->default('all'),
                
            Select::make('formCategory')
                ->label('Categoria Form')
                ->options([
                    'all' => 'Tutte le categorie',
                    'medical' => 'Medico',
                    'survey' => 'Sondaggio',
                    'contact' => 'Contatto',
                    'registration' => 'Registrazione',
                ])
                ->default('all'),
        ];
    }

    /**
     * Widget da visualizzare nell'header della dashboard.
     *
     * @return array<class-string>
     */
    public function getHeaderWidgets(): array
    {
        return [
            // Widget header specifici per FormBuilder
        ];
    }

    /**
     * Widget da visualizzare nel footer della dashboard.
     *
     * @return array<class-string>
     */
    public function getFooterWidgets(): array
    {
        return [
            // Widget footer specifici per FormBuilder
        ];
    }

    /**
     * Widget da visualizzare nella dashboard (metodo richiesto da Filament).
     *
     * @return array<class-string>
     */
    public function getWidgets(): array
    {
        return [
            // Widget principali della dashboard
        ];
    }
}