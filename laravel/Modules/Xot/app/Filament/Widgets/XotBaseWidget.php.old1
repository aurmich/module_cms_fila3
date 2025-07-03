<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Forms;
use Filament\Forms\Form as FilamentForm;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Widgets\Widget as FilamentWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;

/**
 * Classe base astratta per tutti i widget Filament.
 * Fornisce funzionalità comuni e standardizzate per la gestione dei widget.
 *
 * @property bool $shouldRender Indica se il widget deve essere renderizzato
 * @property string $title Titolo del widget
 * @property string $icon Icona del widget
 * @property array<string, mixed>|null $data Dati del form
 * @property ComponentContainer $form
 */
abstract class XotBaseWidget extends FilamentWidget implements HasForms
{
    use InteractsWithPageFilters;
    //use InteractsWithPageTable;
    use InteractsWithForms;

    public string $title = '';
    public string $icon = '';
    protected int|string|array $columnSpan = 'full';
    /**
     * La vista che deve essere renderizzata per il widget.
     * Può essere un namespace (es. 'module-name::view-name') o un percorso Blade.
     *
     * @var view-string
     */
    protected static string $view = '';

    /**
     * Lista degli eventi ascoltati dal widget.
     *
     * @var array<string, string>
     */
    public array $listener = [
        'filters-updated' => 'filtersUpdated',
    ];

    /**
     * Dati del form.
     *
     * @var array<string, mixed>
     */
    public ?array $data = [];

    /*
    public function __construct()
    {
        //parent::__construct();//Cannot call constructor
        $view = app(GetViewByClassAction::class)->execute(static::class);
        if(view()->exists($view)){
            $this->view = $view;
        }
    }
    */
    /*
    public function mount(): void
    {
        $this->form->fill();
    }
    */

    /**
     * Ottiene lo schema del form.
     * Deve essere implementato nelle classi figlie.
     *
     * @return array<int|string, \Filament\Forms\Components\Component>
     */
    abstract public function getFormSchema(): array;

    /**
     * Configura il form del widget.
     *
     * @param FilamentForm $form Il form da configurare
     * @return FilamentForm Il form configurato
     */
    public function form(FilamentForm $form): FilamentForm
    {
        $form = $form->schema($this->getFormSchema());
        $form->statePath('data');
        $data=$this->getFormFill();
        
        $form->model($this->getFormModel());
        if(!empty($data)){
           //$form->fill($data);
           //$this->data=$data;
        }
            
        

        return $form;
    }

    public function getFormFill(): array {
        return [];
    }

    /**
     * Gets the form model.
     * Can be overridden in child classes to provide a specific model.
     *
     * @return \Illuminate\Database\Eloquent\Model|string|null
     */
    protected function getFormModel(): Model|string|null
    {
        return null;
    }
    /**
     * Ottiene le azioni del form.
     *
     * @return array<int|string, Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    /**
     * Salva i dati del form.
     * Override nelle classi figlie se necessario.
     *
     * @return void
     */
    public function save(): void
    {
        // Implementare nelle classi figlie
    }

    /**
     * Eseguito quando i filtri vengono aggiornati.
     *
     * @return void
     */
    public function filtersUpdated(): void
    {
        $this->reset('data');
    }

    /**
     * {@inheritDoc}
     */
    public static function getNavigationLabel(): string
    {
        return (string) (static::$navigationLabel ?? (string) str(static::getLabel())
            ->headline());
    }
}
