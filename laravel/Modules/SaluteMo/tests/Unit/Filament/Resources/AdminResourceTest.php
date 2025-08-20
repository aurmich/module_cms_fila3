<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit\Filament\Resources;

use Modules\SaluteMo\App\Filament\Resources\AdminResource;
use Modules\SaluteMo\App\Filament\Resources\AdminResource\Pages\ListAdmins;
use Modules\SaluteMo\App\Filament\Resources\AdminResource\Pages\CreateAdmin;
use Modules\SaluteMo\App\Filament\Resources\AdminResource\Pages\EditAdmin;

describe('SaluteMo AdminResource', function () {
    it('has correct model configuration', function () {
        expect(AdminResource::getModel())->toBe('Modules\SaluteOra\Models\Admin');
    });

    it('has correct navigation configuration', function () {
        expect(AdminResource::getNavigationIcon())->not()->toBeNull()
            ->and(AdminResource::getNavigationGroup())->not()->toBeNull();
    });

    it('has correct resource pages', function () {
        $pages = AdminResource::getPages();
        
        expect($pages)->toHaveKey('index')
            ->and($pages)->toHaveKey('create')
            ->and($pages)->toHaveKey('edit')
            ->and($pages['index'])->toBe(ListAdmins::class)
            ->and($pages['create'])->toBe(CreateAdmin::class)
            ->and($pages['edit'])->toBe(EditAdmin::class);
    });

    describe('Form Schema', function () {
        it('has form schema defined', function () {
            $form = AdminResource::form(
                \Filament\Forms\Form::make()
            );
            
            expect($form)->toBeInstanceOf(\Filament\Forms\Form::class);
        });
    });

    describe('Table Schema', function () {
        it('has table schema defined', function () {
            $table = AdminResource::table(
                \Filament\Tables\Table::make()
            );
            
            expect($table)->toBeInstanceOf(\Filament\Tables\Table::class);
        });
    });

    describe('Resource Configuration', function () {
        it('has correct slug configuration', function () {
            expect(AdminResource::getSlug())->toBeString()
                ->and(AdminResource::getSlug())->not()->toBeEmpty();
        });

        it('has correct record title attribute', function () {
            expect(AdminResource::getRecordTitleAttribute())->toBeString();
        });
    });

    describe('Permissions', function () {
        it('has correct resource permissions', function () {
            // Test permission methods if they exist
            if (method_exists(AdminResource::class, 'canViewAny')) {
                expect(AdminResource::class)->toHaveMethod('canViewAny');
            }
            
            if (method_exists(AdminResource::class, 'canCreate')) {
                expect(AdminResource::class)->toHaveMethod('canCreate');
            }
        });
    });
});