<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Illuminate\Support\Str;
use Modules\Cms\Models\Attachment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Modules\Cms\Enums\AttachmentDiskEnum;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Modules\Cms\Filament\Resources\AttachmentResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class AttachmentResource extends LangBaseResource
{
    protected static ?string $model = Attachment::class;

    
    public static function getFormSchema(): array
    {
        return [
            'title' => TextInput::make('title')
                ->required()
                //->live(onBlur: true)
                //->afterStateUpdated(function ($state, callable $set) {
                //    $set('slug', Str::slug($state));
                //})
                ,
            
            'slug' => TextInput::make('slug')
                ->required()
                //->unique(ignoreRecord: true)
                ,
            'description' => Textarea::make('description'),
             'disk'=>Select::make('disk')->options(AttachmentDiskEnum::class),
            
            'attachment' => FileUpload::make('attachment')
                ->directory('attachments')
                ->preserveFilenames()
                ->maxSize(10240) // 10MB
                ->multiple(false)
                ->downloadable()
                ->openable()
                ->disk(fn (Get $get) => $get('disk'))
                //->getUploadedFileNameForStorageUsing(
                //    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                //),
        ];
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttachments::route('/'),
            'create' => Pages\CreateAttachment::route('/create'),
            'edit' => Pages\EditAttachment::route('/{record}/edit'),
        ];
    }    
}
