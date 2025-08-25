<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit;

use Modules\SaluteMo\Models\BaseModel;

// Create a simple concrete test model class to avoid anonymous class issues
class TestBaseModel extends BaseModel
{
    protected $table = 'test_models';
    protected $connection = 'sqlite';
}

describe('SaluteMo BaseModel Business Logic', function () {
    it('exposes casts as array', function () {
        // Reflect on the local subclass to avoid side-effects from base resolution
        $reflection = new \ReflectionClass(TestBaseModel::class);
        expect($reflection->hasMethod('casts'))->toBeTrue();

        $method = $reflection->getMethod('casts');
        expect($method->isProtected())->toBeTrue();
        expect($method->getReturnType()?->getName())->toBe('array');

        // Avoid invoking the Eloquent Model constructor which boots traits and
        // requires the application container (e.g., 'config' binding).
        $instance = $reflection->newInstanceWithoutConstructor();

        expect($method->invoke($instance))->toBeArray();
    });

    it('supports media methods presence', function () {
        expect(method_exists(TestBaseModel::class, 'getMedia'))->toBeTrue();
    });

    it('has correct trait usage', function () {
        $traits = class_uses_recursive(TestBaseModel::class);
        
        expect(array_key_exists(\Spatie\MediaLibrary\InteractsWithMedia::class, $traits))->toBeTrue();
        expect(array_key_exists(\Modules\Xot\Traits\Updater::class, $traits))->toBeTrue();
        expect(array_key_exists(\Illuminate\Database\Eloquent\Factories\HasFactory::class, $traits))->toBeTrue();
    });

    it('implements HasMedia interface', function () {
        expect(is_subclass_of(TestBaseModel::class, \Spatie\MediaLibrary\HasMedia::class))->toBeTrue();
    });
});
