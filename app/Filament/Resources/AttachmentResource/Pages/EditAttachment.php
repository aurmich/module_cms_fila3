<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Resources\AttachmentResource\Pages;

use Illuminate\Support\Str;
use Modules\Cms\Filament\Resources\AttachmentResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseEditRecord;

class EditAttachment extends LangBaseEditRecord
{
    protected static string $resource = AttachmentResource::class;
<<<<<<< HEAD

    /*
     * protected function mutateFormDataBeforeFill(array $data): array
     * {
     * // Handle translatable attachment field for FileUpload
     * if (isset($data['attachment']) && is_array($data['attachment'])) {
     * $currentLocale = app()->getLocale();
     * // Extract the file for current locale
     * if (isset($data['attachment'][$currentLocale])) {
     * // Convert from {uuid: filename} format to simple filename for FileUpload
     * $localeData = $data['attachment'][$currentLocale];
     * if (is_array($localeData) && count($localeData) > 0) {
     * $data['attachment'] = array_values($localeData)[0]; // Get first filename
     * } else {
     * $data['attachment'] = '';
     * }
     * } else {
     * $data['attachment'] = '';
     * }
     * }
     *
     * return parent::mutateFormDataBeforeFill($data);
     * }
     */
=======
    /*
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Handle translatable attachment field for FileUpload
        if (isset($data['attachment']) && is_array($data['attachment'])) {
            $currentLocale = app()->getLocale();
            // Extract the file for current locale
            if (isset($data['attachment'][$currentLocale])) {
                // Convert from {uuid: filename} format to simple filename for FileUpload
                $localeData = $data['attachment'][$currentLocale];
                if (is_array($localeData) && count($localeData) > 0) {
                    $data['attachment'] = array_values($localeData)[0]; // Get first filename
                } else {
                    $data['attachment'] = '';
                }
            } else {
                $data['attachment'] = '';
            }
        }
        
        return parent::mutateFormDataBeforeFill($data);
    }
    */
>>>>>>> bc33217 (.)
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle translatable attachment field for FileUpload
        if (isset($data['attachment']) && is_string($data['attachment']) && !empty($data['attachment'])) {
            $uuid = Str::uuid()->toString();
<<<<<<< HEAD
            $data['attachment'] = [$uuid => $data['attachment']];
=======
            $data['attachment']=[$uuid => $data['attachment']];
>>>>>>> bc33217 (.)
        } elseif (isset($data['attachment']) && empty($data['attachment'])) {
            // If attachment is empty, preserve existing translations
            unset($data['attachment']);
        }
<<<<<<< HEAD

        return parent::mutateFormDataBeforeSave($data);
    }
=======
        
        return parent::mutateFormDataBeforeSave($data);
    }

>>>>>>> bc33217 (.)
}
