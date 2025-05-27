<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Geo\Contracts\HasGeolocation;
use Modules\Geo\Database\Factories\PlaceFactory;

use function Safe\json_encode;

class Place extends BaseModel implements HasGeolocation
{
    /**
     * List of address components used in the application.
     *
     * @var array<string>
     */
    public static array $address_components = [
        'premise',
        'locality',
        'postal_town',
        'administrative_area_level_3',
        'administrative_area_level_2',
        'administrative_area_level_1',
        'country',
        'street_number',
        'route',
        'postal_code',
        'point_of_interest',
        'political'
    ];
    use HasFactory;

    protected $fillable = [
        'id', 'post_id', 'post_type', 'model_id', 'model_type',
        'premise', 'locality', 'postal_town', 'administrative_area_level_3',
        'administrative_area_level_2', 'administrative_area_level_1', 'country',
        'street_number', 'route', 'postal_code', 'googleplace_url',
        'point_of_interest', 'political', 'campground', 'locality_short',
        'administrative_area_level_2_short', 'administrative_area_level_1_short',
        'country_short', 'latlng', 'latitude', 'longitude', 'formatted_address',
        'nearest_street', 'extra_data',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'extra_data' => 'array',
    ];

    /**
     * @return MorphTo<Model, self>
     *
     * @phpstan-ignore-next-line
     */
    public function linked(): MorphTo
    {
        return $this->morphTo('post');
    }

    /**
     * @return BelongsTo<PlaceType, self>
     *
     * @phpstan-ignore-next-line
     */
    public function placeType(): BelongsTo
    {
        return $this->belongsTo(PlaceType::class, 'type_id');
    }

    /**
     * @return BelongsTo<Address, self>
     *
     * @phpstan-ignore-next-line
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function getFormattedAddress(): string
    {
        return (string) ($this->formatted_address ?? $this->address->formatted_address ?? '');
    }

    public function getLatitudeAttribute(): ?float
    {
        if (! isset($this->attributes['latitude'])) {
            return null;
        }

        $latitude = $this->attributes['latitude'];
        if (! is_numeric($latitude)) {
            return null;
        }

        $latitude = (float) $latitude;

        return is_finite($latitude) && $latitude >= -90 && $latitude <= 90 ? $latitude : null;
    }

    public function getLongitudeAttribute(): ?float
    {
        if (! isset($this->attributes['longitude'])) {
            return null;
        }

        $longitude = $this->attributes['longitude'];
        if (! is_numeric($longitude)) {
            return null;
        }

        $longitude = (float) $longitude;

        return is_finite($longitude) && $longitude >= -180 && $longitude <= 180 ? $longitude : null;
    }

    public function getFormattedAddressAttribute(): string
    {
        $address = $this->attributes['formatted_address'] ?? '';

        return is_string($address) ? $address : '';
    }

    public function hasValidCoordinates(): bool
    {
        return null !== $this->latitude
            && null !== $this->longitude
            && $this->latitude >= -90
            && $this->latitude <= 90
            && $this->longitude >= -180
            && $this->longitude <= 180;
    }

    public function getMapIcon(): ?string
    {
        $type = $this->placeType->slug ?? 'default';
        $markerConfig = config("geo.markers.types.{$type}");

        if (! is_array($markerConfig)) {
            $markerConfig = config('geo.markers.types.default');
        }

        if (! is_array($markerConfig)) {
            return null;
        }

        $icon = $markerConfig['icon'] ?? null;

        if (is_array($icon)) {
            return json_encode($icon);
        }

        return is_string($icon) ? $icon : null;
    }

    public function getLocationType(): ?string
    {
        return $this->placeType->name ?? null;
    }

    protected static function newFactory(): PlaceFactory
    {
        return PlaceFactory::new();
    }
}
