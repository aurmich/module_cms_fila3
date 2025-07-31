<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string|null $name
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Geo\Models\Province> $provinces
 * @property-read int|null $provinces_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereName($value)
 * @mixin \Eloquent
 */
class Region extends BaseModel
{
    use \Sushi\Sushi;

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'integer';


    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
    ];

    public function getRows(): array{
        $rows=Comune::select("regione->codice as id","regione->nome as name")
            ->distinct()
            ->orderBy("regione->nome")
            ->get();
       
        return $rows->toArray();
    }

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }

    public static function getOptions(Get $get): array
    {
        return self::orderBy('name')
            ->get()
            ->pluck("name", "id")
            ->toArray();
    }
}