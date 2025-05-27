<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources;

use Cheesegrits\FilamentGoogleMaps\Actions\RadiusAction;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Cheesegrits\FilamentGoogleMaps\Filters\RadiusFilter;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Geo\Filament\Resources\LocationResource\Pages;
use Modules\Geo\Models\Location;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Resource per la gestione dei luoghi.
 *
 * Questa classe gestisce l'interfaccia amministrativa per i luoghi,
 * fornendo funzionalità per la creazione, modifica e visualizzazione dei luoghi
 * sulla mappa.
 *
 * @property string|null $model           La classe del modello associato (Location)
 * @property string|null $navigationIcon  L'icona da mostrare nel menu di navigazione
 * @property string|null $navigationGroup Il gruppo di navigazione a cui appartiene
 * @property int|null    $navigationSort  L'ordine di visualizzazione nel menu
 */
class LocationResource extends XotBaseResource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Geo';

    protected static ?int $navigationSort = 2;

    /**
     * Converte le coordinate in formato float.
     *
     * @param array{lat?: string|float|null, lng?: string|float|null} $coordinates Le coordinate da convertire
     *
     * @return array{lat: float, lng: float} Le coordinate convertite in float
     */
    private static function formatCoordinates(array $coordinates): array
    {
        return [
            'lat' => (float) ($coordinates['lat'] ?? 0),
            'lng' => (float) ($coordinates['lng'] ?? 0),
        ];
    }

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('latitude')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('longitude')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('street')
                ->maxLength(255),
            Forms\Components\TextInput::make('city')
                ->maxLength(255),
            Forms\Components\TextInput::make('state')
                ->maxLength(255),
            Forms\Components\TextInput::make('zip')
                ->maxLength(255),
            Forms\Components\TextInput::make('formatted_address')
                ->maxLength(1024),

            Map::make('location')
                ->reactive()
                ->afterStateUpdated(function (array $state, callable $set, callable $get) {
                    $set('lat', $state['lat']);
                    $set('lng', $state['lng']);
                })
                ->drawingControl()
                ->defaultLocation([39.526610, -107.727261])
                ->mapControls([
                    'zoomControl' => true,
                ])
                ->debug()
                ->clickable()
                ->autocomplete('formatted_address')
                ->autocompleteReverse()
                ->reverseGeocode([
                    'city' => '%L',
                    'zip' => '%z',
                    'state' => '%A1',
                    'street' => '%n %S',
                ])
                ->geolocate()
                ->columnSpan(2),
        ];
    }

    /**
     * Definisce la tabella per la visualizzazione dei luoghi.
     *
     * La tabella include colonne per:
     * - Nome del luogo
     * - Indirizzo
     * - Città
     * - Stato
     * - CAP
     * Con funzionalità di ricerca e ordinamento per ogni colonna
     *
     * @param Table $table La tabella da configurare
     *
     * @return Table La tabella configurata
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street'),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('processed'),
                RadiusFilter::make('radius')
                    ->latitude('lat')
                    ->longitude('lng')
                    ->selectUnit()
                    ->section('Radius Search'),
            ]
            )
            ->filtersLayout(FiltersLayout::Dropdown)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                RadiusAction::make('radius'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * Definisce le relazioni disponibili per questo resource.
     *
     * @return array Le relazioni configurate
     */
    public static function getRelations(): array
    {
        return [
        ];
    }

    /**
     * Definisce le pagine disponibili per questo resource.
     *
     * Include le pagine per:
     * - Lista dei luoghi
     * - Creazione nuovo luogo
     * - Modifica luogo esistente
     *
     * @return array Le pagine configurate
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'view' => Pages\ViewLocation::route('/{record}'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
