<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\FileAttachmentProviders\SpatieMediaLibraryFileAttachmentProvider;

/**
 * ---
 */
class Attachment extends BaseModelLang implements HasMedia
{
    use SushiToJsons;
    use InteractsWithMedia;

    /** @var array<int, string> */
    public $translatable = [
        'title',
        'description',
        'attachment',
    ];

    protected $fillable = [
        'title',
        'description',
        'slug',
        'disk',
        'attachment',
    ];

    protected $casts = [
        //'title' => 'array',
        'attachment' => 'array',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'description' => 'json',
        'slug' => 'string',
        'disk' => 'string',
        'attachment' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];
  /*
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $currentLocale = app()->getLocale();
            $attachment = $model->attachment ?? [];
            
            // If we have a file upload, process it
            if (request()->hasFile('attachment')) {
                $file = request()->file('attachment');
                $uuid = (string) \Illuminate\Support\Str::uuid();
                $fileName = $file->getClientOriginalName();
                $path = $file->storeAs('attachments', $uuid . '_' . $fileName, 'public');
                
                // Initialize the attachment array for the current locale if it doesn't exist
                if (!isset($attachment[$currentLocale])) {
                    $attachment[$currentLocale] = [];
                }
                
                // Store the file information
                $attachment[$currentLocale][$uuid] = $fileName;
                $model->attachment = $attachment;
            }
        });
    }
    */


    public function getRows(): array
    {
        $rows= $this->getSushiRows();
        return $rows;
    }



    /**
     * The attributes that should be mutated to dates.
     *
     * @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'disk' => 'string',
            'uuid' => 'string',
            'date' => 'datetime',
            'published_at' => 'datetime',
            'active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'attachment' => 'array',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')
            ->acceptsMimeTypes([
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/zip',
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
            ]);
    }

    public function getAttachmentForLocale(string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $media = $this->getFirstMedia('attachments');
        
        if ($media && $media->getCustomProperty('locale') === $locale) {
            return $media->getUrl();
        }
        
        return null;
    }


    public function asset(): string
    {
        $file = array_values($this->attachment)[0];
        $path = Storage::disk($this->disk)->url($file);
        return $path;
    }
}
