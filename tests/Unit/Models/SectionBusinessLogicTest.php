<?php

declare(strict_types=1);

use Modules\Cms\Models\Section;

describe('Section Business Logic', function () {
    test('section extends base model lang for multilingual support', function () {
        expect(Section::class)->toBeSubclassOf(\Modules\Cms\Models\BaseModelLang::class);
    });

    test('section has translatable fields configured', function () {
<<<<<<< HEAD
        $section = new Section();
        
=======
        $section = new Section;

>>>>>>> b32aaf5 (.)
        expect($section->translatable)->toEqual([
            'name',
            'blocks',
        ]);
    });

    test('section has expected fillable fields', function () {
<<<<<<< HEAD
        $section = new Section();
=======
        $section = new Section;
>>>>>>> b32aaf5 (.)
        $expectedFillable = [
            'name',
            'slug',
            'blocks',
        ];
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($section->getFillable())->toEqual($expectedFillable);
    });

    test('section has sushi to json trait', function () {
        $traits = class_uses(Section::class);
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($traits)->toHaveKey(\Modules\Tenant\Models\Traits\SushiToJsons::class);
    });

    test('section has has blocks trait', function () {
        $traits = class_uses(Section::class);
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($traits)->toHaveKey(\Modules\Cms\Models\Traits\HasBlocks::class);
    });

    test('section has correct casts for multilingual and structured data', function () {
<<<<<<< HEAD
        $section = new Section();
        $casts = $section->getCasts();
        
=======
        $section = new Section;
        $casts = $section->getCasts();

>>>>>>> b32aaf5 (.)
        expect($casts['name'])->toBe('array');
        expect($casts['blocks'])->toBe('array');
        expect($casts['id'])->toBe('string');
    });

    test('section has schema definition for structured data', function () {
<<<<<<< HEAD
        $section = new Section();
        
=======
        $section = new Section;

>>>>>>> b32aaf5 (.)
        expect($section)->toHaveProperty('schema');
        expect($section->schema['name'])->toBe('json');
        expect($section->schema['blocks'])->toBe('json');
        expect($section->schema['slug'])->toBe('string');
    });

    test('section can get rows for sushi functionality', function () {
<<<<<<< HEAD
        $section = new Section();
        
        expect(method_exists($section, 'getRows'))->toBeTrue();
        expect($section->getRows())->toBeArray();
    });
});
=======
        $section = new Section;

        expect(method_exists($section, 'getRows'))->toBeTrue();
        expect($section->getRows())->toBeArray();
    });
});
>>>>>>> b32aaf5 (.)
