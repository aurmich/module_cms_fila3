<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Modules\SaluteOra\Models\Studio;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\SaluteOra\Filament\Resources\StudioResource\Pages;
use Modules\SaluteOra\Filament\Resources\StudioResource\RelationManagers;
use Modules\Geo\Models\Address;
use Modules\Geo\Filament\Resources\AddressResource;

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
                ->url()
                ->maxLength(255),

            'registration_number' => Forms\Components\TextInput::make('registration_number')
                ->maxLength(50),

            'vat_number' => Forms\Components\TextInput::make('vat_number')
                ->maxLength(30),

            'description' => Forms\Components\Textarea::make('description')
                ->maxLength(65535)
                ->columnSpanFull(),
            /*
            'opening_hours' => Forms\Components\Repeater::make('opening_hours')
                ->schema([
                    'day' => Forms\Components\Select::make('day')
                        ->options([
                            'monday' => 'studio-resource.fields.opening_hours.days.monday',
                            'tuesday' => 'studio-resource.fields.opening_hours.days.tuesday',
                            'wednesday' => 'studio-resource.fields.opening_hours.days.wednesday',
                            'thursday' => 'studio-resource.fields.opening_hours.days.thursday',
                            'friday' => 'studio-resource.fields.opening_hours.days.friday',
                            'saturday' => 'studio-resource.fields.opening_hours.days.saturday',
                            'sunday' => 'studio-resource.fields.opening_hours.days.sunday',
                        ])
                        ->required(),
                    'open' => Forms\Components\TimePicker::make('open')
                        ->seconds(false),
                    'close' => Forms\Components\TimePicker::make('close')
                        ->seconds(false),
                ])
                ->columnSpanFull(),

            'services' => Forms\Components\TagsInput::make('services')
                ->columnSpanFull(),

            'active' => Forms\Components\Toggle::make('active')
                ->default(true),
            */
            'addresses' => Forms\Components\Repeater::make('addresses')
                ->relationship('addresses')
                ->schema(\Modules\Geo\Filament\Resources\AddressResource::getFormSchema())
                /*
                ->itemLabel(fn (array $state): ?string =>
                    isset($state['route'], $state['locality'])
                        ? "{$state['route']}, {$state['locality']}"
                        : (isset($state['locality']) ? $state['locality'] : 'Indirizzo'))
                */
                ->columnSpanFull()
                ->defaultItems(1),
        ];
    }


}
