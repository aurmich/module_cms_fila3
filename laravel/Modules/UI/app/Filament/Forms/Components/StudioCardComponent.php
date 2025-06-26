<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Component;
use Illuminate\Contracts\View\View;
use Filament\Support\Concerns\HasExtraAttributes;

/**
 * Componente di visualizzazione di una singola card studio.
 * 
 * Questo componente rappresenta un singolo studio dentistico con tutte le sue informazioni
 * in un formato card visivamente accattivante.
 */
class StudioCardComponent extends Component
{
    use HasExtraAttributes;

    /**
     * La view Blade per il componente.
     */
    protected string $view = 'ui::filament.forms.components.studio-card';

    /**
     * L'ID dello studio
     */
    protected string|int $studioId;

    /**
     * Il nome dello studio
     */
    protected string $name;

    /**
     * L'indirizzo dello studio
     */
    protected ?string $address = null;

    /**
     * Il numero di telefono dello studio
     */
    protected ?string $phone = null;

    /**
     * La descrizione dello studio
     */
    protected ?string $description = null;

    /**
     * L'URL dell'immagine dello studio
     */
    protected ?string $imageUrl = null;

    /**
     * I servizi offerti dallo studio
     */
    protected array $services = [];

    /**
     * Se lo studio è selezionato o meno
     */
    protected bool $isSelected = false;

    /**
     * Crea un'istanza del componente.
     *
     * @param string $name Il nome del componente
     * @return static
     */
    public static function make(string $name): static
    {
        return app(static::class, ['name' => $name]);
    }

    /**
     * Imposta l'ID dello studio.
     *
     * @param string|int $id
     * @return $this
     */
    public function studioId(string|int $id): static
    {
        $this->studioId = $id;

        return $this;
    }

    /**
     * Imposta il nome dello studio.
     *
     * @param string $name
     * @return $this
     */
    public function studioName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Imposta l'indirizzo dello studio.
     *
     * @param string|null $address
     * @return $this
     */
    public function address(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Imposta il numero di telefono dello studio.
     *
     * @param string|null $phone
     * @return $this
     */
    public function phone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Imposta la descrizione dello studio.
     *
     * @param string|null $description
     * @return $this
     */
    public function description(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Imposta l'URL dell'immagine dello studio.
     *
     * @param string|null $imageUrl
     * @return $this
     */
    public function imageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Imposta i servizi offerti dallo studio.
     *
     * @param array $services
     * @return $this
     */
    public function services(array $services): static
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Imposta lo stato di selezione dello studio.
     *
     * @param bool $isSelected
     * @return $this
     */
    public function selected(bool $isSelected = true): static
    {
        $this->isSelected = $isSelected;

        return $this;
    }

    /**
     * Prepara i dati da passare alla view.
     *
     * @return array<string, mixed>
     */
    protected function viewData(): array
    {
        return [
            'studioId' => $this->studioId ?? null,
            'studioName' => $this->name ?? '',
            'address' => $this->address ?? '',
            'phone' => $this->phone ?? '',
            'description' => $this->description ?? '',
            'imageUrl' => $this->imageUrl ?? '',
            'services' => $this->services ?? [],
            'isSelected' => $this->isSelected ?? false,
        ];
    }
}
