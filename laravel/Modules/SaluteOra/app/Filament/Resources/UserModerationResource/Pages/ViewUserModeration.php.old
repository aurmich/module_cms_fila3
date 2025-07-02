<?php

namespace Modules\SaluteOra\Filament\Resources\UserModerationResource\Pages;

use Modules\SaluteOra\Filament\Resources\UserModerationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;

class ViewUserModeration extends XotBaseViewRecord
{
    protected static string $resource = UserModerationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    
    public function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name')->label(__('saluteora::user.fields.name.label')),
            'email' => TextEntry::make('email')->label(__('saluteora::user.fields.email.label')),
            'state' => TextEntry::make('state')->label(__('saluteora::user.fields.state.label')),
            'last_action_by' => TextEntry::make('last_action_by')->label(__('saluteora::user.fields.last_action_by.label')),
            'last_action_at' => TextEntry::make('last_action_at')->label(__('saluteora::user.fields.last_action_at.label')),
            'last_reason' => TextEntry::make('last_reason')->label(__('saluteora::user.fields.last_reason.label')),
        ];
    }
}
