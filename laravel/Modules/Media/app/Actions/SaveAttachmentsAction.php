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
use Illuminate\Support\Facades\Storage;
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
use function Safe\tempnam;
use function Safe\file_put_contents;
use function Safe\unlink;


/**
 *
 */
class SaveAttachmentsAction
{

    public function execute(HasMedia $record, array $attachments, array $data, string $disk = 'attachments'): void
    {
        $dataAttachments = [];
        
        foreach ($attachments as $attachment) {
            if (empty($data[$attachment])) {
                continue;
            }

            $path = $data[$attachment];
            
           
            // Metodo compatibile con Laravel 9+ e Flysystem 3.x
            $storage = Storage::disk($disk);
            
            if (!$storage->exists($path)) {
                continue;
            }

            // Ottieni il contenuto del file prima che venga eliminato
            $fileContent = $storage->get($path);
            $tempPath = tempnam(sys_get_temp_dir(), 'media_');
            
            file_put_contents($tempPath, $fileContent);

            try {
                $media = $record->addMedia($tempPath)
                    ->usingFileName(basename($path))
                    ->toMediaCollection($attachment);
                
                $dataAttachments[$attachment] = $media->getPathRelativeToRoot();
            } finally {
                // Cleanup del file temporaneo
                if (file_exists($tempPath)) {
                    unlink($tempPath);
                }
            }
           
        }

        if (!empty($dataAttachments)) {
            $record->update($dataAttachments);
        }
    }
    /**
     *
     */
    public function executeOLD(HasMedia $record,array $attachments,array $data, string $disk='attachments'): void
    {
        $data_attachments = [];
        foreach ($attachments as $attachment) {
                $path=$data[$attachment];
                $full_path=Storage::disk($disk)->path($path);
                //*
                dddx([
                    'exists'=>Storage::disk($disk)->exists($path),
                    'path'=>$path,
                    'disk'=>$disk,
                    'full_path'=>Storage::disk($disk)->path($path),
                ]);
                //*/
                if(!method_exists($record,'addMediaFromDisk')){
                    throw new \Exception('Method addMediaFromDisk not found');
                }
                $media=$record->addMediaFromDisk($path,$disk)
                //$media=$record->addMediaFromRequest($attachment)

               // $media=$record->addMedia($full_path)
                    ->toMediaCollection($attachment);
                $data_attachments[$attachment]=$media->getPathRelativeToRoot();

        }
        $record->update($data_attachments); 
    }
}
