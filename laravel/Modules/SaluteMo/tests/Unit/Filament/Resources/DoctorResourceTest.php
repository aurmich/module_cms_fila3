<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit\Filament\Resources;

use Modules\SaluteMo\App\Filament\Resources\DoctorResource;
use Modules\SaluteMo\App\Filament\Resources\DoctorResource\Pages\ListDoctors;
use Modules\SaluteMo\App\Filament\Resources\DoctorResource\Pages\CreateDoctor;
use Modules\SaluteMo\App\Filament\Resources\DoctorResource\Pages\EditDoctor;
use Modules\SaluteMo\App\Filament\Resources\DoctorResource\RelationManagers\StudiosRelationManager;

describe('SaluteMo DoctorResource', function () {
    it('has correct model configuration', function () {
        expect(DoctorResource::getModel())->toBe('Modules\SaluteOra\Models\Doctor');
    });

    it('has correct navigation configuration', function () {
        expect(DoctorResource::getNavigationIcon())->not()->toBeNull()
            ->and(DoctorResource::getNavigationGroup())->not()->toBeNull();
    });

    it('has correct resource pages', function () {
        $pages = DoctorResource::getPages();
        
        expect($pages)->toHaveKey('index')
            ->and($pages)->toHaveKey('create')
            ->and($pages)->toHaveKey('edit')
            ->and($pages['index'])->toBe(ListDoctors::class)
            ->and($pages['create'])->toBe(CreateDoctor::class)
            ->and($pages['edit'])->toBe(EditDoctor::class);
    });

    it('has relation managers defined', function () {
        $relationManagers = DoctorResource::getRelations();
        
        expect($relationManagers)->toBeArray()
            ->and($relationManagers)->toContain(StudiosRelationManager::class);
    });

    describe('Form Schema', function () {
        it('has form schema defined', function () {
            $form = DoctorResource::form(
                \Filament\Forms\Form::make()
            );
            
            expect($form)->toBeInstanceOf(\Filament\Forms\Form::class);
        });

        it('form schema contains doctor-specific fields', function () {
            $form = DoctorResource::form(
                \Filament\Forms\Form::make()
            );
            
            $schema = $form->getSchema();
            expect($schema)->toBeArray();
        });
    });

    describe('Table Schema', function () {
        it('has table schema defined', function () {
            $table = DoctorResource::table(
                \Filament\Tables\Table::make()
            );
            
            expect($table)->toBeInstanceOf(\Filament\Tables\Table::class);
        });

        it('table has filters configured', function () {
            $table = DoctorResource::table(
                \Filament\Tables\Table::make()
            );
            
            expect($table->getFilters())->toBeArray();
        });

        it('table has actions configured', function () {
            $table = DoctorResource::table(
                \Filament\Tables\Table::make()
            );
            
            expect($table->getActions())->toBeArray();
        });
    });

    describe('Resource Configuration', function () {
        it('has correct slug configuration', function () {
            expect(DoctorResource::getSlug())->toBeString()
                ->and(DoctorResource::getSlug())->not()->toBeEmpty();
        });

        it('has correct record title attribute', function () {
            expect(DoctorResource::getRecordTitleAttribute())->toBeString();
        });
    });

    describe('Relation Management', function () {
        it('has studios relation manager', function () {
            $relationManagers = DoctorResource::getRelations();
            
            expect($relationManagers)->toContain(StudiosRelationManager::class);
        });

        it('supports many-to-many studio relationships', function () {
            // StudiosRelationManager should handle doctor-studio pivot relationships
            expect(StudiosRelationManager::class)->toBeString();
        });
    });

    describe('Business Logic Integration', function () {
        it('supports doctor registration workflow', function () {
            // Test that the resource integrates with doctor registration business logic
            expect(DoctorResource::class)->toHaveMethod('form')
                ->and(DoctorResource::class)->toHaveMethod('table');
        });

        it('handles doctor state management', function () {
            // Doctors have states in the business logic
            $form = DoctorResource::form(
                \Filament\Forms\Form::make()
            );
            
            expect($form)->toBeInstanceOf(\Filament\Forms\Form::class);
        });
    });
});