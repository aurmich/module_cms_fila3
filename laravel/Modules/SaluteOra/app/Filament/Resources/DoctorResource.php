<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\User\Models\Device;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Modules\SaluteOra\Models\User;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\SaluteOra\Models\Doctor;
use Filament\Forms\Components\Select;
use Modules\SaluteOra\Models\Patient;
use Modules\Notify\Emails\SpatieEmail;
use Spatie\Permission\Traits\HasRoles;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Modules\SaluteOra\Enums\UserStateEnum;
use Spatie\MailTemplates\TemplateMailable;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Models\DoctorRegistrationWorkflow;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Modules\SaluteOra\Actions\ProcessDoctorModerationAction;
use Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Modules\SaluteOra\Filament\Resources\DoctorResource\RelationManagers;

/**
 * Class DoctorResource
 *
 * @package  Modules\Patient
 *
 * @property  string  $recordTitleAttribute
 */
class DoctorResource extends XotBaseResource
{
    protected static ?string $tenantOwnershipRelationshipName = 'studios';
    protected static bool $isTenantFilterable = true;
    protected static ?string $model = Doctor::class;



    public static function getFormSchema(): array
    {
        return static::getFormSchemaWidget();
    }


    public static function getFormSchemaWidget(): array
    {

        $submit_view = 'pub_theme::filament.wizard.submit-button';
        
        return [
            Forms\Components\Wizard::make([
                self::getPersonalInfoStep(),
                self::getModerationStep(),
                self::getContactsStep(),
                self::getProfessionalStep(),
                self::getAvailabilityStep(),
            ])
            ->skippable(false)
            ->submitAction(view($submit_view))
            //->persistStepsInQueryString()
            //->onStepChanged(function ($livewire, $step) {
                // Gestione del cambio step
            //})
            //->beforeStateDehydrated(function ($component, $state) {
                // Pre-processamento dei dati prima del salvataggio
            //})
            //->afterStateHydrated(function ($component, $state) {
                // Post-processamento dei dati dopo il caricamento
            //})
            ->live()
            ->columnSpanFull(),
        ];
    }

    protected static function getDocumentsSchema(): array
    {
        $attachments = Doctor::$attachments;
        $uuid=Str::uuid()->toString();
        $schema = [];
        foreach ($attachments as $attachment) {
            $schema[] = Forms\Components\FileUpload::make($attachment)
            //$schema[] = Forms\Components\SpatieMediaLibraryFileUpload::make($attachment)
                ->disk('local')
                //->collection($attachment)
                ->directory('documents/'.$attachment.'/'.$uuid)
                //->downloadable()
                //->openable()
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->maxSize(5120)
                ->required()
                ->reorderable()
                ->multiple()
                //->maxParallelUploads(10)
                ->preserveFilenames() // mantiene il nome file
                //->temporaryUploadDirectory('tmp')
                //->saveUploadedFileNames()
                ->columnSpanFull()
                //->live(false) // Disabilita la validazione live
                //->reactive(false); // Disabilita la reattività
                //->reactive() // <-- Mantiene lo stato tra i reload
                //->live() // <-- Aggiornamento in tempo reale
                //->storeFiles(false) // <-- IMPEDISCE la cancellazione automatica dei file
                ->afterStateUpdated(function ($state, Forms\Set $set) use ($attachment) {
                    if (!$state) return;
            
                    $sessionId = session()->getId();
                    $sessionDir = "session-uploads/{$sessionId}";
                    $sessionFiles = [];
                    
                    foreach ($state as $file) {
                        if ($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                            // Salva direttamente nella directory di sessione
                            $fileName = time() . '_' . $file->getClientOriginalName();
                            $sessionPath = $file->storeAs($sessionDir, $fileName, 'local');
                            $sessionFiles[] = $sessionPath;
                        } else {
                            // È già un percorso salvato
                            $sessionFiles[] = $file;
                        }
                    }
                    
                    $set($attachment, $sessionFiles);
                })
                /*
                ->default(function (?Model $record){
                    $res=$record?->getFirstMediaUrl('certifications');
                    return $res;
                } )
                ->formatStateUsing(function ($state,$record,$model) {
                    $res=$record?->getFirstMediaUrl('certifications');
                    dddx(['state'=>$state,'record'=>$record,'model'=>$model,'request'=>$request]);
                    return $state;
                    
                    //$res= asset('/storage/1/01JXJ9T3NJ22VXZRW98FJQEF6Q.pdf');
                    $res= TemporaryUploadedFile::createFromLivewire(
                        Storage::disk('public')->path('1/01JXJ9T3NJ22VXZRW98FJQEF6Q.pdf')
                    );
                    return $res;
                })
                    */
                /*
                ->state(function ($record) {
                    if ($record->document_url) {
                        return TemporaryUploadedFile::createFromLivewire(
                            Storage::disk('public')->path($record->document_url)
                        );
                    }
                    return null;
                })
                    */
                    /*
                    ->default(function (?Model $record){

                            return TemporaryUploadedFile::createFromLivewire(
                                Storage::disk('public')->path('1/01JXJ9T3NJ22VXZRW98FJQEF6Q.pdf')
                            );
                        }
                        
                    )
                        */
                //->afterStateUpdated(
                //    function (HasForms $livewire, SpatieMediaLibraryFileUpload $component, TemporaryUploadedFile //$state, Get $get, ?HasMedia $record) {
                //        dddx(['record'=>$record,'livewire'=>$livewire,'component'=>$component,'state'=>$state,//'get'=>$get,
                        //'a'=>self::$record,
                //    });
                //    }
                //)
                //->afterStateUpdated(function ($state){
                //    dddx($state);
                //})
                ;
        }
        return $schema;
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
                            ,
                        'last_name' => Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255)
                            ->autocomplete('family-name')
                            ,

                        'email' => Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->autocomplete('email')
                            //->unique(User::class)
                            ->unique(ignoreRecord: true)
                            ,
                        /*
                        'certifications' => Forms\Components\FileUpload::make('certifications')
                            ->required()
                            ->multiple()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120)
                            ->directory('certifications')
                            ,
                        */
                        ...self::getDocumentsSchema(),

                    ]),
            ])->visible(function ($model,$record) {
                return true;
            //dddx([$model,$record]);
            })

            ->afterValidation(function (Forms\Set $set, Form $form) {
                /*
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
                */
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
                                    ->downloadable()
                                    ->openable()
                                    ->reorderable()
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
        if ($doctor->state === UserStateEnum::APPROVED) {
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
    public static function resumeRegistration(int $doctorId, string $token): \Illuminate\Http\RedirectResponse
    {
        $doctor = Doctor::findOrFail($doctorId);
        if (hash_equals($doctor->continuation_token, $token) && $doctor->state === UserStateEnum::APPROVED) {
            return redirect()->route('filament.resources.doctors.edit', $doctor);
        }
        abort(403, 'Link non valido o scaduto.');
    }

    /**
     * @return array<class-string>
     */
    public static function getRelations(): array
    {
        return [
            //RelationManagers\StudiosRelationManager::class,
        ];
    }
}
