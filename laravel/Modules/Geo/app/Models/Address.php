<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Geo\Contracts\HasGeolocation;
use Modules\Geo\Database\Factories\AddressFactory;
use Modules\Geo\Enums\AddressTypeEnum;

/**
 * Class Address
 * 
 * Implementazione di Schema.org PostalAddress
 *
 * @property int $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $route
 * @property string|null $street_number
 * @property string|null $locality
 * @property string|null $administrative_area_level_3
 * @property string|null $administrative_area_level_2
 * @property string|null $administrative_area_level_1
 * @property string|null $country
 * @property string|null $postal_code
 * @property string|null $formatted_address
 * @property string|null $place_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $type
 * @property bool $is_primary
 * @property array|null $extra_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * // implements HasGeolocation
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $addressable
 * @property-read \Modules\User\Models\Profile|null $creator
 * @property-read string $full_address
 * @property-read string $street_address
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $model
 * @property-read \Modules\User\Models\Profile|null $updater
 * @method static \Modules\Geo\Database\Factories\AddressFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address nearby(float $latitude, float $longitude, float $radiusKm = '10')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address ofType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address primary()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAdministrativeAreaLevel1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAdministrativeAreaLevel2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAdministrativeAreaLevel3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereExtraData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereFormattedAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLocality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStreetNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Address extends BaseModel 
{
        
    /** @var list<string> */
   protected $fillable = [
        'model_type',
        'model_id',
        'name',
        'description',
        'route',
        'street_number',
        'locality',
        'administrative_area_level_3', // comune
        'administrative_area_level_2', // provincia
        'administrative_area_level_1', // regione
        'country',// Stato/Paese
        'postal_code',
        'formatted_address',
        'place_id',
        'latitude',
        'longitude',
        'type',
        'is_primary',
        'extra_data',
    ];
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_primary' => 'boolean',
            'extra_data' => 'array',
            'type' => AddressTypeEnum::class,
        ];
    }
    
    
    /**
     * Get the parent model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Relazione polimorfica (alternativa con nome più descrittivo)
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo('model');
    }
    
    /*
     * Get the city relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'locality', 'name');
    }
    */
    /*
     * Get the province relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class, 'administrative_area_level_2', 'name');
    }
    */
    /*
     * Get the region relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     
    public function regione(): BelongsTo
    {
        return $this->belongsTo(Regione::class, 'administrative_area_level_1', 'name');
    }
     */
    public function getRegione():?array{
        /** @phpstan-ignore method.unresolvableReturnType */
        $res= Comune::select('regione')
        ->distinct()
        ->orderBy('regione->nome')
        ->where('regione->codice', $this->administrative_area_level_1)
        ->get()
        /** @phpstan-ignore argument.unresolvableType */
        ->map(function($item){
            /** @phpstan-ignore offsetAccess.notFound, offsetAccess.notFound */
            return ['codice'=>$item->regione['codice'],'nome'=>$item->regione['nome']];
        })
        ;
        
        
        return $res->first();
    }

    public function getProvincia():?array{
        /** @phpstan-ignore method.unresolvableReturnType */
        $res= Comune::select('provincia')
        ->distinct()
        ->orderBy('provincia->nome')
        ->where('provincia->codice', $this->administrative_area_level_2)
        ->get()
        /** @phpstan-ignore argument.unresolvableType */
        ->map(function($item){
            /** @phpstan-ignore-next-line */
            return [
                /** @phpstan-ignore offsetAccess.notFound */
                'codice'=>$item->provincia['codice'],
                /** @phpstan-ignore offsetAccess.notFound */
                'nome'=>$item->provincia['nome']
            ];
        })
        ;
        return $res->first();
    }


    public function getLocality():?array{
        /** @phpstan-ignore-next-line */
        $res= Comune::where('codice', $this->locality)
        ->distinct()
        ->first()
        ?->toArray()
        ;
        return $res;
    }
    
    /**
     * Getter per l'indirizzo completo in formato italiano
     *
     * @return string
     */
    public function getFullAddressAttribute(): string
    {
        
        $parts = array_filter([
            $this->route . ($this->street_number ? ' ' . $this->street_number : ''),
            $this->locality,
            $this->administrative_area_level_3, // Provincia
            $this->administrative_area_level_2, // Regione
            $this->postal_code,
            $this->country
        ]);

        return implode(', ', $parts);
    }


    public function getFullAddress(): ?string
    {
        $parts = array_filter([
            $this->route . ($this->street_number ? ' ' . $this->street_number : ''),
            $this->locality,
            $this->administrative_area_level_3, // Provincia
            $this->administrative_area_level_2, // Regione
            $this->postal_code,
            $this->country
        ]);

        return implode(', ', $parts);
    }
    
    /**
     * Getter per l'indirizzo strada completo
     *
     * @return string
     */
    public function getStreetAddressAttribute(): string
    {
        return trim(($this->route ?? '') . ' ' . ($this->street_number ?? ''));
    }
    
    /**
     * Get the formatted address.
     *
     * @return string
     */
    public function getFormattedAddressAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }
        
        $parts = [];
        
        // Indirizzo stradale
        if ($this->route) {
            $parts[] = $this->getStreetAddressAttribute();
        }
        
        // Località e provincia (formato italiano)
        $localityParts = [];
        if ($this->postal_code) {
            $localityParts[] = $this->postal_code;
        }
        
        if ($this->locality) {
            $localityParts[] = $this->locality;
            
            // Per indirizzi italiani, aggiungiamo la sigla provincia
            if ($this->country === 'IT' && $this->administrative_area_level_3) {
                // Se è un'implementazione reale, potremmo derivare la sigla dalla provincia
                $provinciaSigla = $this->extra_data['provincia_sigla'] ?? null;
                if ($provinciaSigla) {
                    $localityParts[] = "({$provinciaSigla})";
                }
            }
        }
        
        if (!empty($localityParts)) {
            $parts[] = implode(' ', $localityParts);
        }
        
        // Regione
        if ($this->administrative_area_level_2) {
            $parts[] = $this->administrative_area_level_2;
        }
        
        // Paese
        if ($this->country) {
            $countryName = $this->administrative_area_level_1 ?? $this->country;
            $parts[] = strtoupper($countryName);
        }
        
        return implode("\n", $parts);
    }
    
    /**
     * Get the latitude of the address.
     *
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }
    
    /**
     * Get the longitude of the address.
     *
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
    
    /**
     * Get the formatted address required by HasGeolocation interface.
     *
     * @return string
     */
    public function getFormattedAddress(): string
    {
        return $this->formatted_address ?? '';
    }
    
    /**
     * Restituisce i dati in formato Schema.org PostalAddress
     *
     * @return array<string, mixed>
     */
    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'PostalAddress',
            'name' => $this->name,
            'description' => $this->description,
            'streetAddress' => $this->getStreetAddressAttribute(),
            'addressLocality' => $this->locality,
            'addressSubregion' => $this->administrative_area_level_3, // Provincia
            'addressRegion' => $this->administrative_area_level_2, // Regione
            'addressCountry' => $this->country,
            'postalCode' => $this->postal_code,
        ];
    }
    
   
    /**
     * Scope per cercare indirizzi nelle vicinanze
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $latitude
     * @param float $longitude
     * @param float $radiusKm
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNearby($query, float $latitude, float $longitude, float $radiusKm = 10)
    {
        return $query->selectRaw("
            *,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
        ", [$latitude, $longitude, $latitude])
        ->having('distance', '<', $radiusKm)
        ->orderBy('distance');
    }
    
    /**
     * Scope a query to only include primary addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }
    
    /**
     * Scope a query to filter by address type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|AddressTypeEnum $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type instanceof AddressTypeEnum ? $type->value : $type);
    }
}
