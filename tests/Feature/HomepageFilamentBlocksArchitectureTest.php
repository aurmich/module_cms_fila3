<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

<<<<<<< HEAD
use function Pest\Laravel\get;
use Modules\UI\Actions\Block\GetAllBlocksAction;
=======
<<<<<<< HEAD
use Modules\UI\Actions\Block\GetAllBlocksAction;

use function Pest\Laravel\get;
=======
use function Pest\Laravel\get;
use Modules\UI\Actions\Block\GetAllBlocksAction;
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)

uses(\Modules\Cms\Tests\TestCase::class);

describe('Homepage Filament Builder Blocks - CMS Module', function () {
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    beforeEach(function () {
        $this->lang = app()->getLocale();
    });

    test('homepage renders through cms page component system', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang);
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang);
>>>>>>> 681ae6a (.)
        $response->assertOk();
        
        $content = $response->getContent();
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang);
        $response->assertOk();
        
        $content = $response->getContent();
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verify CMS page component integration
        expect($content)->toContain('x-page');
        expect($content)->toContain('side="content"');
        expect($content)->toContain('slug="home"');
    });

    test('json content structure is properly loaded by cms', function () {
        $homepageJsonPath = config_path('local/saluteora/database/content/pages/home.json');
        expect(file_exists($homepageJsonPath))->toBeTrue('Homepage JSON must exist for CMS');
<<<<<<< HEAD
        
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);
        
=======
<<<<<<< HEAD

        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);

=======
        
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verify CMS-specific JSON structure
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['slug'])->toBe('home');
        expect($homepageData['content_blocks'])->toHaveKey($this->lang);
<<<<<<< HEAD
        
=======
<<<<<<< HEAD

=======
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verify blocks structure for CMS processing
        $blocks = $homepageData['content_blocks'][$this->lang];
        foreach ($blocks as $block) {
            expect($block)->toHaveKeys(['type', 'data']);
            expect($block['data'])->toHaveKey('view');
            expect($block['data']['view'])->toContain('::components.blocks.');
        }
    });

    test('cms blocks discovery system works correctly', function () {
        $allBlocks = app(GetAllBlocksAction::class)->execute();
<<<<<<< HEAD
        
        expect($allBlocks)->toBeInstanceOf(\Spatie\LaravelData\DataCollection::class);
        expect($allBlocks->count())->toBeGreaterThan(0);
        
        // Verify CMS blocks are discovered
        $cmsBlocks = $allBlocks->filter(fn($block) => $block->module === 'Cms');
        if ($cmsBlocks->count() > 0) {
=======
<<<<<<< HEAD

        expect($allBlocks)->toBeInstanceOf(\Spatie\LaravelData\DataCollection::class);
        expect($allBlocks->count()/** @phpstan-ignore method.nonObject */)->toBeGreaterThan(0);

        // Verify CMS blocks are discovered
        $cmsBlocks = $allBlocks->filter(fn ($block) => $block->module === 'Cms');
=======
        
        expect($allBlocks)->toBeInstanceOf(\Spatie\LaravelData\DataCollection::class);
        expect($allBlocks->count()/** @phpstan-ignore method.nonObject */)->toBeGreaterThan(0);
        
        // Verify CMS blocks are discovered
        $cmsBlocks = $allBlocks->filter(fn($block) => $block->module === 'Cms');
>>>>>>> 09fa59df2d (.)
        if ($cmsBlocks->count()/** @phpstan-ignore method.nonObject */ > 0) {
>>>>>>> 681ae6a (.)
            $cmsBlocks->each(function ($block) {
                expect($block->toArray())->toHaveKeys(['name', 'class', 'module', 'path']);
                expect(class_exists($block->class))->toBeTrue("CMS block class {$block->class} should exist");
            });
        }
    });

    test('ui blocks render component processes homepage blocks', function () {
        // Verify the UI Blocks render component exists and works
        $blocksClass = \Modules\UI\View\Components\Render\Blocks::class;
        expect(class_exists($blocksClass))->toBeTrue('Blocks render component should exist');
<<<<<<< HEAD
        
=======
<<<<<<< HEAD

>>>>>>> 681ae6a (.)
        // Load homepage blocks
        $homepageData = json_decode(
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
            true
        );
        
        $blocks = $homepageData['content_blocks'][$this->lang];
<<<<<<< HEAD
        
=======

=======
        
        // Load homepage blocks
        $homepageData = json_decode(
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
            true
        );
        
        $blocks = $homepageData['content_blocks'][$this->lang];
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Test component instantiation with blocks
        $component = new $blocksClass($blocks);
        expect($component->blocks)->toEqual($blocks);
    });

    test('homepage content management through cms works correctly', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang);
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang);
>>>>>>> 681ae6a (.)
        $response->assertOk();
        
        $content = $response->getContent();
        
        // Load expected content from JSON
        $homepageData = json_decode(
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
            true
        );
        
        $blocks = $homepageData['content_blocks'][$this->lang];
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang);
        $response->assertOk();
        
        $content = $response->getContent();
        
        // Load expected content from JSON
        $homepageData = json_decode(
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
            true
        );
        
        $blocks = $homepageData['content_blocks'][$this->lang];
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verify that CMS-managed content appears on page
        foreach ($blocks as $block) {
            if (isset($block['data']['title'])) {
                expect($content)->toContain($block['data']['title']);
            }
            if (isset($block['data']['subtitle'])) {
                expect($content)->toContain($block['data']['subtitle']);
            }
        }
    });

    test('cms theme integration renders blocks correctly', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang);
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang);
>>>>>>> 681ae6a (.)
        $response->assertOk();
        
        $content = $response->getContent();
        
        // Verify theme-specific rendering
        expect($content)->toContain('pub_theme::');
        
        // Load blocks to verify theme views
        $homepageData = json_decode(
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
            true
        );
        
        $blocks = $homepageData['content_blocks'][$this->lang];
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang);
        $response->assertOk();
        
        $content = $response->getContent();
        
        // Verify theme-specific rendering
        expect($content)->toContain('pub_theme::');
        
        // Load blocks to verify theme views
        $homepageData = json_decode(
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
            true
        );
        
        $blocks = $homepageData['content_blocks'][$this->lang];
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        foreach ($blocks as $block) {
            $view = $block['data']['view'];
            expect($view)->toStartWith('pub_theme::');
            expect($view)->toContain('components.blocks');
        }
    });

    test('cms handles multilingual content correctly', function () {
        $homepageData = json_decode(
<<<<<<< HEAD
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
=======
<<<<<<< HEAD
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')),
>>>>>>> 681ae6a (.)
            true
        );
        
        // Verify CMS multilingual structure
        expect($homepageData['content_blocks'])->toBeArray();
        expect($homepageData['title'])->toBeArray();
        
        // Verify current locale has content
        expect($homepageData['content_blocks'])->toHaveKey($this->lang);
        expect($homepageData['title'])->toHaveKey($this->lang);
        
        // Test rendering with current locale
        $response = get('/' . $this->lang);
        $response->assertOk();
<<<<<<< HEAD
        
=======

=======
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
            true
        );
        
        // Verify CMS multilingual structure
        expect($homepageData['content_blocks'])->toBeArray();
        expect($homepageData['title'])->toBeArray();
        
        // Verify current locale has content
        expect($homepageData['content_blocks'])->toHaveKey($this->lang);
        expect($homepageData['title'])->toHaveKey($this->lang);
        
        // Test rendering with current locale
        $response = get('/' . $this->lang);
        $response->assertOk();
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $content = $response->getContent();
        expect($content)->toContain($homepageData['title'][$this->lang]);
    });

    test('cms page component passes correct data to blocks', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang);
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang);
>>>>>>> 681ae6a (.)
        $response->assertOk();
        
        $content = $response->getContent();
        
        // Verify page component attributes are correct
        expect($content)->toContain('side="content"');
        expect($content)->toContain('slug="home"');
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang);
        $response->assertOk();
        
        $content = $response->getContent();
        
        // Verify page component attributes are correct
        expect($content)->toContain('side="content"');
        expect($content)->toContain('slug="home"');
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // If user is authenticated, type should be passed
        if (auth()->check()) {
            expect($content)->toContain('type=');
        }
    });

    test('cms json storage pattern is consistent', function () {
        $pagesPath = config_path('local/saluteora/database/content/pages/');
        expect(file_exists($pagesPath))->toBeTrue('CMS pages directory should exist');
<<<<<<< HEAD
        
        $homepageJsonPath = $pagesPath . 'home.json';
=======
<<<<<<< HEAD

        $homepageJsonPath = $pagesPath.'home.json';
>>>>>>> 681ae6a (.)
        expect(file_exists($homepageJsonPath))->toBeTrue('Homepage JSON should exist');
        
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);
        
        // Verify CMS-required fields
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['slug'])->toBe('home');
<<<<<<< HEAD
        
=======

=======
        
        $homepageJsonPath = $pagesPath . 'home.json';
        expect(file_exists($homepageJsonPath))->toBeTrue('Homepage JSON should exist');
        
        $homepageData = json_decode(file_get_contents($homepageJsonPath), true);
        
        // Verify CMS-required fields
        expect($homepageData)->toHaveKeys(['id', 'slug', 'content_blocks']);
        expect($homepageData['slug'])->toBe('home');
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verify blocks structure
        foreach ($homepageData['content_blocks'] as $locale => $blocks) {
            expect($locale)->toBeString();
            expect($blocks)->toBeArray();
<<<<<<< HEAD
            
=======
<<<<<<< HEAD

=======
            
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            foreach ($blocks as $block) {
                expect($block)->toHaveKeys(['type', 'data']);
                expect($block['type'])->toBeString();
                expect($block['data'])->toBeArray();
                expect($block['data'])->toHaveKey('view');
            }
        }
    });

    test('cms blade syntax processing works in json', function () {
        $homepageData = json_decode(
<<<<<<< HEAD
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
=======
<<<<<<< HEAD
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')),
>>>>>>> 681ae6a (.)
            true
        );
        
        $blocks = $homepageData['content_blocks'][$this->lang];
        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');
        
        if ($landingBlock) {
            // Verify Blade syntax exists in JSON
            expect($landingBlock['data']['cta_link'])->toContain("{{ route('register') }}");
            
            // Verify it's processed correctly on the page
            $response = get('/' . $this->lang);
            $content = $response->getContent();
<<<<<<< HEAD
            
=======

=======
            file_get_contents(config_path('local/saluteora/database/content/pages/home.json')), 
            true
        );
        
        $blocks = $homepageData['content_blocks'][$this->lang];
        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');
        
        if ($landingBlock) {
            // Verify Blade syntax exists in JSON
            expect($landingBlock['data']['cta_link'])->toContain("{{ route('register') }}");
            
            // Verify it's processed correctly on the page
            $response = get('/' . $this->lang);
            $content = $response->getContent();
            
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            $expectedUrl = route('register');
            expect($content)->toContain($expectedUrl);
        }
    });

    test('cms renders valid html structure', function () {
<<<<<<< HEAD
        $response = get('/' . $this->lang);
=======
<<<<<<< HEAD
        $response = get('/'.$this->lang);
>>>>>>> 681ae6a (.)
        $response->assertOk();
        
        $content = $response->getContent();
<<<<<<< HEAD
        
=======

=======
        $response = get('/' . $this->lang);
        $response->assertOk();
        
        $content = $response->getContent();
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verify HTML structure
        expect($content)->toContain('<!DOCTYPE html>');
        expect($content)->toContain('<html');
        expect($content)->toContain('<head>');
        expect($content)->toContain('<body>');
        expect($content)->toContain('<title>');
<<<<<<< HEAD
        
=======
<<<<<<< HEAD

=======
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        // Verify meta tags
        expect($content)->toContain('<meta name="viewport"');
        expect($content)->toContain('<meta name="description"');
    });

    test('cms performance for block rendering is acceptable', function () {
        $startTime = microtime(true);
<<<<<<< HEAD
        
        $response = get('/' . $this->lang);
=======
<<<<<<< HEAD

        $response = get('/'.$this->lang);
>>>>>>> 681ae6a (.)
        $response->assertOk();
        
        $renderTime = microtime(true) - $startTime;
        
        // CMS should render blocks efficiently
        expect($renderTime)->toBeLessThan(2.0, 'CMS block rendering should be fast');
    });
<<<<<<< HEAD
});
=======
});
=======
        
        $response = get('/' . $this->lang);
        $response->assertOk();
        
        $renderTime = microtime(true) - $startTime;
        
        // CMS should render blocks efficiently
        expect($renderTime)->toBeLessThan(2.0, 'CMS block rendering should be fast');
    });
});
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
