<?php

declare(strict_types=1);

use Modules\Activity\Models\StoredEvent;

describe('StoredEvent Business Logic', function () {
    test('stored event has correct connection configured', function () {
        $storedEvent = new StoredEvent();
        
        expect($storedEvent->getConnectionName())->toBe('activity');
    });

    test('stored event has correct table configured', function () {
        $storedEvent = new StoredEvent();
        
        expect($storedEvent->getTable())->toBe('stored_events');
    });

    test('stored event has expected fillable fields for event sourcing', function () {
        $storedEvent = new StoredEvent();
        $expectedFillable = [
            'id',
            'aggregate_uuid',
            'aggregate_version',
            'event_version',
            'event_class',
            'event_properties',
            'meta_data',
            'created_at',
            'updated_by',
            'created_by',
        ];
        
        expect($storedEvent->getFillable())->toEqual($expectedFillable);
    });

    test('stored event extends eloquent stored event for event sourcing', function () {
        expect(StoredEvent::class)->toBeSubclassOf(\Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent::class);
    });

    test('stored event has factory trait for testing', function () {
        $traits = class_uses(StoredEvent::class);
        
        expect($traits)->toHaveKey(\Illuminate\Database\Eloquent\Factories\HasFactory::class);
    });

    test('stored event can be queried after version', function () {
        $query = StoredEvent::afterVersion(1);
        
        expect($query)->toBeInstanceOf(\Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder::class);
    });

    test('stored event can be queried by aggregate uuid', function () {
        $query = StoredEvent::whereAggregateRoot('test-uuid');
        
        expect($query)->toBeInstanceOf(\Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder::class);
    });

    test('stored event can filter by event class', function () {
        $query = StoredEvent::whereEvent('TestEvent');
        
        expect($query)->toBeInstanceOf(\Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder::class);
    });
});