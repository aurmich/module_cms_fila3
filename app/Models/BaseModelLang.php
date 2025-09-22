<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Factory\GetFactoryAction;
use Modules\Xot\Traits\Updater;
use Spatie\Translatable\HasTranslations;

/**
 * Class BaseModel.
 */
abstract class BaseModelLang extends BaseModel
{
    use HasTranslations;

<<<<<<< HEAD
    /** @var array<int, string> */
    public $translatable = [
=======
     /** @var array<int, string> */
     public $translatable = [
>>>>>>> bc33217 (.)
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
<<<<<<< HEAD
        'blocks' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
=======

        'blocks' => 'json',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

>>>>>>> bc33217 (.)
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

<<<<<<< HEAD
=======


>>>>>>> bc33217 (.)
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
<<<<<<< HEAD
    #[\Override]
=======
>>>>>>> bc33217 (.)
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
<<<<<<< HEAD
=======

>>>>>>> bc33217 (.)
            'name' => 'string',
            'slug' => 'string',
            'blocks' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
