<?php

namespace App\Data;

use App\Models\Dentist;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class DentistData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $phone,
        public string $registration_number,
        public bool $is_active,
        public Collection $specializations,
        public Collection $reviews,
        public array $clinic,
        public ?string $profile_photo_url = null,
    ) {
    }

    public static function fromModel(Dentist $dentist): self
    {
        return new self(
            id: $dentist->id,
            name: $dentist->name,
            email: $dentist->email,
            phone: $dentist->phone,
            registration_number: $dentist->registration_number,
            is_active: $dentist->is_active,
            specializations: $dentist->specializations,
            reviews: $dentist->reviews,
            clinic: [
                'name' => $dentist->clinic->name,
                'address' => $dentist->clinic->address,
                'city' => $dentist->clinic->city,
                'province' => $dentist->clinic->province,
            ],
            profile_photo_url: $dentist->profile_photo_url,
        );
    }
} 