<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\ArrayCast;

class DoctorData extends Data
{
    public function __construct(
        #[Required]
        #[StringType]
        public readonly string $first_name,

        #[Required]
        #[StringType]
        public readonly string $last_name,

        #[Required]
        #[Email]
        public readonly string $email,

        #[WithCast(ArrayCast::class)]
        public readonly ?array $certifications = null,

        public readonly ?string $phone = null,
        
        public readonly ?string $address = null,
        
        public readonly ?string $city = null,
        
        public readonly ?string $registration_number = null,
        
        #[WithCast(ArrayCast::class)]
        public readonly ?array $availability = null,
    ) {
    }
    
    /**
     * Crea un'istanza di DoctorData da un array di dati.
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function from(array $data): self
    {
        return new self(
            first_name: $data['first_name'] ?? '',
            last_name: $data['last_name'] ?? '',
            email: $data['email'] ?? '',
            certifications: $data['certifications'] ?? null,
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            city: $data['city'] ?? null,
            registration_number: $data['registration_number'] ?? null,
            availability: $data['availability'] ?? null,
        );
    }
}
