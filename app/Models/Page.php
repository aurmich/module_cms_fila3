<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\Translatable\HasTranslations;

/**
 * Modello Page per la gestione delle pagine del CMS.
 *
 * @property string                          $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string                          $slug
 * @property string                          $title
 * @property string                          $content
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @property array|null                      $content_blocks
 * @property array|null                      $sidebar_blocks
 * @property array                           $footer_blocks
 * @property mixed                           $translations
 * @property ProfileContract|null            $creator
 * @property ProfileContract|null            $updater
 *
 * @mixin \Eloquent
 */
<<<<<<< HEAD
class Page extends BaseModelLang
{
=======
class Page extends BaseModel
{
    use HasTranslations;
>>>>>>> feb96d7 (.)
    use SushiToJsons;

    /** @var array<int, string> */
    public $translatable = [
        'title',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    protected $fillable = [
        'content',
        'slug',
        'title',
        'content_blocks',
        'sidebar_blocks',
        'footer_blocks',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'content' => 'string',
        'content_blocks' => 'json',
        'sidebar_blocks' => 'json',
        'footer_blocks' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    /**
     * Ottiene le righe per Sushi.
     *
     * @return array
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

<<<<<<< HEAD
<<<<<<< HEAD

=======
=======
    /**
     * Configurazione per la generazione dello slug.
     *
     * @return array
     */
>>>>>>> f1c9277 (.)
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * Ottiene il nome della chiave per il routing frontend.
     *
     * @return string
     */
    public function getFrontRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Ottiene l'URL della pagina.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return url('/'.app()->getLocale().'/pages/'.$this->slug);
    }
>>>>>>> feb96d7 (.)

    /**
     * Gli attributi che devono essere convertiti in date.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'date' => 'datetime',
            'published_at' => 'datetime',
            'active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'content_blocks' => 'array',
            'sidebar_blocks' => 'array',
            'footer_blocks' => 'array',
        ];
    }
}
