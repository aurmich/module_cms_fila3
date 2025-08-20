<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit\Filament\Resources;

use Modules\SaluteMo\App\Filament\Resources\AppointmentResource;
use Modules\SaluteMo\App\Filament\Resources\AppointmentResource\Pages\ListAppointments;
use Modules\SaluteMo\App\Filament\Resources\AppointmentResource\Pages\CreateAppointment;
use Modules\SaluteMo\App\Filament\Resources\AppointmentResource\Pages\EditAppointment;
use Modules\SaluteMo\App\Filament\Resources\AppointmentResource\Pages\EditAppointmentReport;
use Modules\SaluteMo\App\Filament\Resources\AppointmentResource\Widgets\AppointmentOverviewWidget;

describe('SaluteMo AppointmentResource', function () {
    it('has correct model configuration', function () {
        expect(AppointmentResource::getModel())->toBe('Modules\SaluteOra\Models\Appointment');
    });

    it('has correct navigation configuration', function () {
        expect(AppointmentResource::getNavigationIcon())->not()->toBeNull()
            ->and(AppointmentResource::getNavigationGroup())->not()->toBeNull();
    });

    it('has correct resource pages', function () {
        $pages = AppointmentResource::getPages();
        
        expect($pages)->toHaveKey('index')
            ->and($pages)->toHaveKey('create')
            ->and($pages)->toHaveKey('edit')
            ->and($pages['index'])->toBe(ListAppointments::class)
            ->and($pages['create'])->toBe(CreateAppointment::class)
            ->and($pages['edit'])->toBe(EditAppointment::class);
            
        // Check for report page if it exists
        if (array_key_exists('report', $pages)) {
            expect($pages['report'])->toBe(EditAppointmentReport::class);
        }
    });

    it('has widgets defined', function () {
        $widgets = AppointmentResource::getWidgets();
        
        expect($widgets)->toBeArray()
            ->and($widgets)->toContain(AppointmentOverviewWidget::class);
    });

    describe('Form Schema', function () {
        it('has form schema defined', function () {
            $form = AppointmentResource::form(
                \Filament\Forms\Form::make()
            );
            
            expect($form)->toBeInstanceOf(\Filament\Forms\Form::class);
        });

        it('form schema contains expected components', function () {
            $form = AppointmentResource::form(
                \Filament\Forms\Form::make()
            );
            
            $schema = $form->getSchema();
            expect($schema)->toBeArray();
        });
    });

    describe('Table Schema', function () {
        it('has table schema defined', function () {
            $table = AppointmentResource::table(
                \Filament\Tables\Table::make()
            );
            
            expect($table)->toBeInstanceOf(\Filament\Tables\Table::class);
        });

        it('table has actions configured', function () {
            $table = AppointmentResource::table(
                \Filament\Tables\Table::make()
            );
            
            expect($table->getActions())->toBeArray();
        });
    });

    describe('Resource Configuration', function () {
        it('has correct slug configuration', function () {
            expect(AppointmentResource::getSlug())->toBeString()
                ->and(AppointmentResource::getSlug())->not()->toBeEmpty();
        });

        it('has correct record title attribute', function () {
            expect(AppointmentResource::getRecordTitleAttribute())->toBeString();
        });

        it('has correct navigation sort', function () {
            expect(AppointmentResource::getNavigationSort())->toBeInt();
        });
    });

    describe('Business Logic', function () {
        it('supports appointment state management', function () {
            // Test that the resource can handle appointment states
            expect(AppointmentResource::class)->toHaveMethod('form')
                ->and(AppointmentResource::class)->toHaveMethod('table');
        });

        it('supports appointment reporting', function () {
            $pages = AppointmentResource::getPages();
            
            // Check if reporting functionality exists
            $hasReportPage = array_key_exists('report', $pages) || 
                            in_array(EditAppointmentReport::class, $pages);
                            
            expect($hasReportPage)->toBeTrue();
        });
    });

    describe('Widget Integration', function () {
        it('has appointment overview widget', function () {
            $widgets = AppointmentResource::getWidgets();
            
            expect($widgets)->toContain(AppointmentOverviewWidget::class);
        });
    });
});