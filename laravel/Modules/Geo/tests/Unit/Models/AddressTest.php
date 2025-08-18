<?php

declare(strict_types=1);

use Modules\Geo\Models\Address;

test('address can be created', function () {
    $address = createAddress([
        'street' => 'Via Roma 123',
        'city' => 'Milano',
        'province' => 'MI',
        'region' => 'Lombardia',
        'postal_code' => '20100',
        'country' => 'IT',
    ]);

    expect($address)
        ->toBeAddress()
        ->and($address->street)->toBe('Via Roma 123')
        ->and($address->city)->toBe('Milano')
        ->and($address->province)->toBe('MI')
        ->and($address->postal_code)->toBe('20100');
});

test('address has required attributes', function () {
    $address = makeAddress();

    expect($address)
        ->toHaveProperty('street')
        ->toHaveProperty('city')
        ->toHaveProperty('province')
        ->toHaveProperty('region')
        ->toHaveProperty('postal_code')
        ->toHaveProperty('country');
});

test('address full address is formatted correctly', function () {
    $address = createAddress([
        'street' => 'Via Roma 123',
        'city' => 'Milano',
        'province' => 'MI',
        'postal_code' => '20100',
    ]);
    
    expect($address->full_address)
        ->toContain('Via Roma 123')
        ->toContain('Milano')
        ->toContain('MI')
        ->toContain('20100');
});
