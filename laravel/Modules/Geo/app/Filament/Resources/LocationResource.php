<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Modules\Geo\Models\Location;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Geo\Filament\Resources\LocationResource\Pages;
use Modules\Geo\Filament\Resources\LocationResource\RelationManagers;
use Modules\Geo\Filament\Resources\LocationResource\Filters\RadiusFilter;
use Modules\Geo\Filament\Resources\LocationResource\Actions\RadiusAction;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Tables\Filters\FiltersLayout;

/**
 * Resource per la gestione dei luoghi geografici.
 *
 * Fornisce un'interfaccia completa per:
 * - Creazione di nuovi luoghi con coordinate geografiche
 * - Modifica dei dati esistenti
 * - Visualizzazione delle informazioni su mappa
 * - Ricerca per raggio geografico
 * - Gestione delle relazioni con altri modelli
 */
class LocationResource extends XotBaseResource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    // ✅ CORRETTO - NIENTE navigationGroup - La gestione è centralizzata in XotBaseResource

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

    // ✅ CORRETTO - NIENTE metodo table() - La gestione è centralizzata in XotBaseResource

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
