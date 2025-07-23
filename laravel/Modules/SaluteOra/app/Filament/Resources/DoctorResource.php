<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Modules\Geo\Filament\Forms\Components\AddressField;
use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Notify\Emails\SpatieEmail;
use Modules\SaluteOra\Actions\ProcessDoctorModerationAction;
use Modules\SaluteOra\Enums\UserStateEnum;
use Modules\SaluteOra\Filament\Resources\DoctorResource\Pages;
use Modules\SaluteOra\Filament\Resources\DoctorResource\RelationManagers;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\DoctorRegistrationWorkflow;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\User;
use Modules\UI\Filament\Forms\Components\OpeningHoursField;
use Modules\User\Models\Device;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Spatie\MailTemplates\TemplateMailable;
use Spatie\Permission\Traits\HasRoles;

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
         //$schema = parent::getFormSchema();

        // Aggiungi qui eventuali campi specifici per SaluteMo
        //return $schema;
        return [
        
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
                ,
                ...self::getAttachmentsSchema(false),
        ];
    }


    public static function getFormSchemaWidget(): array
    {
        
        return [
            Forms\Components\Wizard::make(self::getWizardSteps())
            ->skippable(false)
            ->submitAction(static::getWizardSubmitAction())
            ->persistStepInQueryString()
            //->startOnStep(fn(Get $get)=>static::getWizardStartOnStep($get))
            //->live()
            ->columnSpanFull(),
        ];
    }

    public static function getWizardStartOnStep(Get $get):int{
        if($get('id')!==null){
            return 0;
        }
        return 0;
    }

    public static function getWizardSteps():array{
        return [
            self::getStepByName('personal_info_step')
                ->icon('heroicon-o-user'),
            self::getStepByName('studio_step')
                ->icon('heroicon-o-building-office'),
            self::getStepByName('availability_step')
                ->icon('heroicon-o-calendar'),
            self::getStepByName('privacy_step')
                ->icon('heroicon-o-shield-check'),
        ];
    }            


    /**
     * Step UI allineato a /docs/images/13.md, 13.html, 13.blade.php
     * - Campo full_name per Nome e Cognome (come da convenzioni naming)
     * - FileUpload certification (Certificazione iscrizione Ordine)
     * - Nessun altro campo
     */
    protected static function getPersonalInfoStepSchema(): array
    {
        return [
            'id' => Forms\Components\Hidden::make('id'),
            'first_name' => Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255)
                ->autocomplete('given-name'),
                
            'last_name' => Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255)
                ->autocomplete('family-name'),

            'email' => Forms\Components\TextInput::make('email')
                ->required()
                ->email()
                ->maxLength(255)
                ->autocomplete('email')
                ->readonly(fn($get) => $get('id') !== null)
                ->extraAttributes(function ($get) {
                    return $get('id') !== null
                        ? ['class' => 'bg-gray-100 border-gray-300 cursor-not-allowed opacity-90']
                        : [];
                })
                ->rules(function ($get) {
                    return [
                        Rule::unique(User::class, 'email')->ignore($get('id'))
                    ];
                }),
                ...self::getAttachmentsSchema(false),
            /*
            // Download PDF per modulo privacy
            'download_privacy_form' => Forms\Components\Placeholder::make('download_privacy_form')
                ->label('')
                ->content(new \Illuminate\Support\HtmlString(
                    '<div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center justify-center">
                            <a href="' . asset('pdf/modulo-privacy-trattamento-dati.pdf') . '" 
                               target="_blank" 
                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                ' . __('saluteora::doctor.actions.download_privacy_form.label') . '
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 text-center mt-2">
                            ' . __('saluteora::doctor.actions.download_privacy_form.description') . '
                        </p>
                    </div>'
                ))
                ->columnSpanFull(),
            */
        ]  ;
    }

    

    protected static function getStudioStepSchema (): array
    {
        $schema = StudioResource::getFormSchemaForWizard();
        
        return [
                Forms\Components\Section::make('Dati Studio')
                ->relationship('studio')  
                ->schema($schema)
            ];
    }

   
    protected static function getAvailabilityStepSchema (): array
    {
        return [
                'availability_section' => OpeningHoursField::make('schedule')
                //    ->label(__('saluteora::doctor_availability.sections.weekly_availability'))
                    //->helperText(__('saluteora::doctor_availability.fields.is_available.help'))
                //    ->columnSpanFull(),
                    
            ];
    }


     /**
     * Get privacy step schema for the wizard
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    protected static function getPrivacyStepSchema(): array
    {
        return [
            'privacy_policy' => Forms\Components\View::make('pub_theme::gdpr.doctor-privacy-policy')
                ->columnSpanFull(),
            'privacy_acceptance' => Forms\Components\Checkbox::make('privacy_acceptance')
                ->required()
                ->rules(['accepted'])
                ->columnSpanFull(),
            //'newsletter' => Forms\Components\Checkbox::make('newsletter')
           //     ->columnSpanFull(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
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
