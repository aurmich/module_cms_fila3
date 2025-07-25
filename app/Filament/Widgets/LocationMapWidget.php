<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View as ViewFacade;
use Modules\Geo\Models\Place;
use Webbingbrasil\FilamentMaps\Widgets\MapWidget;

/**
 * Widget per visualizzare una mappa con una posizione.
 *
 * Questo widget estende MapWidget per mostrare una mappa interattiva
 * che può visualizzare una posizione specifica con un marker.
 * La mappa può essere configurata per mostrare diversi tipi di vista
 * (strada, satellite, ibrida) e può essere personalizzata con controlli
 * e stili specifici.
 */
class LocationMapWidget extends MapWidget
{
    protected static string $view = 'geo::filament.widgets.location-map-widget';

    protected function getView(): string
    {
        return static::$view;
    }

    protected int|string|array $columnSpan = 'full';

    public Htmlable|string|null $heading = 'Mappa';

    protected const CACHE_TTL = 3600;

    protected function getViewData(): array
    {
        return [
            'heading' => $this->heading,
            'maxHeight' => $this->getMaxHeight(),
            'options' => $this->getOptions(),
            'markers' => $this->getMarkers(),
        ];
    }

    /**
     * Restituisce l'altezza massima del widget.
     */
    protected function getMaxHeight(): ?string
    {
        return $this->maxHeight ?? '50vh';
    }

    /**
     * Restituisce le opzioni di configurazione della mappa.
     *
     * @return array<string, mixed>
     */
    protected function getOptions(): array
    {
        $config = Config::get('maps', []);

        return [
            'zoom' => (int) ($config['zoom'] ?? 12),
            'center' => $this->getMapCenter(),
            'mapTypeId' => (string) ($config['type'] ?? 'roadmap'),
            'mapTypeControl' => true,
            'streetViewControl' => true,
            'fullscreenControl' => true,
            'zoomControl' => true,
            'styles' => [],
        ];
    }

    /**
     * Restituisce i luoghi da visualizzare sulla mappa.
     *
     * @return Collection<int, Place>
     */
    /** @return Collection<int, Place> */
    /**
     * @return Collection<int, Place>
     */
    public function getPlaces(): Collection
    {
        /* @var Collection<int, Place> */
        return Place::with(['placeType', 'type'])->get();
    }

    /**
     * Restituisce i marker da visualizzare sulla mappa.
     *
     * @return array<int, array{
     *     position: array{lat: float, lng: float},
     *     title?: string,
     *     icon?: array{
     *         url: string,
     *         scaledSize: array{width: int, height: int}
     *     }
     * }>
     */
    /**
     * @return array<int, array{
     *     position: array{lat: float, lng: float},
     *     title: string,
     *     icon?: array{url: string, scaledSize: array{width: int, height: int}}
     * }>
     */
    public function getMarkers(): array
    {
        /* @var array<int, array{
         *     position: array{lat: float, lng: float},
         *     title: string,
         *     icon?: array{url: string, scaledSize: array{width: int, height: int}}
         * }> */
        return $this->getPlaces()->map(function (Place $place): array {
            return [
                'position' => [
                    'lat' => (float) $place->latitude,
                    'lng' => (float) $place->longitude,
                ],
                'title' => (string) ($place->name ?? 'Unnamed Place'),
                'icon' => $this->getMarkerIcon($place),
            ];
        })->all();
    }

    /**
     * Restituisce il centro della mappa.
     *
     * @return array{lat: float, lng: float}
     */
    protected function getMapCenter(): array
    {
        $config = Config::get('maps', []);
        $defaultLat = 45.4642;
        $defaultLng = 9.1900;

        return [
            'lat' => (float) ($config['center']['lat'] ?? $defaultLat),
            'lng' => (float) ($config['center']['lng'] ?? $defaultLng),
        ];
    }

    /**
     * Restituisce l'icona per un marker.
     *
     * @return array{url: string, scaledSize: array{width: int, height: int}}|null
     */
    /**
     * @return array{url: string, scaledSize: array{width: int, height: int}}|null
     */
    protected function getMarkerIcon(Place $place): ?array
    {
        /** @var array{
         *     icons?: array<string, array{
         *         url: string,
         *         size: array{int, int}
         *     }>
         * } $config */
        $config = Config::get('maps.markers', []);

        $placeType = $place->placeType;
        if (! $placeType) {
            return null;
        }

        /** @var string $slug */
        $slug = $placeType->slug;

        if (! isset($config['icons'][$slug])) {
            return null;
        }

        /** @var array{url: string, size: array{int, int}} $icon */
        $icon = $config['icons'][$slug];

        if (! isset($icon['url']) || ! is_string($icon['url'])) {
            return null;
        }

        return [
            'url' => asset($icon['url']),
            'scaledSize' => [
                'width' => (int) ($icon['size'][0] ?? 32),
                'height' => (int) ($icon['size'][1] ?? 32),
            ],
        ];
    }

    public function render(): View
    {
        return ViewFacade::make($this->getView(), $this->getViewData());
    }
}
