<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

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

        public readonly ?array $certifications = null,

        public readonly ?string $phone = null,
        
        public readonly ?string $address = null,
        
        public readonly ?string $city = null,
        
        public readonly ?string $registration_number = null,
        
        public readonly ?array $availability = null,
    ) {
    }
    
    /**
     * Crea un'istanza di DoctorData da un array di dati.
     *
     * @param array<string, mixed> $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new static(
            first_name: (string) ($data['first_name'] ?? ''),
            last_name: (string) ($data['last_name'] ?? ''),
            email: (string) ($data['email'] ?? ''),
            certifications: is_array($data['certifications'] ?? null) ? $data['certifications'] : null,
            phone: isset($data['phone']) ? (string) $data['phone'] : null,
            address: isset($data['address']) ? (string) $data['address'] : null,
            city: isset($data['city']) ? (string) $data['city'] : null,
            registration_number: isset($data['registration_number']) ? (string) $data['registration_number'] : null,
            availability: is_array($data['availability'] ?? null) ? $data['availability'] : null,
        );
    }
}
