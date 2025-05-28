<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class SearchDentistData extends Data
{
    public function __construct(
        public ?string $region = null,
        public ?string $province = null,
        public ?string $city = null,
        public ?string $cap = null,
        public ?string $specialization = null,
        public ?string $appointment_type = null,
    ) {
    }
} 