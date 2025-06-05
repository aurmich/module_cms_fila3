<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms\Form;
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
        $this->resource = XotData::make()->getUserTypeResourceClass($type);
        $this->model = $this->resource::getModel();
        $this->action=Str::of($this->model)->replace('\Models\\', '\Actions\\')->append('\RegisterAction')->toString();
        $this->form->fill();
    }


    public function getFormSchema(): array
    {
        return $this->resource::getFormSchemaWidget();
    }

    public function register()
    {
        $data = $this->form->getState();
        app($this->action)->execute($data);
        /*
        // Validazione dei dati
        $this->validate();

        // Creazione del dottore
        $doctor = \Modules\Patient\Models\Doctor::create([
            'full_name' => $data['full_name'] ?? ($data['first_name'] . ' ' . $data['last_name']),
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'certification' => $data['certification'] ?? null,
            'state' => \Modules\Patient\States\Pending::class, // Imposta lo stato iniziale
        ]);

        // Creazione del workflow di registrazione
        $workflow = \Modules\Patient\Models\DoctorRegistrationWorkflow::create([
            'doctor_id' => $doctor->id,
            'current_step' => 'personal_info_step',
            'status' => \Modules\Patient\Models\DoctorRegistrationWorkflow::STATUS_PENDING_MODERATION,
            'started_at' => now(),
            'last_interaction_at' => now(),
            'session_id' => session()->getId(),
        ]);

        // Invio email di conferma
        $this->sendConfirmationEmail($doctor);

        // Reindirizzamento alla pagina di conferma
        return redirect()->route('doctor.registration.confirmation');
        */
    }

    /**
     * Invia l'email di conferma della registrazione.
     */
    protected function sendConfirmationEmail(\Modules\Patient\Models\Doctor $doctor): void
    {
        $email = new \Modules\Notify\Emails\SpatieEmail($doctor, 'registration_pending');

        \Illuminate\Support\Facades\Mail::to($doctor->email)
            ->locale(app()->getLocale())
            ->send($email);
        session()->flash('message', 'Registrazione completata con successo. La tua richiesta è in attesa di moderazione.');
        $this->form->fill();
    }
}