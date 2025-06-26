<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;

/**
 * Componente per la selezione di studi odontoiatrici tramite pulsanti.
 * 
 * Questo componente visualizza una serie di card cliccabili che rappresentano
 * gli studi odontoiatrici. Al click, il pulsante popola un campo Hidden con l'ID dello studio.
 */
class StudioSelectorButtons extends Field
{
    /**
     * La view Blade per il componente.
     */
    protected string $view = 'ui::filament.forms.components.studio-selector-buttons';

    /**
     * Filtri geografici per gli studi.
     */
    protected array $filters = [];

    /**
     * Crea un'istanza del componente.
     *
     * @param string $name
     * @return static
     */
    public static function make(string $name): static
    {
        return app(static::class, ['name' => $name]);
    }

    /**
     * Imposta i filtri geografici per gli studi.
     *
     * @param array $filters
     * @return $this
     */
    public function filteredBy(array $filters): static
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Determina gli studi da visualizzare in base ai filtri.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getFilteredStudios(): array
    {
        $region = $this->filters['region'] ?? null;
        $province = $this->filters['province'] ?? null;
        $cap = $this->filters['cap'] ?? null;
        
        // Log per il debug
        \Illuminate\Support\Facades\Log::info('StudioSelectorButtons filtering studios', [
            'filters' => $this->filters,
            'component_id' => $this->getId()
        ]);
        
        // Se non ci sono filtri sufficienti, restituiamo un array vuoto
        if (!$cap) {
            return [];
        }
        
        try {
            // Cerca studi con i filtri geografici
            $studiosQuery = \Modules\SaluteOra\Models\Studio::query()
                ->where('active', true)
                ->with('address');
                
            // Applica filtro per CAP se presente
            if ($cap) {
                $studiosQuery->whereHas('address', function($q) use ($cap) {
                    $q->where('postal_code', $cap);
                });
            }
            
            // Esegui la query
            $studios = $studiosQuery->get();
            
            // Se non abbiamo risultati, allentiamo i filtri
            if ($studios->isEmpty() && $province) {
                \Illuminate\Support\Facades\Log::info('Nessuno studio trovato con CAP, provo con la provincia');
                
                // Prova solo con la provincia
                $studios = \Modules\SaluteOra\Models\Studio::query()
                    ->where('active', true)
                    ->with('address')
                    ->whereHas('address', function($q) use ($province) {
                        $q->where('administrative_area_level_3', $province);
                    })
                    ->limit(5)
                    ->get();
            }
            
            // Debug log
            \Illuminate\Support\Facades\Log::info('Studios found:', [
                'count' => $studios->count(), 
                'filter_cap' => $cap
            ]);
            
            // Trasforma i modelli in array per la visualizzazione
            return $studios->map(function($studio) {
                return [
                    'id' => $studio->id,
                    'name' => $studio->name,
                    'address' => $studio->address ? $studio->address->formatted_address : 'Indirizzo non disponibile',
                    'phone' => $studio->phone ?? 'Telefono non disponibile',
                ];
            })->toArray();
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error fetching studios: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return [];
        }
    }

    /**
     * Ottiene i componenti figli.
     *
     * @return array<Component>
     */
    public function getChildComponents(): array
    {
        return [
            Hidden::make($this->getName())
                ->id("studio-selector-{$this->getName()}")
                ->reactive(),
        ];
    }

    /**
     * Crea un'istanza del componente con extra view data.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->extraAttributes([
            'class' => 'filament-studio-selector',
        ]);
        
        // Aggiungiamo i dati necessari alla vista
        $this->afterStateHydrated(function () {
            // Assicuriamoci che questi dati siano disponibili nella vista
            $this->extraViewData([                
                'studios' => $this->getFilteredStudios(),
                'componentId' => $this->getId(),
                'statePath' => $this->getStatePath(),
            ]);
        });
    }
}
