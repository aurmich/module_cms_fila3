<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\Translatable\HasTranslations;

/**
 * Modules\Cms\Models\PageContent.
 *
 * <<<<<<< HEAD
 * =======
 * <<<<<<< HEAD
 *
 * >>>>>>> origin/master
 *
 * @property string                               $blocks
 * @property string|null                          $id
 * @property array|null                           $name
 * @property string|null                          $slug
 * @property \Illuminate\Support\Carbon|null      $created_at
 * @property \Illuminate\Support\Carbon|null      $updated_at
 * @property string|null                          $created_by
 * @property string|null                          $updated_by
 * @property \Modules\Idoteca\Models\Profile|null $creator
 * @property mixed                                $translations
 * @property \Modules\Idoteca\Models\Profile|null $updater
 *                                                              <<<<<<< HEAD
 *                                                              =======
 *                                                              =======
 * @property string                               $blocks
 * @property string|null                          $id
 * @property array|null                           $name
 * @property string|null                          $slug
 * @property \Illuminate\Support\Carbon|null      $created_at
 * @property \Illuminate\Support\Carbon|null      $updated_at
 * @property string|null                          $created_by
 * @property string|null                          $updated_by
 * @property ProfileContract|null                 $creator
 * @property mixed                                $translations
 * @property ProfileContract|null                 $updater
 *                                                              >>>>>>> f67fac5 (📝 (PageContentFactory.php): Update PageContentFactory to use fully qualified class name for the model)
 *                                                              >>>>>>> origin/master
 *
 * @method static \Modules\Cms\Database\Factories\PageContentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent  whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class PageContent extends BaseModel
{
    use HasTranslations;
    use SushiToJsons;

    protected $fillable = [
        'name',
        'slug',
        'blocks',
    ];

    /** @var array<int, string> */
    public $translatable = [
        'name',
        'blocks',
    ];

    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    protected array $schema = [
        'id' => 'integer',
        'name' => 'json',
        'slug' => 'string',

        'blocks' => 'json',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
            'slug' => 'string',
            'uuid' => 'string',
            'blocks' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
