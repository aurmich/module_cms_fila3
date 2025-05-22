<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Providers;

use Filament\Forms\Components\Component;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\SaluteOra\Filament\Widgets\SaluteOraRegistrationWizard;
use Modules\SaluteOra\Models\SaluteOra;
use Modules\SaluteOra\Models\Document;
use Modules\SaluteOra\Models\Anamnesis;
use Modules\SaluteOra\Filament\Resources\SaluteOraResource;
use Modules\Xot\Providers\XotBaseServiceProvider;

class SaluteOraServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'SaluteOra';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();

    }
}
