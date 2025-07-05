<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Geo\Filament\Forms\LocationForm;

/**
 * Widget per la selezione della località.
 * 
 * Questo widget fornisce un form per la selezione della località utilizzando
 * il form LocationForm.
 * 
 * @see \Modules\Geo\docs\json-database.md
 */
class LocationWidget extends XotBaseWidget
{
    /**
     * Ordine di visualizzazione del widget.
     */
    protected static ?int $sort = 1;

    /**
     * Numero di colonne occupate dal widget.
     */
    protected int|string|array $columnSpan = 'full';

    /**
     * Dati del widget.
     */
    public ?array $data = [];

    /**
     * Titolo del widget.
     */
    public string $title = 'geo::widgets.location.title';

    /**
     * Vista del widget.
     */
    protected static string $view = 'geo::filament.widgets.location';

    /**
     * Icona del widget.
     */
    public string $icon = 'heroicon-o-map-pin';

    /**
     * Form per la selezione della località.
     */
    private \Modules\Geo\Filament\Forms\LocationForm $locationForm;

    /**
     * Costruttore.
     */
    public function __construct()
    {
        $this->locationForm = new \Modules\Geo\Filament\Forms\LocationForm();
    }

    /**
     * Inizializza il widget.
     * 
     * @return void
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Ottiene lo schema del form.
     * 
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        return $this->locationForm->getSchema();
    }

    /**
     * Gestisce l'invio del form.
     * 
     * @return void
     */
    public function submit(): void
    {
        $data = $this->form->getState();

        $this->dispatch('location-selected', $data);

        // Utilizzo metodo Livewire per notifiche
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('geo::widgets.location.messages.success')
        ]);
    }

    /**
     * Verifica se il widget può essere visualizzato.
     * 
     * @return bool
     */
    public static function canView(): bool
    {
        return true;
    }
} 