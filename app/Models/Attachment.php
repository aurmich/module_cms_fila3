<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

<<<<<<< HEAD
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
=======
use Modules\Tenant\Models\Traits\SushiToJsons;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * ---
 *
 * @property string $id
 * @property array<array-key, mixed>|null $title
 * @property string|null $slug
 * @property array<array-key, mixed>|null $attachment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read \Modules\Predict\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read mixed $translations
 * @property-read \Modules\Predict\Models\Profile|null $updater
 *
 * @method static \Modules\Cms\Database\Factories\AttachmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereUpdatedBy($value)
 * @method static Attachment|null first()
 * @method static \Illuminate\Database\Eloquent\Collection<int, Attachment> get()
 * @method static Attachment create(array $attributes = [])
 * @method static Attachment firstOrCreate(array $attributes = [], array $values = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment where(string|\Closure $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereNotNull(string|\Illuminate\Contracts\Database\Query\Expression $columns)
 * @method static int count(string $columns = '*')
 *
 * @mixin \Eloquent
 */
class Attachment extends BaseModelLang implements HasMedia
{
    use InteractsWithMedia;
    use SushiToJsons;
>>>>>>> 681ae6a (.)

    /** @var array<int, string> */
    public $translatable = [
        'title',
<<<<<<< HEAD
        'description',
=======
>>>>>>> 681ae6a (.)
        'attachment',
    ];

    protected $fillable = [
        'title',
<<<<<<< HEAD
        'description',
        'slug',
        'disk',
=======
        'slug',
>>>>>>> 681ae6a (.)
        'attachment',
    ];

    protected $casts = [
<<<<<<< HEAD
        //'title' => 'array',
=======
        // 'title' => 'array',
>>>>>>> 681ae6a (.)
        'attachment' => 'array',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
<<<<<<< HEAD
        'description' => 'json',
        'slug' => 'string',
        'disk' => 'string',
=======
        'slug' => 'string',
>>>>>>> 681ae6a (.)
        'attachment' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];
<<<<<<< HEAD
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



=======
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
        $rows = $this->getSushiRows();

        return $rows;
    }

>>>>>>> 681ae6a (.)
    /**
     * The attributes that should be mutated to dates.
     *
     * @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
<<<<<<< HEAD
            'disk' => 'string',
=======
>>>>>>> 681ae6a (.)
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

<<<<<<< HEAD
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
=======
    public function getAttachmentForLocale(?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $media = $this->getFirstMedia('attachments');

        if ($media && $media->getCustomProperty('locale') === $locale) {
            return $media->getUrl();
        }

        return null;
    }
>>>>>>> 681ae6a (.)
}
