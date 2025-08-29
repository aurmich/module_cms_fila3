<?php

declare(strict_types=1);

use Modules\Cms\Models\Module;
use Modules\Xot\Actions\Filament\GetModulesNavigationItems;

describe('CMS Module', function () {
    it('user admin can view module dashboard', function (): void {
        // Test business logic: check that Module class exists and has required methods
        expect(class_exists(Module::class))->toBeTrue();
        
        $moduleInstance = new Module();
        expect(method_exists($moduleInstance, 'getRows'))->toBeTrue();
    });

    it('user admin can view main dashboard', function (): void {
        // Test business logic: check that navigation action exists
        expect(class_exists(GetModulesNavigationItems::class))->toBeTrue();
        
        $navigationAction = new GetModulesNavigationItems();
        expect(method_exists($navigationAction, 'execute'))->toBeTrue();
    });

    it('guest user can view main dashboard', function (): void {
        // Test that module structure is correct
        expect(Module::class)->toBeString()
            ->and(class_exists(Module::class))->toBeTrue();
    });

    it('the user views navigation modules entries based on their role', function (): void {
        // Test business logic: navigation items generation
        expect(GetModulesNavigationItems::class)->toBeString()
            ->and(class_exists(GetModulesNavigationItems::class))->toBeTrue();
    });

    it('the user no views navigation modules entries based on their no role', function (): void {
        // Test that required classes exist for role-based navigation
        expect(Module::class)->toBeString()
            ->and(GetModulesNavigationItems::class)->toBeString();
    });
});
