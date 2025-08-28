<?php

declare(strict_types=1);

use Modules\Activity\Models\Activity;

describe('Activity Business Logic', function () {
    test('activity has correct connection configured', function () {
        $activity = new Activity();
        
        expect($activity->getConnectionName())->toBe('activity');
    });

    test('activity has expected fillable fields', function () {
        $activity = new Activity();
        $expectedFillable = [
            'id',
            'log_name',
            'description',
            'subject_type',
            'event',
            'subject_id',
            'causer_type',
            'causer_id',
            'properties',
            'batch_uuid',
            'created_at',
            'updated_at',
        ];
        
        expect($activity->getFillable())->toEqual($expectedFillable);
    });

    test('activity extends spatie activity functionality', function () {
        expect(Activity::class)->toBeSubclassOf(\Spatie\Activitylog\Models\Activity::class);
    });

    test('activity can be queried by log name', function () {
        $query = Activity::inLog('test_log');
        
        expect($query)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);
    });

    test('activity can be queried by event type', function () {
        $query = Activity::forEvent('created');
        
        expect($query)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);
    });

    test('activity can be queried by batch', function () {
        $query = Activity::hasBatch();
        
        expect($query)->toBeInstanceOf(\Illuminate\Database\Eloquent\Builder::class);
    });
});