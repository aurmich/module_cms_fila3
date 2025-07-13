<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Forms;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Webmozart\Assert\Assert;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Modules\SaluteOra\Models\Patient;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Form as FilamentForm;
use Modules\Xot\Filament\Traits\TransTrait;
use Filament\Widgets\Widget as FilamentWidget;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;

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
abstract class XotBaseWidget extends FilamentWidget implements HasForms,HasActions
{
    use TransTrait;
    use InteractsWithPageFilters;
    //use InteractsWithPageTable;
    use InteractsWithForms;
    use InteractsWithActions;

    public string $title = '';
    public string $icon = '';
    protected int|string|array $columnSpan = 'full';

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

    public function getFormFill(): array
    {
        $model = $this->getFormModel();
        if($model==null){
            return [];
        }
        if(is_string($model)){
            Assert::isInstanceOf($model=app($model),Model::class);
        }

       
        // Se il modello ha un ID, significa che è stato trovato nel database
        if ($model->exists) {
            try {
                
                //dddx($model->getArrayableRelations());
                $res= $model->toArray();
                
                if(method_exists($model,'getDataDefaults')){
                    $defaults=$model->getDataDefaults();
                    $merge1=array_merge($defaults,$res);
                    $merge1=Arr::map($merge1, function ($value, $key) use ($defaults) {
                        if($value==null){
                            $value=Arr::get($defaults,$key,null);
                        }
                        return $value;
                    });
                    $res=$merge1;
                }
                
                return $res;
                //dddx($model->with('studio')->relationsToArray());
                
            } catch (\Exception $e) {
                // Se toArray() fallisce (problemi con enum), usa getAttributes()
                //Log::warning("Errore in toArray() per modello {$this->model}: " . $e->getMessage());
                $attributes = $model->getAttributes();
                
                // Gestisci specificamente gli enum se presenti
                //if (isset($attributes['type']) && $model->type instanceof \BackedEnum) {
                //    $attributes['type'] = $model->type->value;
                //}
                
                return $attributes;
            }
        }
        
        // Se è un nuovo modello, restituisci solo i campi fillable con valori null
        $fillable = $model->getFillable();
        $appends = $model->getAppends();
        $attributes=$model->attributesToArray();
        
        $fields = array_merge($fillable, $appends);
        $fields= array_fill_keys($fields, null);
        $fields=array_merge($fields,$attributes);
        if(method_exists($model,'getDataDefaults')){
            $defaults=$model->getDataDefaults();
            $fields=array_merge($fields,$defaults);
        }
        
        return $fields;
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
     * Ottiene il modello per il form.
     * Può essere sovrascritto nelle classi figlie per fornire un modello specifico.
     *
     * @return \Illuminate\Database\Eloquent\Model|string|null
     */
    protected function getFormModel(): Model|string|null
    {
        return null;
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
        /*
        return (string) (static::$navigationLabel ?? (string) str(static::getLabel())
            ->headline());
        */
        return static::transFunc(__FUNCTION__);
    }

    protected function getStepByName(string $name): Forms\Components\Wizard\Step
    {
        $schema=Str::of($name)->snake()->studly()->prepend('get')->append('Schema')->toString();
        
        return Forms\Components\Wizard\Step::make($name)
            ->schema($this->$schema());
    }


    public function getWizardSubmitAction(): Action{
        $submit_view='pub_theme::filament.wizard.submit-button';
        return Action::make('submit')
            ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
            ->submit('save')
            ->view($submit_view);
    }
}
