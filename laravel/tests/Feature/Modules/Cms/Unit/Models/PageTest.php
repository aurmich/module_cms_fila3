<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;

beforeEach(function () {
    if (!moduleEnabled('Cms')) {
        $this->markTestSkipped('Module Cms is disabled');
    }
});

describe('Page Model', function () {
    test('can create page with basic attributes', function () {
        $page = Page::factory()->create([
            'title' => 'Test Page',
            'slug' => 'test-page',
            'content' => 'This is test content',
            'status' => 'published',
        ]);

        expect($page->title)->toBe('Test Page');
        expect($page->slug)->toBe('test-page');
        expect($page->content)->toBe('This is test content');
        expect($page->status)->toBe('published');
        expect($page->exists)->toBeTrue();
    });

    test('page model uses correct table', function () {
        $page = new Page();
        expect($page->getTable())->toBe('pages');
    });

    test('page model has fillable attributes', function () {
        $page = new Page();
        $fillable = $page->getFillable();
        
        expect($fillable)->toContain('title');
        expect($fillable)->toContain('slug');
        expect($fillable)->toContain('content');
        expect($fillable)->toContain('status');
    });

    test('page slug is unique', function () {
        Page::factory()->create(['slug' => 'unique-page']);

        expect(function () {
            Page::create([
                'title' => 'Another Page',
                'slug' => 'unique-page',
                'content' => 'Content',
                'status' => 'published',
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });

    test('can filter pages by status', function () {
        Page::factory()->create(['status' => 'published']);
        Page::factory()->create(['status' => 'draft']);
        Page::factory()->create(['status' => 'published']);

        $published = Page::where('status', 'published')->get();
        $drafts = Page::where('status', 'draft')->get();

        expect($published)->toHaveCount(2);
        expect($drafts)->toHaveCount(1);
    });
});

