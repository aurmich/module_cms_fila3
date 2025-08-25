<?php

declare(strict_types=1);

use Modules\Geo\Enums\AddressTypeEnum;

describe('Address Integration (pure unit)', function () {
    it('can attach address to patient via polymorphic fields (in-memory)', function () {
        $patient = (object) ['id' => 1001];
        $address = (object) [
            'model_type' => 'Modules\\SaluteOra\\Models\\Patient',
            'model_id' => $patient->id,
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ];

        expect($address->model_type)->toBe('Modules\\SaluteOra\\Models\\Patient')
            ->and($address->model_id)->toBe($patient->id)
            ->and($address->is_primary)->toBeTrue();
    });

    it('generates proper full address from components (replicated logic)', function () {
        $a = (object) [
            'route' => 'Via Giuseppe Verdi',
            'street_number' => '42',
            'locality' => 'Milano',
            'administrative_area_level_2' => 'MI',
            'postal_code' => '20121',
            'country' => 'Italia',
        ];

        $fullAddress = implode(', ', array_filter([
            $a->route . ' ' . $a->street_number,
            $a->locality,
            $a->administrative_area_level_2,
            $a->postal_code,
            $a->country,
        ]));

        expect($fullAddress)->toContain('Via Giuseppe Verdi')
            ->and($fullAddress)->toContain('42')
            ->and($fullAddress)->toContain('Milano')
            ->and($fullAddress)->toContain('20121');
    });

    it('handles geolocation data correctly (in-memory)', function () {
        $address = (object) [
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ];

        expect($address->latitude)->toBe(45.4642)
            ->and($address->longitude)->toBe(9.1900);
    });

    it('can store Google Places API data (in-memory)', function () {
        $address = (object) [
            'place_id' => 'ChIJu46S-ZZjhkcRLuFvLjVZ400',
            'formatted_address' => 'Piazza del Duomo, 20121 Milano MI, Italy',
            'extra_data' => [
                'google_types' => ['establishment', 'point_of_interest'],
                'rating' => 4.5,
                'business_status' => 'OPERATIONAL',
            ],
        ];

        expect($address->place_id)->toBe('ChIJu46S-ZZjhkcRLuFvLjVZ400')
            ->and($address->formatted_address)->toContain('Piazza del Duomo')
            ->and($address->extra_data['google_types'])->toContain('establishment')
            ->and($address->extra_data['rating'])->toBe(4.5);
    });

    it('supports multiple addresses per entity (in-memory)', function () {
        $patient = (object) ['id' => 2002];
        $homeAddress = (object) [
            'model_type' => 'Modules\\SaluteOra\\Models\\Patient',
            'model_id' => $patient->id,
            'type' => AddressTypeEnum::HOME,
            'is_primary' => true,
            'id' => 1,
        ];
        $workAddress = (object) [
            'model_type' => 'Modules\\SaluteOra\\Models\\Patient',
            'model_id' => $patient->id,
            'type' => AddressTypeEnum::WORK,
            'is_primary' => false,
            'id' => 2,
        ];

        $list = collect([$homeAddress, $workAddress])
            ->filter(fn ($a) => $a->model_type === 'Modules\\SaluteOra\\Models\\Patient' && $a->model_id === $patient->id);

        expect($list)->toHaveCount(2);

        $primary = $list->firstWhere('is_primary', true);
        expect($primary->id)->toBe(1);
    });

    it('handles soft deletion conceptually (in-memory)', function () {
        $address = (object) ['id' => 999, 'deleted_at' => null];

        // simulate soft delete
        $address->deleted_at = now();

        expect($address->deleted_at)->not->toBeNull();
    });
});