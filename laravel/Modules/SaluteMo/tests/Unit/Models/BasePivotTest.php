<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit\Models;

use Modules\SaluteMo\Models\BasePivot;

/**
 * Test class for BasePivot comprehensive coverage.
 */
class BasePivotTestClass extends BasePivot
{
    protected $table = 'test_base_pivots';
    
    /** @var list<string> */
    protected $fillable = ['foreign_key_1', 'foreign_key_2', 'pivot_data'];
}

describe('SaluteMo BasePivot Comprehensive', function () {
    beforeEach(function () {
        $this->pivot = new BasePivotTestClass();
    });

    describe('Basic Configuration', function () {
        it('extends Laravel Pivot class', function () {
            expect($this->pivot)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\Pivot::class);
        });

        it('has correct default settings', function () {
            expect($this->pivot->getIncrementing())->toBeTrue()
                ->and($this->pivot->getPerPage())->toBe(30)
                ->and($this->pivot->getConnectionName())->toBe('salute_ora')
                ->and($this->pivot->getKeyName())->toBe('id')
                ->and($this->pivot->getKeyType())->toBe('string');
        });

        it('has snake case attributes enabled', function () {
            expect(BasePivotTestClass::$snakeAttributes)->toBeTrue();
        });

        it('has correct connection configuration', function () {
            expect($this->pivot->getConnectionName())->toBe('salute_ora');
        });
    });

    describe('Traits Implementation', function () {
        it('uses Updater trait', function () {
            $traits = class_uses_recursive($this->pivot);
            
            expect($traits)->toHaveKey(\Modules\Xot\Traits\Updater::class);
        });
    });

    describe('Casting System', function () {
        it('has correct cast configuration', function () {
            $casts = $this->pivot->getCasts();
            
            expect($casts)->toHaveKey('id', 'string')
                ->and($casts)->toHaveKey('created_at', 'datetime')
                ->and($casts)->toHaveKey('updated_at', 'datetime')
                ->and($casts)->toHaveKey('deleted_at', 'datetime')
                ->and($casts)->toHaveKey('updated_by', 'string')
                ->and($casts)->toHaveKey('created_by', 'string')
                ->and($casts)->toHaveKey('deleted_by', 'string');
        });

        it('casts primary key as string to maintain consistency', function () {
            $casts = $this->pivot->getCasts();
            
            // Important: Primary key must be string to avoid type issues with related models
            expect($casts['id'])->toBe('string');
        });
    });

    describe('Attributes and Properties', function () {
        it('has correct appends configuration', function () {
            $appends = $this->pivot->getAppends();
            expect($appends)->toBeArray();
        });

        it('has correct primary key configuration', function () {
            expect($this->pivot->getKeyName())->toBe('id')
                ->and($this->pivot->getKeyType())->toBe('string')
                ->and($this->pivot->getIncrementing())->toBeTrue();
        });

        it('has correct fillable configuration', function () {
            $fillable = $this->pivot->getFillable();
            expect($fillable)->toContain('foreign_key_1', 'foreign_key_2', 'pivot_data');
        });
    });

    describe('Database Operations', function () {
        it('can create new pivot instance', function () {
            $pivot = new BasePivotTestClass([
                'foreign_key_1' => 'key1',
                'foreign_key_2' => 'key2',
                'pivot_data' => 'test data'
            ]);
            
            expect($pivot->foreign_key_1)->toBe('key1')
                ->and($pivot->foreign_key_2)->toBe('key2')
                ->and($pivot->pivot_data)->toBe('test data');
        });
    });

    describe('Pagination', function () {
        it('has correct per page setting', function () {
            expect($this->pivot->getPerPage())->toBe(30);
        });
    });

    describe('Updater Trait Integration', function () {
        it('has updater trait methods available', function () {
            // Check if Updater trait methods are available
            $methods = get_class_methods($this->pivot);
            
            // These methods come from Updater trait
            expect($methods)->toContain('getUpdatedAtColumn');
        });
    });

    describe('Pivot Specific Features', function () {
        it('inherits pivot functionality from Laravel', function () {
            expect($this->pivot)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\Pivot::class);
        });

        it('can work with pivot table relationships', function () {
            // BasePivot should support pivot table operations
            expect($this->pivot)->toHaveMethod('getTable')
                ->and($this->pivot)->toHaveMethod('getConnection');
        });
    });
});