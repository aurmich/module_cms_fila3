<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

class DownloadZipByPathsDiskAction
{
    use QueueableAction;

    public function execute(array $attachments,string $disk)
    {
        $zipFileName = 'temp_zip_' .uniqid() . '.zip';
        $zipPath = 'temp/' . $zipFileName;
        
        // Crea un file temporaneo per lo ZIP usando Storage
        $zip = new \ZipArchive();
        $tempFilePath = storage_path('app/' . $zipPath);
        
        // Assicurati che la directory temp esista
        Storage::disk('local')->makeDirectory('temp');
        
        if ($zip->open($tempFilePath, \ZipArchive::CREATE) === TRUE) {
            foreach ($attachments as $attachment) {
                $filePath = $attachment;
                
                if (Storage::disk($disk)->exists($filePath)) {
                    $fileContent = Storage::disk($disk)->get($filePath);
                    $zip->addFromString($attachment . '.pdf', $fileContent);
                }else{
                    dddx(['filePath'=>$filePath]);
                }
            }
            $zip->close();
            
            $downloadFileName = 'attachments_' . uniqid() . '.zip';
            
            // Usa Storage per il download e elimina dopo
            return Storage::disk('local')->download($zipPath, $downloadFileName, [
                'Content-Type' => 'application/zip'
            ]);//->deleteFileAfterSend(true);
        }
    }
}
