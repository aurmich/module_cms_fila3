<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Modules\Tenant\Models\Traits\SushiToJsons;
use Spatie\Translatable\HasTranslations;

/**
 * Modules\Cms\Models\Section
 *
 * @property array|null                                  $blocks
 * @property string|null                                 $id
 * @property array|null                                  $name
 * @property string|null                                 $slug
 * @property \Illuminate\Support\Carbon|null             $created_at
 * @property \Illuminate\Support\Carbon|null             $updated_at
 * @property string|null                                 $created_by
 * @property string|null                                 $updated_by
 * @property mixed                                       $translations
 *
 * @method static \Modules\Cms\Database\Factories\SectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Section  newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section  newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section  query()
 */
class Section extends BaseModelLang
{
    use SushiToJsons;

    /** @var array<int, string> */
    public $translatable = [
        'name',
        'blocks',
    ];

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'blocks',
    ];

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



    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'name' => 'array',
            'slug' => 'string',
            'blocks' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows():array
    {
        return $this->getSushiRows();
    }
}
