<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use function Safe\json_decode;

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
            ->get()
            ->map(function($row){
                /** @phpstan-ignore offsetAccess.nonOffsetAccessible, property.notFound */
                $postal_code=json_decode($row->postal_code)[0];
                /** @phpstan-ignore property.notFound */
                $row->postal_code=$postal_code;
                return $row;
            });
            
       
        return $rows->toArray();
    }
}