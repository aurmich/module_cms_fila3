<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;

describe('Page Business Logic', function () {
    test('page extends base model lang for multilingual support', function () {
        expect(Page::class)->toBeSubclassOf(\Modules\Cms\Models\BaseModelLang::class);
    });

    test('page has translatable fields configured', function () {
<<<<<<< HEAD
        $page = new Page();
        
=======
        $page = new Page;

>>>>>>> b32aaf5 (.)
        expect($page->translatable)->toEqual([
            'title',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ]);
    });

    test('page has expected fillable fields', function () {
<<<<<<< HEAD
        $page = new Page();
=======
        $page = new Page;
>>>>>>> b32aaf5 (.)
        $expectedFillable = [
            'content',
            'slug',
            'title',
            'middleware',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ];
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($page->getFillable())->toEqual($expectedFillable);
    });

    test('page has sushi to json trait', function () {
        $traits = class_uses(Page::class);
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($traits)->toHaveKey(\Modules\Tenant\Models\Traits\SushiToJsons::class);
    });

    test('page can get middleware by slug', function () {
        $middleware = Page::getMiddlewareBySlug('non-existent-slug');
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($middleware)->toBeArray();
    });

    test('page has correct casts for blocks and arrays', function () {
<<<<<<< HEAD
        $page = new Page();
        $casts = $page->getCasts();
        
=======
        $page = new Page;
        $casts = $page->getCasts();

>>>>>>> b32aaf5 (.)
        expect($casts['content_blocks'])->toBe('array');
        expect($casts['sidebar_blocks'])->toBe('array');
        expect($casts['footer_blocks'])->toBe('array');
        expect($casts['middleware'])->toBe('array');
    });

    test('page has schema definition for structured data', function () {
<<<<<<< HEAD
        $page = new Page();
        
=======
        $page = new Page;

>>>>>>> b32aaf5 (.)
        expect($page)->toHaveProperty('schema');
        expect($page->schema['content_blocks'])->toBe('json');
        expect($page->schema['sidebar_blocks'])->toBe('json');
        expect($page->schema['footer_blocks'])->toBe('json');
    });

    test('page can get rows for sushi functionality', function () {
<<<<<<< HEAD
        $page = new Page();
        
        expect(method_exists($page, 'getRows'))->toBeTrue();
    });
});
=======
        $page = new Page;

        expect(method_exists($page, 'getRows'))->toBeTrue();
    });
});
>>>>>>> b32aaf5 (.)
