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
        return static::getFormSchemaWidget();
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
        ];
    }            


    /**
     * Step UI allineato a /docs/images/13.md, 13.html, 13.blade.php
     * - Campo full_name per Nome e Cognome (come da convenzioni naming)
     * - FileUpload certification (Certificazione iscrizione Ordine)
     * - Nessun altro campo
     */
    protected static function getPersonalInfoStepSchema (): array
    {
        // Non utilizzare $translationPrefix, ma direttamente il namespace di traduzione

        return [
                'id' => Forms\Components\Hidden::make('id'),
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
                    ->readonly(fn($get) => $get('id') !== null)
                    ->extraAttributes(function ($get) {
                        return $get('id') !== null
                            ? ['class' => 'bg-gray-100 border-gray-300 cursor-not-allowed opacity-90']
                            : [];
                    })
                    ->rules(function ($get) {
                        $rules = [];
                        // Applica unique solo se il record è nuovo (id è null)
                        //if ($get('id') === null) {
                            //$rules[] = Rule::unique(User::class, 'email');
                            $rules[] = Rule::unique(User::class,'email')->ignore($get('id'));
                        //}
                        
                        return $rules;
                    }),
                ...self::getAttachmentsSchema(false),

            ];
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
