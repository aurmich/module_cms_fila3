<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}