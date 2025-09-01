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

>>>>>>> b32aaf5 (.)
        expect($traits)->toHaveKey(\Sushi\Sushi::class);
    });

    test('conf has expected fillable fields', function () {
<<<<<<< HEAD
        $conf = new Conf();
=======
        $conf = new Conf;
>>>>>>> b32aaf5 (.)
        $expectedFillable = [
            'id',
            'name',
        ];
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($conf->getFillable())->toEqual($expectedFillable);
    });

    test('conf uses name as route key', function () {
<<<<<<< HEAD
        $conf = new Conf();
        
=======
        $conf = new Conf;

>>>>>>> b32aaf5 (.)
        expect($conf->getRouteKeyName())->toBe('name');
    });

    test('conf can get rows from tenant service', function () {
<<<<<<< HEAD
        $conf = new Conf();
        
        expect(method_exists($conf, 'getRows'))->toBeTrue();
        expect($conf->getRows())->toBeArray();
    });
});
=======
        $conf = new Conf;

        expect(method_exists($conf, 'getRows'))->toBeTrue();
        expect($conf->getRows())->toBeArray();
    });
});
>>>>>>> b32aaf5 (.)
