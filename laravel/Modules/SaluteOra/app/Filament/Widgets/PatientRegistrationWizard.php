<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Support\HtmlString;
use Modules\SaluteOra\Models\Patient;

/**
 * Widget wizard per la registrazione di nuovi pazienti.
 * 
 * Implementa un processo guidato multi-step per raccogliere
 * tutte le informazioni necessarie per la registrazione.
 */
class PatientRegistrationWizard extends Component implements HasForms
{
    use InteractsWithForms;

    /**
     * Dati del form del wizard.
     *
     * @var array<string, mixed>
     */
    public ?array $data = [];



    /**
     * Inizializza il componente.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->form(Form::make($this))->fill();
    }

    /**
     * Configura il form del wizard.
     *
     * @param \Filament\Forms\Form $form
     * @return \Filament\Forms\Form
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    /**
     * Schema del form wizard.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Step::make('personal_data')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                        TextInput::make('fiscal_code')
                            ->required()
                            ->maxLength(16)
                            ->unique(Patient::class)
                            ->alpha()
                            ->columnSpanFull(),
                        DatePicker::make('birth_date')
                            ->required()
                            ->maxDate(now())
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Patient::class)
                                    ->columnSpan(1),
                                TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                    ]),

                Step::make('address')
                    ->icon('heroicon-o-home')
                    ->schema([
                        TextInput::make('address')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('city')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('postal_code')
                                    ->required()
                                    ->maxLength(20)
                                    ->columnSpan(1),
                                TextInput::make('province')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                        TextInput::make('country')
                            ->default('Italia')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Step::make('health_status')
                    ->icon('heroicon-o-heart')
                    ->schema([
                        Toggle::make('is_pregnant')
                            ->required()
                            ->inline(false)
                            ->columnSpanFull(),
                        Section::make('Dati ISEE')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('isee_code')
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                        TextInput::make('isee_value')
                                            ->numeric()
                                            ->prefix('€')
                                            ->columnSpan(1),
                                        DatePicker::make('isee_expiry_date')
                                            ->minDate(now())
                                            ->columnSpan(1),
                                    ]),
                            ])
                            ->collapsible()
                            ->columnSpanFull(),
                    ]),

                Step::make('privacy')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Section::make('Informativa sulla Privacy')
                            ->description(new HtmlString('
                                <div class="prose prose-sm">
                                    <p>Ai sensi dell\'art. 13 del Regolamento UE 2016/679 (GDPR), la informiamo che:</p>
                                    <ul>
                                        <li>I dati personali da Lei forniti saranno trattati per le finalità di gestione della Sua registrazione</li>
                                        <li>Il trattamento sarà effettuato con modalità informatizzate e manuali</li>
                                        <li>Il conferimento dei dati è obbligatorio per la registrazione al servizio</li>
                                        <li>I dati non saranno comunicati ad altri soggetti, né saranno oggetto di diffusione</li>
                                    </ul>
                                </div>
                            '))
                            ->columnSpanFull(),
                        Toggle::make('privacy_acceptance')
                            ->required()
                            ->inline(false)
                            ->columnSpanFull(),
                    ]),
            ])
                ->extraAttributes(['class' => 'mobile-friendly-wizard'])
            
                ->submitAction(new HtmlString('
                    <button type="submit" class="filament-button filament-button-size-lg inline-flex items-center justify-center py-2 gap-2 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                        Completa Registrazione
                    </button>
                '))
        ];
    }

    /**
     * Gestisce l'invio del form.
     *
     * @return void
     */
    public function submit(): void
    {
        /** @var array<string, mixed> $data */
        $data = $this->form(Form::make($this))->getState();

        $patient = Patient::create($data);

        $this->dispatch('patient-registered', patientId: $patient->id);
    }

    /**
     * Renderizza il componente.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('saluteora::widgets.patient-registration-wizard');
    }
}


