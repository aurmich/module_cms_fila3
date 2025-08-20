<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit;

use Modules\SaluteMo\Models\BaseModel;

/**
 * Concrete implementation of BaseModel for testing purposes.
 */
class BaseModelTest extends BaseModel
{
    protected $table = 'test_models';
    
    /** @var list<string> */
    protected $fillable = ['name', 'description'];
}

describe('SaluteMo BaseModel', function () {
    it('has correct default configuration', function () {
        $model = new BaseModelTest();
        
        expect($model->getIncrementing())->toBeTrue()
            ->and($model->getTimestamps())->toBeTrue()
            ->and($model->getPerPage())->toBe(30)
            ->and($model->getConnectionName())->toBe('salute_ora')
            ->and($model->getKeyName())->toBe('id')
            ->and($model->getKeyType())->toBe('string');
    });

    it('has snake case attributes enabled', function () {
        expect(BaseModelTest::$snakeAttributes)->toBeTrue();
    });

    it('implements HasMedia interface', function () {
        $model = new BaseModelTest();
        
        expect($model)->toBeInstanceOf(\Spatie\MediaLibrary\HasMedia::class);
    });

    it('uses required traits', function () {
        $model = new BaseModelTest();
        $traits = class_uses_recursive($model);
        
        expect($traits)->toContain([
            \Illuminate\Database\Eloquent\Factories\HasFactory::class,
            \Spatie\MediaLibrary\InteractsWithMedia::class,
            \Modules\Xot\Traits\Updater::class,
            \Modules\Xot\Models\Traits\RelationX::class,
        ]);
    });

    it('has correct casts configuration', function () {
        $model = new BaseModelTest();
        $casts = $model->getCasts();
        
        expect($casts)->toHaveKeys([
            'id', 'uuid', 'published_at', 'verified_at',
            'created_at', 'updated_at', 'deleted_at',
            'updated_by', 'created_by', 'deleted_by'
        ])
        ->and($casts['id'])->toBe('string')
        ->and($casts['created_at'])->toBe('datetime')
        ->and($casts['updated_at'])->toBe('datetime');
    });

    it('has factory method', function () {
        expect(BaseModelTest::class)->toHaveMethod('factory');
    });

    it('can create media collections', function () {
        $model = new BaseModelTest();
        
        expect($model)->toHaveMethod('addMedia')
            ->and($model)->toHaveMethod('getMedia')
            ->and($model)->toHaveMethod('addMediaCollection');
    });
});