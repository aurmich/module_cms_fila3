<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Pages;

use Modules\Notify\Filament\Resources\MailTemplateResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;

class PreviewMailTemplate extends Page
{
    protected static string $resource = MailTemplateResource::class;

    protected static string $view = 'notify::filament.resources.mail-template-resource.pages.preview-mail-template';

    public function getTitle(): string
    {
        return __('notify::mail.template.preview.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('notify::mail.template.preview.actions.back.label'))
                ->icon(__('notify::mail.template.preview.actions.back.icon'))
                ->color(__('notify::mail.template.preview.actions.back.color'))
                ->url(fn () => MailTemplateResource::getUrl('edit', ['record' => $this->record])),
        ];
    }
} 