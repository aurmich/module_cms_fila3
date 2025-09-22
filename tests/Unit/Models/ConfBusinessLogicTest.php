<?php

declare(strict_types=1);

use Modules\Cms\Models\Conf;

describe('Conf Business Logic', function () {
    test('conf extends eloquent model', function () {
        expect(Conf::class)->toBeSubclassOf(\Illuminate\Database\Eloquent\Model::class);
    });

    test('conf uses sushi trait for in-memory data', function () {
        $traits = class_uses(Conf::class);
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        expect($traits)->toHaveKey(\Sushi\Sushi::class);
    });

    test('conf has expected fillable fields', function () {
        $conf = new Conf();
        $expectedFillable = [
            'id',
            'name',
        ];
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        expect($conf->getFillable())->toEqual($expectedFillable);
    });

    test('conf uses name as route key', function () {
        $conf = new Conf();
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        expect($conf->getRouteKeyName())->toBe('name');
    });

    test('conf can get rows from tenant service', function () {
        $conf = new Conf();
<<<<<<< HEAD

        expect(method_exists($conf, 'getRows'))->toBeTrue();
        expect($conf->getRows())->toBeArray();
    });
});
=======
        
        expect(method_exists($conf, 'getRows'))->toBeTrue();
        expect($conf->getRows())->toBeArray();
    });
});
>>>>>>> bc33217 (.)
