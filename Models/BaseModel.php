<?php

declare(strict_types=1);

namespace Modules\Media\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
//---------- traits
use Illuminate\Database\Eloquent\Model;
////use Laravel\Scout\Searchable;
use Modules\Xot\Traits\Updater;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Xot\Services\FactoryService;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends Model {
    use Updater;
    //use Searchable;
    //use Cachable;
    use HasFactory;

    protected $connection = 'media';

    /**
     * @var string[]
     */
    protected $fillable = ['id'];
    /**
     * @var array
     */
    protected $casts = [
        //'published_at' => 'datetime:Y-m-d', // da verificare
    ];

    /**
     * @var string[]
     */
    protected $dates = ['published_at', 'created_at', 'updated_at'];
    /**
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * @var bool
     */
    public $incrementing = true;
    /**
     * @var array
     */
    protected $hidden = [
        //'password'
    ];
    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory() {
        return FactoryService::newFactory(get_called_class());
    }
}
