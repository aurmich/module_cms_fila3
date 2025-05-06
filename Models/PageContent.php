<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Spatie\Translatable\HasTranslations;

/**
 * Modules\Cms\Models\PageContent
 *
 * @property int         $id
 * @property string|null $lang
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $content
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int|null    $parent_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $slug
 * @property string|null $layout
 * @property string|null $image
 * @property string|null $status
 * @property int|null    $pos
 *
 * @property-read PageContent|null $parent
 * @property-read PageContent[]    $children
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereLayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageContent whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class PageContent extends Model
{
    use HasTranslations;
    use SushiToJsons;

    /** @var array<int, string> */
    public $translatable = [
        'title',
        'subtitle',
        'content',
        'meta_description',
        'meta_keywords',
    ];

    /** @var list<string> */
    protected $fillable = [
        'lang',
        'title',
        'subtitle',
        'content',
        'meta_description',
        'meta_keywords',
        'parent_id',
        'created_by',
        'updated_by',
        'slug',
        'layout',
        'image',
        'status',
        'pos',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getRows(): array
    {
        return $this->getSushiRows();
    }

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
            'uuid' => 'string',

            'title' => 'string',
            'subtitle' => 'string',
            'content' => 'string',
            'meta_description' => 'string',
            'meta_keywords' => 'string',
            'slug' => 'string',
            'layout' => 'string',
            'image' => 'string',
            'status' => 'string',
            'pos' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
