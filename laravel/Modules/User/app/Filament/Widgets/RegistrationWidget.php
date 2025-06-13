<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Widgets\Widget;
use Illuminate\Http\Request;
use Webmozart\Assert\Assert;
use Modules\Xot\Datas\XotData;
use Livewire\Attributes\Validate;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\Registered;
use Filament\Forms\Components\Checkbox;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Contracts\UserContract;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Illuminate\Support\Facades\Log;

class RegistrationWidget extends XotBaseWidget
{
    public ?array $data = [];
    protected int | string | array $columnSpan = 'full';
    public string $type;
    public string $resource;
    public string $model;
    public string $action;
    public Model $record;
    
    protected static string $view = 'pub_theme::filament.widgets.registration';

    public function mount(string $type,Request $request): void
    {
        $this->type = $type;
        $this->resource = XotData::make()->getUserResourceClassByType($type);
        $this->model = $this->resource::getModel();
        $this->action=Str::of($this->model)->replace('\Models\\', '\Actions\\')->append('\RegisterAction')->toString();
        $record=$this->getFormModel();
        $data=$this->getFormFill();
        $this->form->fill($data);
        $this->form->model($record);
        $this->data=$data;
        $this->record=$record;
    }

    public function getFormModel(): Model
    {
        $data=request()->all();
        $email=Arr::get($data,'email');//,'marco1@gmail.com';
        $token=Arr::get($data,'token');//'$2y$12$M9lZbLr8T.2GktlJjl1w6OoKHFX5MXnYV/ZePL7N4Rls0.pgkPczK';

        $user=$this->model::firstWhere('email',$email);
        if($user==null){
            return app($this->model);
        }
        $remember_token = $user->remember_token;
        if($remember_token==null){
            $user->remember_token=Str::uuid()->toString();
            $user->save();
        }
        
        if($remember_token==$token){
            $this->record=$user;
            return $user;
        }
        return app($this->model);
        
    }

    public function getFormFill(): array
    {
        $model = $this->getFormModel();
        
        // Se il modello ha un ID, significa che è stato trovato nel database
        if ($model->exists) {
            try {
                return $model->toArray();
            } catch (\Exception $e) {
                // Se toArray() fallisce (problemi con enum), usa getAttributes()
                Log::warning("Errore in toArray() per modello {$this->model}: " . $e->getMessage());
                $attributes = $model->getAttributes();
                
                // Gestisci specificamente gli enum se presenti
                if (isset($attributes['type']) && $model->type instanceof \BackedEnum) {
                    $attributes['type'] = $model->type->value;
                }
                
                return $attributes;
            }
        }
        
        // Se è un nuovo modello, restituisci solo i campi fillable con valori null
        $fillable = $model->getFillable();
        $appends = $model->getAppends();
        $fields = array_merge($fillable, $appends);
        
        return array_fill_keys($fields, null);
    }


    public function getFormSchema(): array
    {
        return $this->resource::getFormSchemaWidget();
    }

    /**
     * @see https://filamentphp.com/docs/3.x/forms/adding-a-form-to-a-livewire-component
     */
    public function register():\Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
    {
        $data = $this->form->getState();
        $record=$this->record;
       
        $user=app($this->action)->execute($record,$data);
        //$post = $this->model::create($this->form->getState());

        // Save the relationships from the form to the post after it is created.
        //$this->form->model($post)->saveRelationships();
        return redirect()->route('pages.view',['slug'=>$this->type.'_register_complete']);

    }

    /**
     * Invia l'email di conferma della registrazione.
     */
    protected function sendConfirmationEmail(\Modules\SaluteOra\Models\Doctor $doctor): void
    {
        $email = new \Modules\Notify\Emails\SpatieEmail($doctor, 'registration_pending');

        \Illuminate\Support\Facades\Mail::to($doctor->email)
            ->locale(app()->getLocale())
            ->send($email);
        session()->flash('message', 'Registrazione completata con successo. La tua richiesta è in attesa di moderazione.');
        $this->form->fill();
    }
}
