<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;

describe('Page Business Logic', function () {
    test('page extends base model lang for multilingual support', function () {
        expect(Page::class)->toBeSubclassOf(\Modules\Cms\Models\BaseModelLang::class);
    });

    test('page has translatable fields configured', function () {
        $page = new Page();
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        expect($page->translatable)->toEqual([
            'title',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ]);
    });

    test('page has expected fillable fields', function () {
        $page = new Page();
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
        
>>>>>>> bc33217 (.)
        expect($page->getFillable())->toEqual($expectedFillable);
    });

    test('page has sushi to json trait', function () {
        $traits = class_uses(Page::class);
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        expect($traits)->toHaveKey(\Modules\Tenant\Models\Traits\SushiToJsons::class);
    });

    test('page can get middleware by slug', function () {
        $middleware = Page::getMiddlewareBySlug('non-existent-slug');
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        expect($middleware)->toBeArray();
    });

    test('page has correct casts for blocks and arrays', function () {
        $page = new Page();
        $casts = $page->getCasts();
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        expect($casts['content_blocks'])->toBe('array');
        expect($casts['sidebar_blocks'])->toBe('array');
        expect($casts['footer_blocks'])->toBe('array');
        expect($casts['middleware'])->toBe('array');
    });

    test('page has schema definition for structured data', function () {
        $page = new Page();
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        expect($page)->toHaveProperty('schema');
        expect($page->schema['content_blocks'])->toBe('json');
        expect($page->schema['sidebar_blocks'])->toBe('json');
        expect($page->schema['footer_blocks'])->toBe('json');
    });

    test('page can get rows for sushi functionality', function () {
        $page = new Page();
<<<<<<< HEAD

        expect(method_exists($page, 'getRows'))->toBeTrue();
    });
});
=======
        
        expect(method_exists($page, 'getRows'))->toBeTrue();
    });
});
>>>>>>> bc33217 (.)
