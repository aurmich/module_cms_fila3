<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

class LocationDTO
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly ?string $address = null,
        public readonly ?string $city = null,
        public readonly ?string $country = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
        ];
    }
}
