<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources;

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
use Modules\SaluteOra\Filament\Resources\StudioResource\Pages;
use Modules\SaluteOra\Filament\Resources\StudioResource\RelationManagers;
use Modules\Geo\Models\Address;
use Modules\Geo\Filament\Resources\AddressResource;
use Filament\Forms\Components\Component;

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

            'addresses' => Forms\Components\Repeater::make('addresses')
                ->relationship('addresses')
                ->schema(StudioResource::getAddressFormSchema())
                ->columnSpanFull()
                ->defaultItems(1)
                ->live()
                ->addActionLabel('Aggiungi Indirizzo'),
        ];
    }

    /**
     * Schema form personalizzato per gli indirizzi con logica condizionale per i campi name e is_primary.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    protected static function getAddressFormSchema(): array
    {
        $baseSchema = AddressResource::getFormSchema();

        // Campo name: visibile solo con più di 1 elemento
        $baseSchema['name'] = Forms\Components\TextInput::make('name')
            ->maxLength(255)
            ->visible(function (Get $get): bool {
                $addresses = $get('../../addresses') ?? [];
                return count($addresses) > 1;
            })
            ->live();

        // Campo is_primary: logica complessa per esclusività
        $baseSchema['is_primary'] = Forms\Components\Toggle::make('is_primary')
            ->visible(function (Get $get): bool {
                $addresses = $get('../../addresses') ?? [];
                return count($addresses) > 1;
            })
            ->default(function (Get $get): bool {
                $addresses = $get('../../addresses') ?? [];
                // Se è il primo elemento o c'è un solo elemento, default true
                return count($addresses) <= 1;
            })
            ->afterStateUpdated(function ($state, $set, Get $get, Component $component): void {
                // Se questo diventa primary, disattiva tutti gli altri
                if ($state === true) {
                    $addresses = $get('../../addresses') ?? [];

                    // Estrae l'indice dal path del componente (es. "addresses.0.is_primary")
                    $path = $component->getStatePath();
                    preg_match('/addresses\.(\d+)\.is_primary/', $path, $matches);
                    $currentIndex = $matches[1] ?? null;

                    if ($currentIndex !== null) {
                        // Disattiva is_primary negli altri elementi
                        foreach ($addresses as $index => $address) {
                            if ((string)$index !== (string)$currentIndex) {
                                $set("../../addresses.{$index}.is_primary", false);
                            }
                        }
                    }
                }
            })
            ->live()
            ->dehydrateStateUsing(function ($state, Get $get): bool {
                $addresses = $get('../../addresses') ?? [];
                // Se c'è un solo elemento, forza sempre true
                if (count($addresses) <= 1) {
                    return true;
                }
                return (bool) $state;
            });

        return $baseSchema;
    }
}
