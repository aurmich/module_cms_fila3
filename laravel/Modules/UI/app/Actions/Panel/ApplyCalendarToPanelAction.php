<?php

declare(strict_types=1);

namespace Modules\UI\Actions\Panel;

use Filament\Panel;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Datas\MetatagData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\QueueableAction\QueueableAction;
use Modules\User\Filament\Pages\Tenancy\RegisterTenant;
use Modules\User\Filament\Pages\Tenancy\EditTenantProfile;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class ApplyCalendarToPanelAction
{
    use QueueableAction;

    public function execute(Panel &$panel): Panel
    {
        $calendarPlugin = FilamentFullCalendarPlugin::make()
        ->selectable(true)
        ->editable(true)
        ->timezone(config('fullcalendar.localization.timezone', 'Europe/Rome'))
        ->locale(config('fullcalendar.localization.locale', 'it'))
        ->plugins([
            'dayGrid',
            'timeGrid',
            'list',
            'interaction',
            'multiMonth',
            //'scrollGrid',//premium
        ]);

        // Aggiungi licenza scheduler solo se presente e valida
        $licenseKey = config('fullcalendar.scheduler_license_key');
        if ($licenseKey && is_string($licenseKey) && !empty(trim($licenseKey))) {
            $calendarPlugin->schedulerLicenseKey($licenseKey);
        }

        $panel->plugin($calendarPlugin);

        return $panel;
    }
}
