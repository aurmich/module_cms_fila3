<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Collection;
use Modules\SaluteOra\Models\Studio;

/**
 * Studio Selector Buttons Component.
 *
 * Displays studios as clickable cards/buttons and populates studio_id and doctor_id fields.
 */
class StudioSelectorButtons extends Field
{
    /**
     * La view Blade per il componente.
     */
    protected string $view = 'pub_theme::filament.forms.components.studio-selector-buttons';

    /**
     * Filtri geografici per gli studi.
     */
    protected array $filters = [];

    /**
     * Titolo della sezione.
     */
    protected string | Closure | null $sectionTitle = null;

    /**
     * Callback per ottenere gli studi.
     */
    protected Closure | Collection | null $studios = null;

    /**
     * Campo studio da popolare.
     */
    protected string | null $populatesStudioField = null;

    /**
     * Campo dottore da popolare.
     */
    protected string | null $populatesDoctorField = null;

    /**
     * Titolo dello stato vuoto.
     */
    protected string | Closure | null $emptyStateTitle = null;

    /**
     * Descrizione dello stato vuoto.
     */
    protected string | Closure | null $emptyStateDescription = null;

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
     * Imposta il titolo della sezione.
     */
    public function sectionTitle(string | Closure | null $title): static
    {
        $this->sectionTitle = $title;
        return $this;
    }

    /**
     * Imposta il callback per ottenere gli studi.
     */
    public function studios(Closure | Collection | null $studios): static
    {
        
        $this->studios = $studios;
        return $this;
    }

    /**
     * Imposta il campo studio da popolare.
     */
    public function populatesStudioField(string | null $fieldName): static
    {
        $this->populatesStudioField = $fieldName;
        return $this;
    }

    /**
     * Imposta il campo dottore da popolare.
     */
    public function populatesDoctorField(string | null $fieldName): static
    {
        $this->populatesDoctorField = $fieldName;
        return $this;
    }

    /**
     * Imposta il titolo dello stato vuoto.
     */
    public function emptyStateTitle(string | Closure | null $title): static
    {
        $this->emptyStateTitle = $title;
        return $this;
    }

    /**
     * Imposta la descrizione dello stato vuoto.
     */
    public function emptyStateDescription(string | Closure | null $description): static
    {
        $this->emptyStateDescription = $description;
        return $this;
    }

    /**
     * Get section title.
     */
    public function getSectionTitle(): ?string
    {
        return $this->evaluate($this->sectionTitle);
    }

    /**
     * Get studios collection.
     *
     * @return Collection<int, Studio>
     */
    public function getStudios(): Collection|\Illuminate\Support\Collection
    {

        $studios = $this->evaluate($this->studios);
        return $studios;

        
    }

    /**
     * Get studio field name.
     */
    public function getPopulatesStudioField(): ?string
    {
        return $this->populatesStudioField;
    }

    /**
     * Get doctor field name.
     */
    public function getPopulatesDoctorField(): ?string
    {
        return $this->populatesDoctorField;
    }

    /**
     * Get empty state title.
     */
    public function getEmptyStateTitle(): ?string
    {
        return $this->evaluate($this->emptyStateTitle);
    }

    /**
     * Get empty state description.
     */
    public function getEmptyStateDescription(): ?string
    {
        return $this->evaluate($this->emptyStateDescription);
    }

    /**
     * Setup del componente.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->extraAttributes([
            'class' => 'filament-studio-selector',
        ]);
    }
    
    /**
     * Get the view data for the component.
     *
     * @return array<string, mixed>
     */
    public function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'sectionTitle' => $this->getSectionTitle(),
            'studios' => $this->getStudios(),
            'studioField' => $this->getPopulatesStudioField(),
            'doctorField' => $this->getPopulatesDoctorField(),
            'emptyStateTitle' => $this->getEmptyStateTitle(),
            'emptyStateDescription' => $this->getEmptyStateDescription(),
        ]);
    }
} 