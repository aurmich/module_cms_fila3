<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Modules\SaluteOra\Enums\UserStateEnum;
use Spatie\MailTemplates\TemplateMailable;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Models\DoctorRegistrationWorkflow;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Modules\UI\Filament\Forms\Components\OpeningHoursField;
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

        //$submit_view = 'pub_theme::filament.wizard.submit-button';
        
        return [
            Forms\Components\Wizard::make([
                self::getPersonalInfoStep(),
                self::getStudioStep(), 
                self::getAvailabilityStep(),
            ])
            ->skippable(false)
            ->submitAction(static::getWizardSubmitAction())
            ->persistStepInQueryString()
            ->startOnStep(function($get){

                if($get('id')!==null){
                    return 2;
                }
                return 1;
            })
            ->live()
            ->columnSpanFull(),
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

            ]);
    }

    

    protected static function getStudioStep(): Forms\Components\Wizard\Step
    {
        // Non utilizzare $translationPrefix, ma direttamente il namespace di traduzione

        return Forms\Components\Wizard\Step::make('studio')
            ->icon('heroicon-o-envelope')
            
            ->schema([
                Forms\Components\Section::make('Dati Studio')
                ->relationship('studio')  
                ->schema(StudioResource::getFormSchema())
                ])
            //->visible(fn ($get) => $get('id')!==null)
            ;
    }

   

    protected static function getAvailabilityStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('availability')
            ->icon('heroicon-o-calendar')
            ->schema([
                'availability_section' => OpeningHoursField::make('schedule')
                    ->label(__('saluteora::doctor_availability.sections.weekly_availability'))
                    ->helperText(__('saluteora::doctor_availability.fields.is_available.help'))
                    ->columnSpanFull(),
                    
            ])
            ->visible(fn ($get) => $get('id')!==null)
            ;
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
