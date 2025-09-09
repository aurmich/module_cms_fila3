<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources;

use Filament\Forms;
<<<<<<< HEAD
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Modules\Cms\Filament\Resources\AttachmentResource\Pages;
use Modules\Cms\Models\Attachment;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
=======
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
>>>>>>> bc33217 (.)

class AttachmentResource extends LangBaseResource
{
    protected static ?string $model = Attachment::class;

    
    public static function getFormSchema(): array
    {
        return [
            'title' => TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                //->afterStateUpdated(function ($state, callable $set) {
                //    $set('slug', Str::slug($state));
                //})
                ,
            
            'slug' => TextInput::make('slug')
                ->required()
                //->unique(ignoreRecord: true)
                ,
                
<<<<<<< HEAD
            'attachment' => FileUpload::make('attachment')
                ->directory('dev/attachments')
=======
            'description' => Textarea::make('description'),
            
            'disk' => Select::make('disk')->options(AttachmentDiskEnum::class),
            
            'attachment' => FileUpload::make('attachment')
                ->directory('attachments')
>>>>>>> bc33217 (.)
                ->preserveFilenames()
                ->maxSize(10240) // 10MB
                ->multiple(false)
                ->downloadable()
                ->openable()
<<<<<<< HEAD
=======
                ->disk(fn (Get $get) => $get('disk'))
>>>>>>> bc33217 (.)
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
<<<<<<< HEAD
}
=======
}
>>>>>>> bc33217 (.)
