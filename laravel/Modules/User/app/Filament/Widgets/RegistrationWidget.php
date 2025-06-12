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

class RegistrationWidget extends XotBaseWidget
{
    public ?array $data = [];
    protected int | string | array $columnSpan = 'full';
    public string $type;
    public string $resource;
    public string $model;
    public string $action;
    public UserContract $record;
    protected static string $view = 'pub_theme::filament.widgets.registration';

    public function mount(string $type,Request $request): void
    {
        $this->type = $type;
        $this->resource = XotData::make()->getUserResourceClassByType($type);
        $this->model = $this->resource::getModel();
        $this->action=Str::of($this->model)->replace('\Models\\', '\Actions\\')->append('\RegisterAction')->toString();
        $obj=app($this->model);
        //Assert::implementsInterface($obj,UserContract::class);
        Assert::isInstanceOf($obj,Model::class);
        $fields=array_merge($obj->getFillable(),$obj->getAppends());

        $fieldsWithNulls = Arr::mapWithKeys($fields, fn($field) => [$field=>null]);
        $this->form->fill($fieldsWithNulls);
        $this->form->model($obj);
        $this->record=$obj;

        $data=$request->all();
        $email=Arr::get($data,'email');//,'marco1@gmail.com';
        $token=Arr::get($data,'token');//'$2y$12$M9lZbLr8T.2GktlJjl1w6OoKHFX5MXnYV/ZePL7N4Rls0.pgkPczK';

        $user=$this->model::firstWhere('email',$email);
        if($user==null){
            return ;
        }
        $remember_token = $user->remember_token;
        if($remember_token==null){
            $user->remember_token=Str::uuid()->toString();
            $user->save();
        }
        
        if($remember_token==$token){

            $this->form->fill($user->toArray());
            $this->form->model($user);
            $this->record=$user;
        }
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
