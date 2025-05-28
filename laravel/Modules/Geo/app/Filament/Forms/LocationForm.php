<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms;

use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Modules\Geo\App\Services\GeoDataService;

/**
 * Form per la selezione della località.
 * 
 * Questo form fornisce una selezione a cascata per regione, provincia, città e CAP.
 * 
 * @see \Modules\Geo\docs\json-database.md
 * @see Modules\Geo\Filament\Forms\LocationForm
 */
class LocationForm
{
    /**
     * Servizio per i dati geografici.
     */
    private GeoDataService $geoDataService;

    /**
     * Costruttore.
     */
    public function __construct()
    {
        $this->geoDataService = new GeoDataService();
    }

    /**
     * Ottiene lo schema del form.
     * 
     * @return array<string, Select>
     */
    public function getSchema(): array
    {
        return [
            Select::make('region')
                ->label('geo::fields.region.label')
                ->placeholder('geo::fields.region.placeholder')
                ->options(fn () => $this->geoDataService->getRegions())
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn () => $this->geoDataService->clearCache()),

            Select::make('province')
                ->label('geo::fields.province.label')
                ->placeholder('geo::fields.province.placeholder')
                ->options(fn (Get $get) => $this->geoDataService->getProvinces($get('region')))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn () => $this->geoDataService->clearCache())
                ->visible(fn (Get $get) => filled($get('region'))),

            Select::make('city')
                ->label('geo::fields.city.label')
                ->placeholder('geo::fields.city.placeholder')
                ->options(fn (Get $get) => $this->geoDataService->getCities($get('province')))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn () => $this->geoDataService->clearCache())
                ->visible(fn (Get $get) => filled($get('province'))),

            Select::make('cap')
                ->label('geo::fields.cap.label')
                ->placeholder('geo::fields.cap.placeholder')
                ->options(fn (Get $get) => [
                    $this->geoDataService->getCap($get('province'), $get('city')) => $this->geoDataService->getCap($get('province'), $get('city'))
                ])
                ->required()
                ->visible(fn (Get $get) => filled($get('city'))),
        ];
    }
} 