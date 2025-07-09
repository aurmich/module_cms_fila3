<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;

class Locality extends BaseModel
{
    use \Sushi\Sushi;

    
    protected array $schema = [
        'region_id' => 'integer',
        'province_id' => 'integer',
        'id' => 'integer',
        'name' => 'string',
        'postal_code' => 'json',
    ];
    


    public function getRows(): array{
        $rows=Comune::select("regione->codice as region_id","provincia->codice as province_id","nome as name","codice as id","cap as postal_code")
            ->distinct()
            ->orderBy("nome")
            ->get();
       
        return $rows->toArray();
    }
}