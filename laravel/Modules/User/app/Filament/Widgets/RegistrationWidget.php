<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Widgets\Widget;
use Modules\Xot\Datas\XotData;
use Livewire\Attributes\Validate;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\Registered;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
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
    protected static string $view = 'pub_theme::filament.widgets.registration';

    public function mount(string $type): void
    {
        $this->type = $type;
        $this->resource = XotData::make()->getUserResourceClassByType($type);
        $this->model = $this->resource::getModel();
        $this->action=Str::of($this->model)->replace('\Models\\', '\Actions\\')->append('\RegisterAction')->toString();
        $obj=app($this->model);
        $fields=array_merge($obj->getFillable(),$obj->getAppends());
        $fieldsWithNulls = Arr::mapWithKeys($fields, fn($field) => [$field=>null]);
        $this->form->fill($fieldsWithNulls);
    }


    public function getFormSchema(): array
    {
        return $this->resource::getFormSchemaWidget();
    }

    public function register()
    {
        $data = $this->form->getState();
        $user=app($this->action)->execute($data);
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
