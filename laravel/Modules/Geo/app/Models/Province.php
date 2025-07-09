<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Province extends BaseModel
{
    use \Sushi\Sushi;

    protected array $schema = [
        'region_id' => 'integer',
        'id' => 'integer',
        'name' => 'string',
    ];


    public function getRows(): array{
        $rows=Comune::select("regione->codice as region_id","provincia->codice as id","provincia->nome as name")
            ->distinct()
            ->orderBy("provincia->nome")
            ->get();
       
        return $rows->toArray();
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function localities(): HasMany
    {
        return $this->hasMany(Locality::class);
    }
}