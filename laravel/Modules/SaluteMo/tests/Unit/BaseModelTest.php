<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit;

use Modules\SaluteMo\Models\BaseModel;

describe('SaluteMo BaseModel Business Logic', function () {
    $makeModel = fn () => new class extends BaseModel {
        protected $table = 'test_models';
    };

    it('exposes casts as array', function () use ($makeModel) {
        $model = $makeModel();
        expect($model->getCasts())->toBeArray();
    });

    it('supports media methods presence', function () use ($makeModel) {
        $model = $makeModel();
        expect(method_exists($model, 'getMedia'))->toBeTrue();
    });
});
