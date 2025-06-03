<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\HtmlString;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\DoctorRegistrationWorkflow;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;
use Modules\SaluteOra\Actions\ProcessDoctorModerationAction;
use Illuminate\Support\Arr;
use Filament\Resources\Resource;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Spatie\MailTemplates\TemplateMailable;
use Illuminate\Support\Facades\Gate;

/**
 * Class DoctorResource
 *
 * @package  Modules\Patient
 *
 * @property  string  $recordTitleAttribute
 */
class DoctorResource extends XotBaseResource
{
    use HasRoles; // Aggiungo l'uso del trait HasRoles

    protected static ?string $model = Doctor::class;

    protected static ?string $translationPrefix = 'doctor-resource';

    public static function getFormSchema(): array
    {
        return static::getFormSchemaWidget();
    }

    /**
     * Get the submit button HTML for the wizard
     *
     * @return string
     */
    protected static function getSubmitButton(): string
    {
        return '<button type="submit" class="w-full bg-[#1A467F] text-white text-lg font-medium py-3 px-6 rounded-full shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center">
            <span>ACCETTA E CONTINUA</span>
        </button>';
    }

    public static function getFormSchemaWidget(): array
    {
        return [
            Forms\Components\Wizard::make([
                self::getPersonalInfoStep(),
                self::getModerationStep(),
                self::getContactsStep(),
                self::getProfessionalStep(),
                self::getAvailabilityStep(),
            ])
            ->skippable(false)
            ->submitAction(new HtmlString(self::getSubmitButton()))
            ->columnSpan('full')
            ->persistStepInQueryString()
            ->startOnStep(
                fn () => request()->has('token')
                    ? array_search('contacts', array_keys(DoctorRegistrationWorkflow::getSteps()))
                    : 0
            )
        ];
    }

    /**
     * Step UI allineato a /docs/images/13.md, 13.html, 13.blade.php
     * - Campo full_name per Nome e Cognome (come da convenzioni naming)
     * - FileUpload certification (Certificazione iscrizione Ordine)
     * - Nessun altro campo
     */
    protected static function getPersonalInfoStep(): Forms\Components\Wizard\Step
    {
        // Non utilizzare $translationPrefix, ma direttamente il namespace di traduzione

        return Forms\Components\Wizard\Step::make('personal_info')
            ->icon('heroicon-o-user')
            ->schema([
                'personal_section' => Forms\Components\Section::make()
                    ->schema([
                        'first_name' => Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255)
                            ->autocomplete('given-name')
                            ->placeholder(__('saluteora::doctor-resource.first_name')),
                        'last_name' => Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255)
                            ->autocomplete('family-name')
                            ->placeholder(__('saluteora::doctor-resource.last_name')),
                        'email' => Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->autocomplete('email')
                            ->placeholder(__('saluteora::doctor-resource.email')),
                        'certifications' => Forms\Components\FileUpload::make('certifications')
                            ->required()
                            ->multiple()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120)
                            ->directory('certifications')
                            ->placeholder(__('saluteora::doctor-resource.certifications')),
                    ]),
            ])
            
            ->afterValidation(function (Forms\Set $set, Form $form) {
                // Crea o recupera il workflow
                $workflow = DoctorRegistrationWorkflow::firstOrCreate(
                    ['session_id' => session()->getId()],
                    [
                        'current_step' => 'personal_info',
                        'status' => DoctorRegistrationWorkflow::STATUS_DRAFT,
                        'started_at' => now(),
                        'created_by' => Auth::id(),
                    ]
                );

                // Aggiorna lo stato
                $workflow->status = DoctorRegistrationWorkflow::STATUS_PENDING_MODERATION;
                $workflow->step_data = array_merge($workflow->step_data ?? [], [
                    'personal_info' => Arr::only($form->getState(), ['first_name', 'last_name', 'email', 'certification']),
                ]);
                $workflow->save();

                // Salva l'ID del workflow in sessione
                session(['doctor_registration_workflow_id' => $workflow->id]);

                // Invio email con il link di continuazione dopo la moderazione
                $data = $form->getState();
                $doctor = Doctor::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'] ?? '',
                    'phone' => $data['phone'] ?? '',
                    'state' => \Modules\SaluteOra\States\Pending::class,
                ]);
                self::sendContinuationLink($doctor);
            });
    }

    /**
     * Step di moderazione, visibile solo agli amministratori.
     */
    protected static function getModerationStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('moderation')
            ->icon('heroicon-o-shield-check')
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\View::make('saluteora::filament.doctor-moderation-summary')
                            ->visible(fn () => Auth::check() && Gate::allows('moderate_doctors')),

                        Forms\Components\Placeholder::make('moderation_status')
                            ->content(fn ($record) => $record->workflow?->status === DoctorRegistrationWorkflow::STATUS_PENDING_MODERATION
                                ? __('saluteora::doctor-resource.moderation.pending')
                                : ($record->workflow?->isModerationApproved()
                                    ? __('saluteora::doctor-resource.moderation.approved')
                                    : __('saluteora::doctor-resource.moderation.rejected'))),

                        Forms\Components\Textarea::make('moderation_notes')
                            ->visible(fn () => Auth::check() && Gate::allows('moderate_doctors'))
                            ->rows(3)
                            ->placeholder(__('saluteora::doctor-resource.moderation_notes')),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('approve')
                                        ->icon('heroicon-o-check')
                                        ->color('success')
                                        ->action(function ($record, Forms\Get $get) {
                                            app(ProcessDoctorModerationAction::class)->execute(
                                                $record->workflow,
                                                true,
                                                $get('moderation_notes'),
                                                Auth::id()
                                            );
                                        })
                                        ->requiresConfirmation()
                                        ->label(__('saluteora::doctor-resource.moderation.approve')),

                                    Forms\Components\Actions\Action::make('reject')
                                        ->icon('heroicon-o-x-mark')
                                        ->color('danger')
                                        ->action(function ($record, Forms\Get $get) {
                                            app(ProcessDoctorModerationAction::class)->execute(
                                                $record->workflow,
                                                false,
                                                $get('moderation_notes'),
                                                Auth::id()
                                            );
                                        })
                                        ->requiresConfirmation()
                                        ->label(__('saluteora::doctor-resource.moderation.reject')),
                                ])
                                ->visible(fn () => Auth::check() && Gate::allows('moderate_doctors')),
                            ]),
                    ]),
            ])
            ->visible(fn () => (Auth::check() && Gate::allows('moderate_doctors')) ||
                (session()->has('doctor_registration_workflow_id') &&
                DoctorRegistrationWorkflow::find(session('doctor_registration_workflow_id'))?->isPendingModeration()));
    }

    protected static function getContactsStep(): Forms\Components\Wizard\Step
    {
        // Non utilizzare $translationPrefix, ma direttamente il namespace di traduzione

        return Forms\Components\Wizard\Step::make('contacts')
            ->icon('heroicon-o-envelope')
            ->schema([
                'contacts_section' => Forms\Components\Section::make()
                    ->schema([
                        'contacts_grid' => Forms\Components\Grid::make(2)
                            ->schema([
                                'phone' => Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->required()
                                    ->placeholder(__('saluteora::doctor-resource.phone')),

                                'address' => Forms\Components\TextInput::make('address')
                                    ->required()
                                    ->placeholder(__('saluteora::doctor-resource.address')),

                                'city' => Forms\Components\TextInput::make('city')
                                    ->required()
                                    ->placeholder(__('saluteora::doctor-resource.city')),
                            ]),
                    ]),
            ])
            ->visible(fn () => request()->has('token') ||
                (session()->has('doctor_registration_workflow_id') &&
                DoctorRegistrationWorkflow::find(session('doctor_registration_workflow_id'))?->isModerationApproved()));
    }

    protected static function getProfessionalStep(): Forms\Components\Wizard\Step
    {
        // Non utilizzare $translationPrefix, ma direttamente il namespace di traduzione

        return Forms\Components\Wizard\Step::make('professional')
            ->icon('heroicon-o-academic-cap')
            ->schema([
                'professional_section' => Forms\Components\Section::make()
                    ->schema([
                        'professional_grid' => Forms\Components\Grid::make(2)
                            ->schema([
                                'registration_number' => Forms\Components\TextInput::make('registration_number')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder(__('saluteora::doctor-resource.registration_number')),

                                'certifications' => Forms\Components\FileUpload::make('certifications')
                                    ->multiple()
                                    ->directory('doctors/certifications')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(10240)
                                    ->columnSpanFull()
                                    ->placeholder(__('saluteora::doctor-resource.certifications')),
                            ]),
                    ]),
            ])
            ->visible(fn () => request()->has('token') ||
                (session()->has('doctor_registration_workflow_id') &&
                DoctorRegistrationWorkflow::find(session('doctor_registration_workflow_id'))?->isModerationApproved()));
    }

    protected static function getAvailabilityStep(): Forms\Components\Wizard\Step
    {
        // Non utilizzare $translationPrefix, ma direttamente il namespace di traduzione

        return Forms\Components\Wizard\Step::make('availability')
            ->icon('heroicon-o-calendar')
            ->schema([
                'availability_section' => Forms\Components\Section::make()
                    ->schema([
                        'availability_repeater' => Forms\Components\Repeater::make('availability')
                            ->schema([
                                'day' => Forms\Components\Select::make('day')
                                    ->options(\Modules\Xot\Enums\DayOfWeek::cases())
                                    ->getOptionLabelUsing(fn ($value) => __("xot::enums.day_of_week.{$value}"))
                                    ->placeholder(__('saluteora::doctor-resource.day')),

                                'start_time' => Forms\Components\TimePicker::make('start_time')
                                    ->seconds(false)
                                    ->required()
                                    ->placeholder(__('saluteora::doctor-resource.start_time')),

                                'end_time' => Forms\Components\TimePicker::make('end_time')
                                    ->seconds(false)
                                    ->required()
                                    ->placeholder(__('saluteora::doctor-resource.end_time')),
                            ])
                            ->columns(3)
                            ->defaultItems(1)
                            ->reorderable(false),
                    ]),
            ])
            ->visible(fn () => request()->has('token') ||
                (session()->has('doctor_registration_workflow_id') &&
                DoctorRegistrationWorkflow::find(session('doctor_registration_workflow_id'))?->isModerationApproved()));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }

    // Metodo per generare e inviare il link di continuazione dopo la moderazione
    public static function sendContinuationLink(Doctor $doctor): void
    {
        if ($doctor->state->isApproved()) {
            $token = sha1($doctor->email . now());
            $continuationUrl = URL::temporarySignedRoute(
                'doctor.registration.continue',
                now()->addDays(7),
                ['doctor' => $doctor->id, 'token' => $token]
            );

            // Invio email con il link di continuazione utilizzando SpatieEmail
            $email = new SpatieEmail($doctor, 'registration_moderated');
            Mail::to($doctor->email)->locale('it')->send($email);

            // Salva il token nel database per verifica successiva (opzionale)
            $doctor->update(['continuation_token' => $token]);
        }
    }

    // Metodo per riprendere la registrazione
    public static function resumeRegistration($doctorId, $token)
    {
        $doctor = Doctor::findOrFail($doctorId);
        if (hash_equals($doctor->continuation_token, $token) && $doctor->state->isApproved()) {
            return redirect()->route('filament.resources.doctors.edit', $doctor);
        }
        abort(403, 'Link non valido o scaduto.');
    }
}
