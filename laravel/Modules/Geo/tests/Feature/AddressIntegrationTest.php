<?php

declare(strict_types=1);

use Modules\Geo\Models\Address;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\SaluteOra\Models\Patient;

describe('Address Integration', function () {
    it('can attach address to patient via polymorphic relationship', function () {
        $patient = Patient::factory()->create();
        
        $address = Address::factory()->create([
            'model_type' => Patient::class,
            'model_id' => $patient->id,
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);
        
        expect($address->addressable)->toBeInstanceOf(Patient::class)
            ->and($address->addressable->id)->toBe($patient->id)
            ->and($address->is_primary)->toBeTrue();
    });

    it('generates proper full address from components', function () {
        $address = Address::factory()->create([
            'route' => 'Via Giuseppe Verdi',
            'street_number' => '42',
            'locality' => 'Milano',
            'administrative_area_level_2' => 'MI',
            'postal_code' => '20121',
            'country' => 'Italia',
        ]);
        
        $fullAddress = $address->full_address;
        
        expect($fullAddress)->toContain('Via Giuseppe Verdi')
            ->and($fullAddress)->toContain('42')
            ->and($fullAddress)->toContain('Milano')
            ->and($fullAddress)->toContain('20121');
    });

    it('handles geolocation data correctly', function () {
        $milanCoordinates = [
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ];
        
        $address = Address::factory()->create($milanCoordinates);
        
        expect($address->latitude)->toBe(45.4642)
            ->and($address->longitude)->toBe(9.1900);
    });

    it('can store Google Places API data', function () {
        $googlePlacesData = [
            'place_id' => 'ChIJu46S-ZZjhkcRLuFvLjVZ400',
            'formatted_address' => 'Piazza del Duomo, 20121 Milano MI, Italy',
            'extra_data' => [
                'google_types' => ['establishment', 'point_of_interest'],
                'rating' => 4.5,
                'business_status' => 'OPERATIONAL',
            ],
        ];
        
        $address = Address::factory()->create($googlePlacesData);
        
        expect($address->place_id)->toBe('ChIJu46S-ZZjhkcRLuFvLjVZ400')
            ->and($address->formatted_address)->toContain('Piazza del Duomo')
            ->and($address->extra_data['google_types'])->toContain('establishment')
            ->and($address->extra_data['rating'])->toBe(4.5);
    });

    it('supports multiple addresses per entity', function () {
        $patient = Patient::factory()->create();
        
        $homeAddress = Address::factory()->create([
            'model_type' => Patient::class,
            'model_id' => $patient->id,
            'type' => AddressTypeEnum::HOME,
            'is_primary' => true,
        ]);
        
        $workAddress = Address::factory()->create([
            'model_type' => Patient::class,
            'model_id' => $patient->id,
            'type' => AddressTypeEnum::WORK,
            'is_primary' => false,
        ]);
        
        $patientAddresses = Address::where('model_type', Patient::class)
            ->where('model_id', $patient->id)
            ->get();
        
        expect($patientAddresses)->toHaveCount(2);
        
        $primaryAddress = $patientAddresses->where('is_primary', true)->first();
        expect($primaryAddress->id)->toBe($homeAddress->id);
    });

    it('handles soft deletion correctly', function () {
        $address = Address::factory()->create();
        $addressId = $address->id;
        
        $address->delete();
        
        expect(Address::find($addressId))->toBeNull()
            ->and(Address::withTrashed()->find($addressId))->not->toBeNull()
            ->and(Address::withTrashed()->find($addressId)->deleted_at)->not->toBeNull();
    });
});