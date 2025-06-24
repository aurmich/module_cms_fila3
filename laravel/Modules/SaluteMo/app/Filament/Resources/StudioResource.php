<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Modules\SaluteOra\Models\Studio;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteMo\Filament\Resources\StudioResource\Pages;
use Modules\SaluteMo\Filament\Resources\StudioResource\RelationManagers;
use Modules\Geo\Models\Address;
use Modules\Geo\Filament\Resources\AddressResource;
use Filament\Forms\Components\Component;
use Modules\Geo\Filament\Forms\Components\AddressField;

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

   
}
