<?php

declare(strict_types=1);

namespace Modules\Media\Actions;

use Filament\Forms;
use Filament\Forms\Set;
use function Safe\glob;
use Filament\Forms\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Renderable;
use Modules\UI\Actions\Icon\GetAllIconsAction;
use Modules\Xot\Actions\ModelClass\CountAction;
use Filament\Resources\Resource as FilamentResource;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

/**
 *
 */
class SaveAttachmentsAction
{
    /**
     *
     */
    public function execute(HasMedia $record,array $attachments,array $data, string $disk='local'): void
    {
        $data_attachments = [];
        foreach ($attachments as $attachment) {
                /** @phpstan-ignore method.notFound */
                $media=$record->addMediaFromDisk($data[$attachment],$disk)
                    ->toMediaCollection($attachment);
                $data_attachments[$attachment]=$media->getPathRelativeToRoot();

        }
        $record->update($data_attachments); 
    }
}
