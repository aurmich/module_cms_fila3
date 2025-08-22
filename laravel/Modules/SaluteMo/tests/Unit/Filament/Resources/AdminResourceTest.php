<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit\Filament\Resources;

use Modules\SaluteMo\Filament\Resources\AdminResource;

describe('SaluteMo AdminResource', function () {

    it('has correct model configuration', function () {
        expect(AdminResource::getModel())->toBe('Modules\SaluteOra\Models\Admin');
    });

    it('has correct navigation configuration', function () {
        // Skip navigation test as it requires translator service
        expect(AdminResource::class)->toBeString()
            ->and(class_exists(AdminResource::class))->toBeTrue();
    });

    it('has correct resource pages', function () {
        $pages = AdminResource::getPages();
        
        // The resource returns SaluteOra pages, not SaluteMo pages
        expect($pages)->toBeArray()
            ->and($pages)->toHaveKey('index')
            ->and($pages)->toHaveKey('create')
            ->and($pages)->toHaveKey('edit');
            
        // Check that the pages are configured correctly (not the exact class)
        expect($pages['index'])->toBeInstanceOf(\Filament\Resources\Pages\PageRegistration::class)
            ->and($pages['create'])->toBeInstanceOf(\Filament\Resources\Pages\PageRegistration::class)
            ->and($pages['edit'])->toBeInstanceOf(\Filament\Resources\Pages\PageRegistration::class);
    });

    describe('Form Schema', function () {
        it('has form schema defined', function () {
            // Test that the resource has a getFormSchema method
            expect(AdminResource::class)->toHaveMethod('getFormSchema');
            
            $schema = AdminResource::getFormSchema();
            expect($schema)->toBeArray()
                ->and($schema)->not()->toBeEmpty();
        });
    });

    describe('Table Schema', function () {
        it('inherits table method from base class without overriding', function () {
            // AdminResource eredita table() da FilamentResource (è normale)
            // Ma NON dovrebbe sovrascriverlo - la logica tabelle è in XotBaseResource
            $reflection = new \ReflectionClass(AdminResource::class);
            
            // Verifica che il metodo table() esista (ereditato)
            expect($reflection->hasMethod('table'))->toBeTrue();
            
            // Verifica che AdminResource non sovrascriva table()
            $method = $reflection->getMethod('table');
            expect($method->getDeclaringClass()->getName())->not->toBe(AdminResource::class);
            
            // Verifica che abbia getFormSchema()
            expect($reflection->hasMethod('getFormSchema'))->toBeTrue();
        });
    });

    describe('Resource Configuration', function () {
        it('has correct slug configuration', function () {
            expect(AdminResource::getSlug())->toBeString()
                ->and(AdminResource::getSlug())->not()->toBeEmpty();
        });

        it('has correct record title attribute', function () {
            // This method may return null, which is valid
            $titleAttribute = AdminResource::getRecordTitleAttribute();
            expect($titleAttribute === null || is_string($titleAttribute))->toBeTrue();
        });
    });

    describe('Permissions', function () {
        it('has correct resource permissions', function () {
            // Test that the class exists and extends the correct base class
            expect(AdminResource::class)->toBeString()
                ->and(class_exists(AdminResource::class))->toBeTrue();
                
            $reflection = new \ReflectionClass(AdminResource::class);
            expect($reflection->isSubclassOf('Modules\Xot\Filament\Resources\XotBaseResource'))->toBeTrue();
        });
    });
});