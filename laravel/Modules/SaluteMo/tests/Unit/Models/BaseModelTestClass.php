<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit\Models;

use Modules\SaluteMo\Models\BaseModel;
use Modules\Xot\Actions\Factory\GetFactoryAction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Test class for BaseModel comprehensive coverage.
 */
class BaseModelTestClass extends BaseModel
{
    protected $table = 'test_base_models';
    
    /** @var list<string> */
    protected $fillable = ['name', 'description', 'status', 'data'];
    
    /** @return array<string, string> */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'data' => 'json',
            'status' => 'string',
        ]);
    }
}

describe('SaluteMo BaseModel Comprehensive', function () {
    beforeEach(function () {
        $this->model = new BaseModelTestClass();
    });

    describe('Basic Configuration', function () {
        it('has correct default settings', function () {
            expect($this->model->getIncrementing())->toBeTrue()
                ->and($this->model->getTimestamps())->toBeTrue()
                ->and($this->model->getPerPage())->toBe(30)
                ->and($this->model->getConnectionName())->toBe('salute_ora')
                ->and($this->model->getKeyName())->toBe('id')
                ->and($this->model->getKeyType())->toBe('string');
        });

        it('has snake case attributes enabled', function () {
            expect(BaseModelTestClass::$snakeAttributes)->toBeTrue();
        });

        it('has correct primary key configuration', function () {
            expect($this->model->getKeyName())->toBe('id')
                ->and($this->model->getKeyType())->toBe('string')
                ->and($this->model->getIncrementing())->toBeTrue();
        });

        it('has correct connection configuration', function () {
            expect($this->model->getConnectionName())->toBe('salute_ora');
        });
    });

    describe('Traits Implementation', function () {
        it('implements HasMedia interface', function () {
            expect($this->model)->toBeInstanceOf(\Spatie\MediaLibrary\HasMedia::class);
        });

        it('uses required traits', function () {
            $traits = class_uses_recursive($this->model);
            
            expect($traits)->toHaveKey(\Illuminate\Database\Eloquent\Factories\HasFactory::class)
                ->and($traits)->toHaveKey(\Spatie\MediaLibrary\InteractsWithMedia::class)
                ->and($traits)->toHaveKey(\Modules\Xot\Traits\Updater::class)
                ->and($traits)->toHaveKey(\Modules\Xot\Models\Traits\RelationX::class);
        });
    });

    describe('Factory Pattern', function () {
        it('has factory method', function () {
            expect(BaseModelTestClass::class)->toHaveMethod('factory');
        });

        it('uses GetFactoryAction for factory creation', function () {
            $reflection = new \ReflectionMethod(BaseModelTestClass::class, 'newFactory');
            $reflection->setAccessible(true);
            
            // Mock GetFactoryAction
            $mockAction = mock(GetFactoryAction::class);
            $mockFactory = mock(Factory::class);
            
            $mockAction->shouldReceive('execute')
                ->once()
                ->with(BaseModelTestClass::class)
                ->andReturn($mockFactory);
                
            app()->instance(GetFactoryAction::class, $mockAction);
            
            $result = $reflection->invoke($this->model);
            expect($result)->toBeInstanceOf(Factory::class);
        });
    });

    describe('Casting System', function () {
        it('has correct cast configuration', function () {
            $casts = $this->model->getCasts();
            
            expect($casts)->toHaveKey('id', 'string')
                ->and($casts)->toHaveKey('uuid', 'string')
                ->and($casts)->toHaveKey('published_at', 'datetime')
                ->and($casts)->toHaveKey('verified_at', 'datetime')
                ->and($casts)->toHaveKey('created_at', 'datetime')
                ->and($casts)->toHaveKey('updated_at', 'datetime')
                ->and($casts)->toHaveKey('deleted_at', 'datetime')
                ->and($casts)->toHaveKey('updated_by', 'string')
                ->and($casts)->toHaveKey('created_by', 'string')
                ->and($casts)->toHaveKey('deleted_by', 'string');
        });

        it('allows extending casts in child classes', function () {
            $casts = $this->model->getCasts();
            
            expect($casts)->toHaveKey('data', 'json')
                ->and($casts)->toHaveKey('status', 'string');
        });
    });

    describe('Media Library Integration', function () {
        it('can work with media collections', function () {
            expect($this->model)->toHaveMethod('addMedia')
                ->and($this->model)->toHaveMethod('getMedia')
                ->and($this->model)->toHaveMethod('addMediaCollection');
        });

        it('has media relationship methods', function () {
            expect($this->model)->toHaveMethod('media');
        });
    });

    describe('Attributes and Properties', function () {
        it('has correct appends configuration', function () {
            $appends = $this->model->getAppends();
            expect($appends)->toBeArray();
        });

        it('has correct hidden configuration', function () {
            $hidden = $this->model->getHidden();
            expect($hidden)->toBeArray();
        });

        it('has correct fillable configuration', function () {
            $fillable = $this->model->getFillable();
            expect($fillable)->toContain('name', 'description', 'status', 'data');
        });
    });

    describe('Database Operations', function () {
        it('can create new instance', function () {
            $model = new BaseModelTestClass([
                'name' => 'Test Name',
                'description' => 'Test Description'
            ]);
            
            expect($model->name)->toBe('Test Name')
                ->and($model->description)->toBe('Test Description');
        });

        it('handles JSON casting properly', function () {
            $data = ['key' => 'value', 'nested' => ['array' => true]];
            $model = new BaseModelTestClass(['data' => $data]);
            
            expect($model->data)->toBe($data);
        });
    });

    describe('Pagination', function () {
        it('has correct per page setting', function () {
            expect($this->model->getPerPage())->toBe(30);
        });
    });

    describe('Timestamps', function () {
        it('uses timestamps', function () {
            expect($this->model->timestamps)->toBeTrue();
        });

        it('has timestamp attributes in casts', function () {
            $casts = $this->model->getCasts();
            
            expect($casts)->toHaveKey('created_at', 'datetime')
                ->and($casts)->toHaveKey('updated_at', 'datetime');
        });
    });
});