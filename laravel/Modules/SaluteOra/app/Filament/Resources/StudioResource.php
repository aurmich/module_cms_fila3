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
use Modules\Geo\Models\Address;
use Modules\Geo\Filament\Resources\AddressResource;

class StudioResource extends XotBaseResource
{
    protected static ?string $model = Studio::class;

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

    public static function getListTableColumns(): array
    {
        return [
            'name' => Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),

            'city' => Tables\Columns\TextColumn::make('addresses.locality')
                ->label('studio-resource.fields.addresses.locality')
                ->searchable()
                ->sortable(),

            'phone' => Tables\Columns\TextColumn::make('phone')
                ->searchable(),

            'email' => Tables\Columns\TextColumn::make('email')
                ->searchable(),

            'doctors_count' => Tables\Columns\TextColumn::make('doctors_count')
                ->counts('doctors')
                ->sortable(),

            'active' => Tables\Columns\ToggleColumn::make('active')
                ->sortable(),

            'created_at' => Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            'updated_at' => Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getListTableFilters(): array
    {
        return [
            'active' => Tables\Filters\SelectFilter::make('active')
                ->options([
                    '1' => 'studio-resource.filters.active.options.active',
                    '0' => 'studio-resource.filters.active.options.inactive',
                ])
                ->attribute('active'),

            'city' => Tables\Filters\SelectFilter::make('city')
                ->relationship('addresses', 'locality')
                ->searchable(),
        ];
    }

    public static function getListTableActions(): array
    {
        return [
            'edit' => Tables\Actions\EditAction::make(),

            'view' => Tables\Actions\ViewAction::make(),

            'activate' => Tables\Actions\Action::make('activate')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (Studio $record): bool => !$record->active)
                ->action(function (Studio $record): void {
                    $record->activate();
                }),

            'deactivate' => Tables\Actions\Action::make('deactivate')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (Studio $record): bool => $record->active)
                ->action(function (Studio $record): void {
                    $record->deactivate();
                }),

            'viewDoctors' => Tables\Actions\Action::make('viewDoctors')
                ->icon('heroicon-o-user-group')
                ->url(fn (Studio $record): string => route('filament.resources.doctors.index', [
                    'tableFilters[studio][value]' => $record->id,
                ])),

            'viewAppointments' => Tables\Actions\Action::make('viewAppointments')
                ->icon('heroicon-o-calendar')
                ->url(fn (Studio $record): string => route('filament.resources.appointments.index', [
                    'tableFilters[studio][value]' => $record->id,
                ])),
        ];
    }

    public static function getListBulkActions(): array
    {
        return [
            'delete' => Tables\Actions\DeleteBulkAction::make(),

            'activate' => Tables\Actions\BulkAction::make('activate')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                    foreach ($records as $record) {
                        $record->activate();
                    }
                }),

            'deactivate' => Tables\Actions\BulkAction::make('deactivate')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                    foreach ($records as $record) {
                        $record->deactivate();
                    }
                }),
        ];
    }

    public static function getInfolistSchema(): array
    {
        return [
            'basic_info' => Infolists\Components\Section::make('studio-resource.sections.basic_info')
                ->schema([
                    'name' => Infolists\Components\TextEntry::make('name'),
                    'description' => Infolists\Components\TextEntry::make('description')
                        ->columnSpanFull(),
                ]),

            'contact_info' => Infolists\Components\Section::make('studio-resource.sections.contact_info')
                ->schema([
                    'addresses' => Infolists\Components\RepeatableEntry::make('addresses')
                        ->schema([
                            'full_address' => Infolists\Components\TextEntry::make('getFormattedAddress')
                                ->label('studio-resource.fields.addresses.full_address'),
                            'is_primary' => Infolists\Components\IconEntry::make('is_primary')
                                ->boolean(),
                        ]),
                    'phone' => Infolists\Components\TextEntry::make('phone'),
                    'email' => Infolists\Components\TextEntry::make('email'),
                    'website' => Infolists\Components\TextEntry::make('website')
                        ->url(),
                ]),

            'fiscal_info' => Infolists\Components\Section::make('studio-resource.sections.fiscal_info')
                ->schema([
                    'registration_number' => Infolists\Components\TextEntry::make('registration_number'),
                    'vat_number' => Infolists\Components\TextEntry::make('vat_number'),
                ]),

            'operations' => Infolists\Components\Section::make('studio-resource.sections.operations')
                ->schema([
                    'services' => Infolists\Components\TextEntry::make('services'),
                    'active' => Infolists\Components\IconEntry::make('active')
                        ->boolean(),
                    'doctors_count' => Infolists\Components\TextEntry::make('doctors_count')
                        ->getStateUsing(fn ($state, Studio $record): int => $record->doctors()->count()),
                    'appointments_count' => Infolists\Components\TextEntry::make('appointments_count')
                        ->getStateUsing(fn ($state, Studio $record): int => $record->appointments()->count()),
                ]),
        ];
    }
}
