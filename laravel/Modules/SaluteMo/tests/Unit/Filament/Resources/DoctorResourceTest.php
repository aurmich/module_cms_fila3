<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Unit\Filament\Resources;

use Modules\SaluteMo\Filament\Resources\DoctorResource;
use Modules\SaluteMo\Filament\Resources\DoctorResource\Pages\ListDoctors;
use Modules\SaluteMo\Filament\Resources\DoctorResource\Pages\CreateDoctor;
use Modules\SaluteMo\Filament\Resources\DoctorResource\Pages\EditDoctor;
use Modules\SaluteMo\Filament\Resources\DoctorResource\Widgets\DoctorOverviewWidget;

describe('SaluteMo DoctorResource', function () {
    it('has correct model configuration', function () {
        // SaluteMo reuses SaluteOra Doctor model via base resource
        expect(DoctorResource::getModel())->toBe('Modules\SaluteOra\Models\Doctor');
    });

    it('has correct resource pages', function () {
        expect(DoctorResource::getPages())->toHaveKey('index');
        expect(DoctorResource::getPages())->toHaveKey('create');
        expect(DoctorResource::getPages())->toHaveKey('edit');
    });

    // Navigation and widgets are inherited/configured in base resource; avoid brittle assertions here
});
