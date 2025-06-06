<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use Filament\Widgets\Widget;
use Modules\Xot\Datas\XotData;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Wizard;
use Modules\SaluteOra\Models\Patient;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Auth\Events\Registered;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Contracts\UserContract;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Modules\Xot\Actions\View\GetViewPathAction;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Patient\Filament\Components\HealthCardUpload;
use Modules\Xot\Filament\Resources\XotBaseResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PatientResource extends XotBaseResource
{
    protected static ?string $model = Patient::class;
    //protected static ?string $tenantOwnershipRelationshipName = 'tenants';
    //protected static ?string $tenantRelationshipName = 'studios';

    

    public static function getFormSchemaWidget(): array
    {
        $submit_view='pub_theme::filament.wizard.submit-button';
        if(!view()->exists($submit_view)){
            dddx([
                'submit_view'=>$submit_view,
                'path'=>app(GetViewPathAction::class)->execute($submit_view),
            ]);
        }
        return [
            Forms\Components\Wizard::make([
                self::getPersonalDataStep(),      // Step 1: Dati personali
                self::getDocumentsStep(),         // Step 2: Documenti
                self::getPreVisitStep(),          // Step 3: Informazioni preventive
                self::getPrivacyStep(),           // Step 4: Privacy e consensi
            ])
            ->extraAttributes(['class' => 'mobile-friendly-wizard'])
            ->skippable(false)
            ->columnSpan('full')
            ->submitAction(view($submit_view))
        ];
    }

    /**
     * Get the personal data step for the wizard
     *
     * @return \Filament\Forms\Components\Wizard\Step
     */
    protected static function getPersonalDataStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('personal_data_step')
            ->schema(self::getPersonalDataStepSchema());
    }

    protected static function getPersonalDataStepSchema(): array
    {
        return [
            Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('address')
                ->maxLength(255),
            Forms\Components\TextInput::make('city')
                ->maxLength(255),
            Forms\Components\TextInput::make('phone')
                ->tel()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255)
                ->unique(Patient::class),
        ];
    }

    /**
     * Get the documents step for the wizard
     *
     * @return \Filament\Forms\Components\Wizard\Step
     */
    protected static function getDocumentsStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('documents_step')
            ->schema(self::getDocumentsStepSchema());
    }

    protected static function getDocumentsStepSchema(): array
    {
        return [
            // Tessera Sanitaria
            Forms\Components\SpatieMediaLibraryFileUpload::make('health_card')
                ->collection('tessera_sanitaria')
                //->hint(__('saluteora::patient-resource.fields.health_card.hint'))
                //->hintIcon('heroicon-o-information-circle')
                ->downloadable()
                ->openable()
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->maxSize(5120)
                ->required()
                ->columnSpanFull(),

            // Documento di Identità
            Forms\Components\SpatieMediaLibraryFileUpload::make('identity_document')
                ->collection('documento_identita')
                //->hint(__('saluteora::patient-resource.fields.identity_document.hint'))
                //->hintIcon('heroicon-o-information-circle')
                ->downloadable()
                ->openable()
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->maxSize(5120)
                ->required()
                ->columnSpanFull(),

            // Certificazione ISEE
            Forms\Components\SpatieMediaLibraryFileUpload::make('isee_certificate')
                ->collection('certificazione_isee')
                //->hint(__('saluteora::patient-resource.fields.isee_certificate.hint'))
                //->hintIcon('heroicon-o-information-circle')
                ->downloadable()
                ->openable()
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->maxSize(5120)
                ->columnSpanFull(),

            // Certificato di Gravidanza
            Forms\Components\SpatieMediaLibraryFileUpload::make('pregnancy_certificate')
                ->collection('certificato_gravidanza')
                //->hint(__('saluteora::patient-resource.fields.pregnancy_certificate.hint'))
                //->hintIcon('heroicon-o-information-circle')
                ->downloadable()
                ->openable()
                ->preserveFilenames()
                ->acceptedFileTypes(['application/pdf', 'image/*'])
                ->maxSize(5120)
                ->columnSpanFull(),
        ];
    }

    /**
     * Get the pre-visit information step for the wizard
     */
    protected static function getPreVisitStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('pre_visit_step')
            ->schema(self::getPreVisitStepSchema());
    }

    protected static function getPreVisitStepSchema(): array
    {
        return [
            Forms\Components\DatePicker::make('last_dental_visit')
                ->maxDate(now()),
            Forms\Components\Textarea::make('dental_problems')
                ->maxLength(65535),
        ];
    }

    /**
     * Get the privacy step for the wizard
     */
    protected static function getPrivacyStep(): Forms\Components\Wizard\Step
    {
        return Forms\Components\Wizard\Step::make('privacy_step')
            ->schema(self::getPrivacyStepSchema());
    }

    /**
     * Get privacy step schema for the wizard
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    protected static function getPrivacyStepSchema(): array
    {
        return [
            Forms\Components\View::make('saluteora::privacy-policy')
                ->columnSpanFull(),
            Forms\Components\Checkbox::make('privacy_acceptance')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Checkbox::make('newsletter')
                ->columnSpanFull(),
        ];
    }

    /**
     * Get the thank you page HTML after registration
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function getThankYouPage(): HtmlString
    {
        return new HtmlString('<div class="p-8 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-blue-900 mb-4">Ti ringraziamo per esserti iscritta al portale</h2>
            <p class="text-gray-600 mb-6">Esamineremo i dati e i documenti che ci hai inviato e, se il tuo profilo risponde ai requisiti, riceverai una mail di conferma e potrai accedere al servizio.</p>
            <div class="mt-8">
                <a href="/" class="inline-block bg-blue-900 text-white text-lg font-medium py-3 px-6 rounded-full hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-opacity-50 shadow-sm hover:shadow-md transition-all duration-200">
                    TORNA ALLA HOME
                </a>
            </div>
        </div>');
    }

    /**
     * Get the form schema for standard forms
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'first_name' => Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),
            'last_name' => Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),
            'fiscal_code' => Forms\Components\TextInput::make('fiscal_code')
                ->required()
                ->maxLength(16),
            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            'phone' => Forms\Components\TextInput::make('phone')
                ->tel()
                ->required()
                ->maxLength(20),
        ];
    }

    public static function getThankYouView(): string
    {
        return 'saluteora::thank-you';
    }

    // I metodi getRelations() e getPages() sono stati rimossi perché:
    // 1. getRelations() restituisce un array vuoto
    // 2. getPages() contiene solo route standard
    // Secondo le regole del progetto questi metodi sono ridondanti quando estendi XotBaseResource
}
