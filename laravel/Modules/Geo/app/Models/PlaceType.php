<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlaceType query()
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @mixin IdeHelperPlaceType
 * @mixin \Eloquent
 */
class PlaceType extends BaseModel
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Modules\Geo\Database\Factories\PlaceTypeFactory
     */
    protected static function newFactory(): \Modules\Geo\Database\Factories\PlaceTypeFactory
    {
        return \Modules\Geo\Database\Factories\PlaceTypeFactory::new();
    }
    
    protected $fillable = [
        'name',
        'description',
    ];

    // Definisci le relazioni e i metodi necessari per la classe PlaceType
}
