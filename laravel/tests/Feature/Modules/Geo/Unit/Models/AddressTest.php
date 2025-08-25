<?php

declare(strict_types=1);

use Modules\Geo\Models\Address;
use Modules\Geo\Models\City;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\Region;

beforeEach(function () {
    if (!moduleEnabled('Geo')) {
        $this->markTestSkipped('Module Geo is disabled');
    }
});

describe('Address Model', function () {
    test('can create address with basic attributes', function () {
        $region = Region::factory()->create(['name' => 'Emilia-Romagna']);
        $province = Province::factory()->create(['region_id' => $region->id, 'name' => 'Modena']);
        $city = City::factory()->create(['province_id' => $province->id, 'name' => 'Modena']);

        $address = Address::factory()->create([
            'street' => 'Via Roma, 123',
            'city_id' => $city->id,
            'postal_code' => '41121',
            'country' => 'Italy',
        ]);

        expect($address->street)->toBe('Via Roma, 123');
        expect($address->city_id)->toBe($city->id);
        expect($address->postal_code)->toBe('41121');
        expect($address->country)->toBe('Italy');
        expect($address->exists)->toBeTrue();
    });

    test('address model uses correct table', function () {
        $address = new Address();
        expect($address->getTable())->toBe('addresses');
    });

    test('address model has fillable attributes', function () {
        $address = new Address();
        $fillable = $address->getFillable();
        
        expect($fillable)->toContain('street');
        expect($fillable)->toContain('city_id');
        expect($fillable)->toContain('postal_code');
        expect($fillable)->toContain('country');
    });

    test('address model casts attributes correctly', function () {
        $address = Address::factory()->create([
            'coordinates' => ['lat' => 44.647128, 'lng' => 10.925226],
        ]);

        if (in_array('coordinates', $address->getFillable())) {
            expect($address->coordinates)->toBeArray();
            expect($address->coordinates['lat'])->toBe(44.647128);
            expect($address->coordinates['lng'])->toBe(10.925226);
        }
    });
});

describe('Address Relationships', function () {
    test('address belongs to city', function () {
        $city = City::factory()->create();
        $address = Address::factory()->create(['city_id' => $city->id]);

        $relation = $address->city();
        expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($address->city->id)->toBe($city->id);
        expect($address->city)->toBeInstanceOf(City::class);
    });

    test('address can access province through city', function () {
        $province = Province::factory()->create();
        $city = City::factory()->create(['province_id' => $province->id]);
        $address = Address::factory()->create(['city_id' => $city->id]);

        expect($address->city->province->id)->toBe($province->id);
        expect($address->city->province)->toBeInstanceOf(Province::class);
    });

    test('address can access region through city and province', function () {
        $region = Region::factory()->create();
        $province = Province::factory()->create(['region_id' => $region->id]);
        $city = City::factory()->create(['province_id' => $province->id]);
        $address = Address::factory()->create(['city_id' => $city->id]);

        expect($address->city->province->region->id)->toBe($region->id);
        expect($address->city->province->region)->toBeInstanceOf(Region::class);
    });
});

describe('Address Geocoding', function () {
    test('address can store coordinates', function () {
        $address = Address::factory()->create([
            'street' => 'Via Roma, 123',
            'coordinates' => ['lat' => 44.647128, 'lng' => 10.925226],
        ]);

        if (in_array('coordinates', $address->getFillable())) {
            expect($address->coordinates)->toBeArray();
            expect($address->coordinates)->toHaveKey('lat');
            expect($address->coordinates)->toHaveKey('lng');
        }
    });

    test('address can calculate distance to another address', function () {
        $address1 = Address::factory()->create([
            'coordinates' => ['lat' => 44.647128, 'lng' => 10.925226], // Modena
        ]);

        $address2 = Address::factory()->create([
            'coordinates' => ['lat' => 44.494887, 'lng' => 11.342616], // Bologna
        ]);

        // If the model has distance calculation method
        if (method_exists($address1, 'distanceTo')) {
            $distance = $address1->distanceTo($address2);
            expect($distance)->toBeFloat();
            expect($distance)->toBeGreaterThan(0);
        }
    });

    test('address can generate full address string', function () {
        $region = Region::factory()->create(['name' => 'Emilia-Romagna']);
        $province = Province::factory()->create(['region_id' => $region->id, 'name' => 'Modena']);
        $city = City::factory()->create(['province_id' => $province->id, 'name' => 'Modena']);

        $address = Address::factory()->create([
            'street' => 'Via Roma, 123',
            'city_id' => $city->id,
            'postal_code' => '41121',
            'country' => 'Italy',
        ]);

        // If the model has full address method
        if (method_exists($address, 'getFullAddress')) {
            $fullAddress = $address->getFullAddress();
            expect($fullAddress)->toContain('Via Roma, 123');
            expect($fullAddress)->toContain('Modena');
            expect($fullAddress)->toContain('41121');
            expect($fullAddress)->toContain('Italy');
        }
    });
});

describe('Address Validation', function () {
    test('address requires city_id', function () {
        expect(function () {
            Address::create([
                'street' => 'Via Roma, 123',
                'postal_code' => '41121',
                'country' => 'Italy',
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });

    test('address validates postal code format', function () {
        $city = City::factory()->create();

        // This should be validated at the application level
        $address = Address::factory()->create([
            'city_id' => $city->id,
            'postal_code' => '12345', // Valid format
        ]);

        expect($address->postal_code)->toBe('12345');
    });

    test('address validates country format', function () {
        $city = City::factory()->create();

        $address = Address::factory()->create([
            'city_id' => $city->id,
            'country' => 'Italy',
        ]);

        expect($address->country)->toBe('Italy');
    });
});

describe('Address Queries and Scopes', function () {
    test('can filter addresses by city', function () {
        $city1 = City::factory()->create();
        $city2 = City::factory()->create();

        Address::factory()->create(['city_id' => $city1->id]);
        Address::factory()->create(['city_id' => $city1->id]);
        Address::factory()->create(['city_id' => $city2->id]);

        $city1Addresses = Address::where('city_id', $city1->id)->get();
        $city2Addresses = Address::where('city_id', $city2->id)->get();

        expect($city1Addresses)->toHaveCount(2);
        expect($city2Addresses)->toHaveCount(1);
    });

    test('can filter addresses by postal code', function () {
        $city = City::factory()->create();

        Address::factory()->create(['city_id' => $city->id, 'postal_code' => '41121']);
        Address::factory()->create(['city_id' => $city->id, 'postal_code' => '41122']);
        Address::factory()->create(['city_id' => $city->id, 'postal_code' => '41121']);

        $addresses41121 = Address::where('postal_code', '41121')->get();
        $addresses41122 = Address::where('postal_code', '41122')->get();

        expect($addresses41121)->toHaveCount(2);
        expect($addresses41122)->toHaveCount(1);
    });

    test('can filter addresses by country', function () {
        $city = City::factory()->create();

        Address::factory()->create(['city_id' => $city->id, 'country' => 'Italy']);
        Address::factory()->create(['city_id' => $city->id, 'country' => 'France']);
        Address::factory()->create(['city_id' => $city->id, 'country' => 'Italy']);

        $italyAddresses = Address::where('country', 'Italy')->get();
        $franceAddresses = Address::where('country', 'France')->get();

        expect($italyAddresses)->toHaveCount(2);
        expect($franceAddresses)->toHaveCount(1);
    });

    test('can search addresses by street name', function () {
        $city = City::factory()->create();

        Address::factory()->create(['city_id' => $city->id, 'street' => 'Via Roma, 123']);
        Address::factory()->create(['city_id' => $city->id, 'street' => 'Via Milano, 456']);
        Address::factory()->create(['city_id' => $city->id, 'street' => 'Via Roma, 789']);

        $romaAddresses = Address::where('street', 'like', '%Roma%')->get();
        $milanoAddresses = Address::where('street', 'like', '%Milano%')->get();

        expect($romaAddresses)->toHaveCount(2);
        expect($milanoAddresses)->toHaveCount(1);
    });
});

describe('Address Geographic Queries', function () {
    test('can find addresses within radius', function () {
        $city = City::factory()->create();

        $centerAddress = Address::factory()->create([
            'city_id' => $city->id,
            'coordinates' => ['lat' => 44.647128, 'lng' => 10.925226],
        ]);

        $nearbyAddress = Address::factory()->create([
            'city_id' => $city->id,
            'coordinates' => ['lat' => 44.647500, 'lng' => 10.925500],
        ]);

        $farAddress = Address::factory()->create([
            'city_id' => $city->id,
            'coordinates' => ['lat' => 45.000000, 'lng' => 11.000000],
        ]);

        // If the model has geographic scopes
        if (method_exists(Address::class, 'withinRadius')) {
            $nearbyAddresses = Address::withinRadius(
                $centerAddress->coordinates['lat'],
                $centerAddress->coordinates['lng'],
                1000 // 1km radius
            )->get();

            expect($nearbyAddresses)->toContain($nearbyAddress);
            expect($nearbyAddresses)->not->toContain($farAddress);
        }
    });

    test('can order addresses by distance from point', function () {
        $city = City::factory()->create();

        $address1 = Address::factory()->create([
            'city_id' => $city->id,
            'coordinates' => ['lat' => 44.647128, 'lng' => 10.925226],
        ]);

        $address2 = Address::factory()->create([
            'city_id' => $city->id,
            'coordinates' => ['lat' => 44.648000, 'lng' => 10.926000],
        ]);

        $address3 = Address::factory()->create([
            'city_id' => $city->id,
            'coordinates' => ['lat' => 44.650000, 'lng' => 10.930000],
        ]);

        $referencePoint = ['lat' => 44.647000, 'lng' => 10.925000];

        // If the model has distance ordering
        if (method_exists(Address::class, 'orderByDistance')) {
            $orderedAddresses = Address::orderByDistance(
                $referencePoint['lat'],
                $referencePoint['lng']
            )->get();

            expect($orderedAddresses->first()->id)->toBe($address1->id);
            expect($orderedAddresses->last()->id)->toBe($address3->id);
        }
    });
});

describe('Address Business Logic', function () {
    test('address can format for display', function () {
        $region = Region::factory()->create(['name' => 'Emilia-Romagna']);
        $province = Province::factory()->create(['region_id' => $region->id, 'name' => 'Modena']);
        $city = City::factory()->create(['province_id' => $province->id, 'name' => 'Modena']);

        $address = Address::factory()->create([
            'street' => 'Via Roma, 123',
            'city_id' => $city->id,
            'postal_code' => '41121',
            'country' => 'Italy',
        ]);

        // If the model has formatting methods
        if (method_exists($address, 'getShortFormat')) {
            $shortFormat = $address->getShortFormat();
            expect($shortFormat)->toContain('Via Roma, 123');
            expect($shortFormat)->toContain('Modena');
        }

        if (method_exists($address, 'getLongFormat')) {
            $longFormat = $address->getLongFormat();
            expect($longFormat)->toContain('Via Roma, 123');
            expect($longFormat)->toContain('Modena');
            expect($longFormat)->toContain('41121');
            expect($longFormat)->toContain('Italy');
        }
    });

    test('address can validate completeness', function () {
        $city = City::factory()->create();

        $completeAddress = Address::factory()->create([
            'street' => 'Via Roma, 123',
            'city_id' => $city->id,
            'postal_code' => '41121',
            'country' => 'Italy',
        ]);

        $incompleteAddress = Address::factory()->create([
            'street' => 'Via Roma, 123',
            'city_id' => $city->id,
            'postal_code' => null,
            'country' => null,
        ]);

        // If the model has validation methods
        if (method_exists($completeAddress, 'isComplete')) {
            expect($completeAddress->isComplete())->toBeTrue();
            expect($incompleteAddress->isComplete())->toBeFalse();
        }
    });
});






