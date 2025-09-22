<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\MenuResource;
<<<<<<< HEAD
use Modules\Cms\Filament\Resources\PageContentResource;
use Modules\Cms\Filament\Resources\PageResource;
=======
use Modules\Cms\Filament\Resources\PageResource;
use Modules\Cms\Filament\Resources\PageContentResource;
>>>>>>> bc33217 (.)
use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Xot\Filament\Resources\XotBaseResource;

test('cms resources extend proper base resources', function () {
    // Multilingual resources should extend LangBaseResource
<<<<<<< HEAD
    expect(PageResource::class)->toBeSubclassOf(LangBaseResource::class);

    expect(PageContentResource::class)->toBeSubclassOf(LangBaseResource::class);

    expect(SectionResource::class)->toBeSubclassOf(LangBaseResource::class);

    // Non-multilingual resources should extend XotBaseResource
    expect(MenuResource::class)->toBeSubclassOf(XotBaseResource::class);
=======
    expect(PageResource::class)
        ->toBeSubclassOf(LangBaseResource::class);
    
    expect(PageContentResource::class)
        ->toBeSubclassOf(LangBaseResource::class);
    
    expect(SectionResource::class)
        ->toBeSubclassOf(LangBaseResource::class);
    
    // Non-multilingual resources should extend XotBaseResource
    expect(MenuResource::class)
        ->toBeSubclassOf(XotBaseResource::class);
>>>>>>> bc33217 (.)
});

test('cms resources do not implement unnecessary methods', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
<<<<<<< HEAD
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $reflection = new ReflectionClass($resourceClass);

        expect($reflection->hasMethod('getPages'))
            ->toBeFalse()
            ->with("{$resourceClass} should not implement getPages()")
            ->and($reflection->hasMethod('getRelations'))
            ->toBeFalse()
            ->with("{$resourceClass} should not implement getRelations()")
            ->and($reflection->hasMethod('form'))
            ->toBeFalse()
            ->with("{$resourceClass} should not implement form()")
            ->and($reflection->hasMethod('table'))
            ->toBeFalse()
=======
        MenuResource::class
    ];
    
    foreach ($resources as $resourceClass) {
        $reflection = new ReflectionClass($resourceClass);
        
        expect($reflection->hasMethod('getPages'))->toBeFalse()
            ->with("{$resourceClass} should not implement getPages()")
            ->and($reflection->hasMethod('getRelations'))->toBeFalse()
            ->with("{$resourceClass} should not implement getRelations()")
            ->and($reflection->hasMethod('form'))->toBeFalse()
            ->with("{$resourceClass} should not implement form()")
            ->and($reflection->hasMethod('table'))->toBeFalse()
>>>>>>> bc33217 (.)
            ->with("{$resourceClass} should not implement table()");
    }
});

test('cms resources implement required getFormSchema method', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
<<<<<<< HEAD
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $reflection = new ReflectionClass($resourceClass);

        expect($reflection->hasMethod('getFormSchema'))
            ->toBeTrue()
            ->with("{$resourceClass} must implement getFormSchema()");

        $method = $reflection->getMethod('getFormSchema');
        expect($method->isPublic())
            ->toBeTrue()
            ->with("{$resourceClass}::getFormSchema() must be public")
            ->and($method->isStatic())
            ->toBeTrue()
            ->with("{$resourceClass}::getFormSchema() must be static")
            ->and($method->getReturnType()?->getName())
            ->toBe('array')
=======
        MenuResource::class
    ];
    
    foreach ($resources as $resourceClass) {
        $reflection = new ReflectionClass($resourceClass);
        
        expect($reflection->hasMethod('getFormSchema'))->toBeTrue()
            ->with("{$resourceClass} must implement getFormSchema()");
        
        $method = $reflection->getMethod('getFormSchema');
        expect($method->isPublic())->toBeTrue()
            ->with("{$resourceClass}::getFormSchema() must be public")
            ->and($method->isStatic())->toBeTrue()
            ->with("{$resourceClass}::getFormSchema() must be static")
            ->and($method->getReturnType()?->getName())->toBe('array')
>>>>>>> bc33217 (.)
            ->with("{$resourceClass}::getFormSchema() must return array");
    }
});

test('cms resources have correct model configuration', function () {
<<<<<<< HEAD
    expect(PageResource::getModel())->toBe('Modules\\Cms\\Models\\Page');

    expect(PageContentResource::getModel())->toBe('Modules\\Cms\\Models\\PageContent');

    expect(SectionResource::getModel())->toBe('Modules\\Cms\\Models\\Section');

    expect(MenuResource::getModel())->toBe('Modules\\Cms\\Models\\Menu');
=======
    expect(PageResource::getModel())
        ->toBe('Modules\\Cms\\Models\\Page');
    
    expect(PageContentResource::getModel())
        ->toBe('Modules\\Cms\\Models\\PageContent');
    
    expect(SectionResource::getModel())
        ->toBe('Modules\\Cms\\Models\\Section');
    
    expect(MenuResource::getModel())
        ->toBe('Modules\\Cms\\Models\\Menu');
>>>>>>> bc33217 (.)
});

test('multilingual resources provide translatable locales', function () {
    $multilingualResources = [
        PageResource::class,
        PageContentResource::class,
<<<<<<< HEAD
        SectionResource::class,
    ];

    foreach ($multilingualResources as $resourceClass) {
        $locales = $resourceClass::getTranslatableLocales();

        expect($locales)
            ->toBeArray()
            ->not->toBeEmpty()->with("{$resourceClass} must provide translatable locales")->and($locales)->toContain(
                'it',
                'en',
            )->with("{$resourceClass} must support Italian and English locales");
=======
        SectionResource::class
    ];
    
    foreach ($multilingualResources as $resourceClass) {
        $locales = $resourceClass::getTranslatableLocales();
        
        expect($locales)->toBeArray()->not->toBeEmpty()
            ->with("{$resourceClass} must provide translatable locales")
            ->and($locales)->toContain('it', 'en')
            ->with("{$resourceClass} must support Italian and English locales");
>>>>>>> bc33217 (.)
    }
});

test('cms resource form schemas return valid arrays', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
<<<<<<< HEAD
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $schema = $resourceClass::getFormSchema();

        expect($schema)
            ->toBeArray()
            ->not->toBeEmpty()->with("{$resourceClass}::getFormSchema() must return non-empty array");
=======
        MenuResource::class
    ];
    
    foreach ($resources as $resourceClass) {
        $schema = $resourceClass::getFormSchema();
        
        expect($schema)->toBeArray()->not->toBeEmpty()
            ->with("{$resourceClass}::getFormSchema() must return non-empty array");
>>>>>>> bc33217 (.)
    }
});

test('page resource form schema contains expected fields', function () {
    $schema = PageResource::getFormSchema();
<<<<<<< HEAD

    expect($schema)->toBeArray()->not->toBeEmpty();

    // Check for basic field structure
    $hasTitleField = collect($schema)
        ->contains(
            fn($field) => is_object($field) && method_exists($field, 'getName') && $field->getName() === 'title',
        );

    $hasSlugField = collect($schema)
        ->contains(fn($field) => is_object($field) && method_exists($field, 'getName') && $field->getName() === 'slug');

=======
    
    expect($schema)->toBeArray()->not->toBeEmpty();
    
    // Check for basic field structure
    $hasTitleField = collect($schema)->contains(fn($field) => 
        is_object($field) && method_exists($field, 'getName') && $field->getName() === 'title'
    );
    
    $hasSlugField = collect($schema)->contains(fn($field) =>
        is_object($field) && method_exists($field, 'getName') && $field->getName() === 'slug'
    );
    
>>>>>>> bc33217 (.)
    expect($hasTitleField)->toBeTrue('PageResource should have title field');
    expect($hasSlugField)->toBeTrue('PageResource should have slug field');
});

test('menu resource form schema contains expected fields', function () {
    $schema = MenuResource::getFormSchema();
<<<<<<< HEAD

    expect($schema)->toBeArray()->not->toBeEmpty();

    // Check for basic field structure
    $hasTitleField = collect($schema)
        ->contains(
            fn($field) => is_object($field) && method_exists($field, 'getName') && $field->getName() === 'title',
        );

    $hasItemsField = collect($schema)
        ->contains(
            fn($field) => is_object($field) && method_exists($field, 'getName') && $field->getName() === 'items',
        );

=======
    
    expect($schema)->toBeArray()->not->toBeEmpty();
    
    // Check for basic field structure
    $hasTitleField = collect($schema)->contains(fn($field) => 
        is_object($field) && method_exists($field, 'getName') && $field->getName() === 'title'
    );
    
    $hasItemsField = collect($schema)->contains(fn($field) =>
        is_object($field) && method_exists($field, 'getName') && $field->getName() === 'items'
    );
    
>>>>>>> bc33217 (.)
    expect($hasTitleField)->toBeTrue('MenuResource should have title field');
    expect($hasItemsField)->toBeTrue('MenuResource should have items field');
});

test('resources use proper base resource functionality', function () {
    $resources = [
        PageResource::class,
        PageContentResource::class,
        SectionResource::class,
<<<<<<< HEAD
        MenuResource::class,
    ];

    foreach ($resources as $resourceClass) {
        $pages = $resourceClass::getPages();
        $relations = $resourceClass::getRelations();

        expect($pages)
            ->toBeArray()
            ->toHaveKeys(['index', 'create', 'edit'])
            ->with("{$resourceClass} should have standard pages");

        expect($relations)->toBeArray()->with("{$resourceClass} should return relations array");
=======
        MenuResource::class
    ];
    
    foreach ($resources as $resourceClass) {
        $pages = $resourceClass::getPages();
        $relations = $resourceClass::getRelations();
        
        expect($pages)->toBeArray()->toHaveKeys(['index', 'create', 'edit'])
            ->with("{$resourceClass} should have standard pages");
        
        expect($relations)->toBeArray()
            ->with("{$resourceClass} should return relations array");
>>>>>>> bc33217 (.)
    }
});

test('resources follow naming conventions', function () {
    expect(class_basename(PageResource::class))->toBe('PageResource');
    expect(class_basename(PageContentResource::class))->toBe('PageContentResource');
    expect(class_basename(SectionResource::class))->toBe('SectionResource');
    expect(class_basename(MenuResource::class))->toBe('MenuResource');
<<<<<<< HEAD

=======
    
>>>>>>> bc33217 (.)
    // Test that model names are correctly derived
    expect(PageResource::getModel())->toBe('Modules\\Cms\\Models\\Page');
    expect(PageContentResource::getModel())->toBe('Modules\\Cms\\Models\\PageContent');
    expect(SectionResource::getModel())->toBe('Modules\\Cms\\Models\\Section');
    expect(MenuResource::getModel())->toBe('Modules\\Cms\\Models\\Menu');
});

test('lang base resource provides multilingual features', function () {
    $multilingualResources = [
        PageResource::class,
        PageContentResource::class,
<<<<<<< HEAD
        SectionResource::class,
    ];

=======
        SectionResource::class
    ];
    
>>>>>>> bc33217 (.)
    foreach ($multilingualResources as $resourceClass) {
        // Test that multilingual methods are available
        expect(method_exists($resourceClass, 'getTranslatableLocales'))->toBeTrue();
        expect(method_exists($resourceClass, 'getDefaultTranslatableLocale'))->toBeTrue();
<<<<<<< HEAD

        $locales = $resourceClass::getTranslatableLocales();
        $defaultLocale = $resourceClass::getDefaultTranslatableLocale();

        expect($locales)->toBeArray()->not->toBeEmpty();
        expect($defaultLocale)->toBeString()->not->toBeEmpty();
    }
});
=======
        
        $locales = $resourceClass::getTranslatableLocales();
        $defaultLocale = $resourceClass::getDefaultTranslatableLocale();
        
        expect($locales)->toBeArray()->not->toBeEmpty();
        expect($defaultLocale)->toBeString()->not->toBeEmpty();
    }
});
>>>>>>> bc33217 (.)
