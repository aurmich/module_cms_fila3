<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Filament\Forms\Get;
use function Safe\json_decode;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $region_id
 * @property int|null $province_id
 * @property string|null $name
 * @property int $id
 * @property string|null $postal_code
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Locality whereRegionId($value)
 * @mixin \Eloquent
 */
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

    public static function getOptions(Get $get): array
    {

        $region = $get('administrative_area_level_1');
        if (!$region) {
            return [];
        }
        $province = $get('administrative_area_level_2');
        if (!$province) {
            return [];
        }

        $city = $get('locality');
        $res=self::where('region_id', $region)
        ->where('province_id', $province)
        ->pluck("name", "id")
        ->toArray();

        /*
        ->when($city !== null, fn($query) => $query->where('id', $city))
        ->select('postal_code')
        ->distinct()
        ->orderBy('postal_code')
        ->get()
        ->pluck('postal_code', 'postal_code')
        ->toArray();

                        
                        
                        return $res ?? [];
        */
        return $res;
        
    }

    public static function getPostalCodeOptions(Get $get): array
    {
        $region = $get('administrative_area_level_1');
        if (!$region) {
            return [];
        }
        $province = $get('administrative_area_level_2');
        if (!$province) {
            return [];
        }

        $city = $get('locality');
        $res=self::where('region_id', $region)
        ->where('province_id', $province)
        
        ->when($city !== null, fn($query) => $query->where('id', $city))
        ->select('postal_code')
        ->distinct()
        ->orderBy('postal_code')
        ->get()
        ->pluck('postal_code', 'postal_code')
        ->toArray();

                        
                        
        return $res ?? [];
    }
}