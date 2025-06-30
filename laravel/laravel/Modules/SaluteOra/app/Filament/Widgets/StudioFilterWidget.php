<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Livewire\Attributes\On;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Widget per la selezione e visualizzazione dello studio corrente.
 *
 * Permette ai dottori di:
 * - Visualizzare informazioni dello studio corrente
 * - Cambiare studio tra quelli disponibili
 * - Dispatchare eventi per notificare il cambio studio
 */
class StudioFilterWidget extends XotBaseWidget
{
    /**
     * La vista del widget.
     */
    protected static string $view = 'pub_theme::filament.widgets.studio-filter-widget';

    /**
     * ID dello studio attualmente selezionato.
     *
     * @var int|null
     */
    public ?int $currentStudioId = null;

    /**
     * Dati dello studio corrente.
     *
     * @var Studio|null
     */
    public ?Studio $currentStudio = null;

    /**
     * Lista degli studi disponibili per il dottore.
     *
     * @var \Illuminate\Support\Collection
     */
    public $availableStudios;

    /**
     * Mount del widget.
     */
    public function mount(): void
    {
        // Imposta lo studio corrente dal tenant di Filament o dal primo studio disponibile
        $this->currentStudioId = Filament::getTenant()?->id ?? $this->getFirstAvailableStudioId();
        $this->loadStudioData();
        
        // Inizializza il form se necessario
        if (method_exists($this, 'form')) {
            $this->form->fill();
        }
    }

    /**
     * Verifica se l'utente può visualizzare questo widget.
     * Override del metodo base per implementare la logica specifica.
     *
     * @return bool
     */
    public static function canView(): bool
    {
        $user = Auth::user();
        
        // Solo i dottori possono visualizzare questo widget
        return $user && 
               $user->type === UserTypeEnum::DOCTOR &&
               $user instanceof Doctor;
    }

    /**
     * Ottiene lo schema del form per questo widget.
     * Richiesto da XotBaseWidget, ma per questo widget non abbiamo un form.
     *
     * @return array<int|string, \Filament\Forms\Components\Component>
     */
    public function getFormSchema(): array
    {
        // Per questo widget non abbiamo un form vero e proprio
        // Restituiamo un array vuoto
        return [];
    }

    /**
     * Ottiene i dati da passare alla vista.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'currentStudio' => $this->currentStudio,
            'availableStudios' => $this->availableStudios,
            'doctor' => Auth::user(),
            'hasMultipleStudios' => $this->availableStudios && $this->availableStudios->count() > 1,
        ];
    }

    /**
     * Gestisce il cambio di studio.
     *
     * @param int $studioId
     * @return void
     */
    public function changeStudio(int $studioId): void
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Doctor)) {
            return;
        }

        // Verifica che il dottore possa accedere a questo studio
        $studio = $user->studios()->where('studios.id', $studioId)->first();
        
        if (!$studio) {
            $this->notification()
                ->title(__('saluteora::widgets.studio_filter.errors.unauthorized'))
                ->danger()
                ->send();
            return;
        }

        $this->currentStudioId = $studioId;
        $this->loadStudioData();

        // Dispatcha eventi per notificare altri componenti del cambio studio
        $this->dispatch('studio-changed', [
            'studioId' => $studioId,
            'studio' => $this->currentStudio->toArray(),
        ]);

        // Aggiorna anche il tenant di Filament se necessario
        if (Filament::getTenant()?->id !== $studioId) {
            session(['tenant_id' => $studioId]);
        }

        $this->notification()
            ->title(__('saluteora::widgets.studio_filter.messages.studio_changed'))
            ->body(__('saluteora::widgets.studio_filter.messages.studio_changed_body', [
                'studio' => $this->currentStudio->name
            ]))
            ->success()
            ->send();
    }

    /**
     * Listener per eventi esterni di cambio studio.
     *
     * @param array $data
     * @return void
     */
    #[On('studio-selected')]
    public function onStudioSelected(array $data): void
    {
        if (isset($data['studioId'])) {
            $this->changeStudio($data['studioId']);
        }
    }

    /**
     * Carica i dati dello studio corrente e la lista degli studi disponibili.
     *
     * @return void
     */
    protected function loadStudioData(): void
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Doctor)) {
            return;
        }

        // Carica gli studi disponibili per il dottore
        $this->availableStudios = $user->studios()
            ->with(['address'])
            ->where('active', true)
            ->orderBy('name')
            ->get();

        // Carica lo studio corrente
        if ($this->currentStudioId) {
            $this->currentStudio = $this->availableStudios
                ->where('id', $this->currentStudioId)
                ->first();
        }

        // Se non è stato trovato uno studio corrente, prendi il primo disponibile
        if (!$this->currentStudio && $this->availableStudios->isNotEmpty()) {
            $this->currentStudio = $this->availableStudios->first();
            $this->currentStudioId = $this->currentStudio->id;
        }
    }

    /**
     * Ottiene l'ID del primo studio disponibile per il dottore.
     *
     * @return int|null
     */
    protected function getFirstAvailableStudioId(): ?int
    {
        $user = Auth::user();
        
        if (!$user || !($user instanceof Doctor)) {
            return null;
        }

        $firstStudio = $user->studios()
            ->where('active', true)
            ->orderBy('name')
            ->first();

        return $firstStudio?->id;
    }

    /**
     * Refresh del widget per ricaricare i dati.
     *
     * @return void
     */
    public function refresh(): void
    {
        $this->loadStudioData();
    }

    /**
     * Ottiene le informazioni di contatto dello studio formattate.
     *
     * @return array<string, string>
     */
    public function getStudioContactInfo(): array
    {
        if (!$this->currentStudio) {
            return [];
        }

        return array_filter([
            'phone' => $this->currentStudio->phone,
            'email' => $this->currentStudio->email,
            'website' => $this->currentStudio->website,
        ]);
    }

    /**
     * Ottiene l'indirizzo completo dello studio.
     *
     * @return string|null
     */
    public function getStudioFullAddress(): ?string
    {
        if (!$this->currentStudio || !$this->currentStudio->address) {
            return $this->currentStudio?->address ?? null;
        }

        $address = $this->currentStudio->address;
        
        return trim(implode(', ', array_filter([
            $address->street ?? null,
            $address->city ?? null,
            $address->postal_code ?? null,
        ])));
    }
}
