<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Modules\Geo\Models\Comune;
use Modules\Geo\Models\Address;
use Filament\Infolists\Infolist;
use Modules\SaluteOra\Models\Studio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Component;
use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Geo\Filament\Forms\Components\AddressField;
use Modules\SaluteOra\Filament\Resources\StudioResource\Pages;
use Modules\SaluteOra\Filament\Resources\StudioResource\RelationManagers;

class StudioResource extends XotBaseResource
{
    protected static ?string $model = Studio::class;
    //protected static ?string $tenantOwnershipRelationshipName = 'owner';
    //protected static ?string $tenantRelationshipName = 'blogPosts';
    protected static bool $isScopedToTenant = false;

    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            'phone' => Forms\Components\TextInput::make('phone')
                ->tel()
                ->maxLength(30),

            'email' => Forms\Components\TextInput::make('email')
                ->email()
                ->maxLength(100),

            'website' => Forms\Components\TextInput::make('website')
                //->url()
                ->maxLength(255),

            'registration_number' => Forms\Components\TextInput::make('registration_number')
                ->maxLength(50),

            'vat_number' => Forms\Components\TextInput::make('vat_number')
                ->maxLength(30),

            'description' => Forms\Components\Textarea::make('description')
                ->maxLength(65535)
                ->columnSpanFull(),
            
            'address' => AddressField::make('address')
                ->relationship('address'),
        ];
    }

    /**
     * Schema semplificato per wizard di creazione senza reattività
     * per prevenire loop infiniti quando il record non esiste ancora
     */
    public static function getFormSchemaForWizard(): array
    {
        $schema=self::getFormSchema();
        return $schema;
        
    }
}
