<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Resources;

use Modules\SaluteOra\Filament\Resources\ReportResource as BaseReportResource;
use Modules\SaluteOra\Models\Report;

/**
 * Risorsa Filament per la gestione dei referti medici.
 *
 * Estende XotBaseResource per ereditare le funzionalità di base di Filament
 * e personalizzare la gestione dei referti secondo le esigenze specifiche del modulo SaluteMo.
 *
 * @method static string getModelLabel()
 * @method static string getPluralModelLabel()
 * @method static string getNavigationLabel()
 */
class ReportResource extends BaseReportResource
{
    /**
     * @var class-string<Report>
     */
    protected static ?string $model = Report::class;
}
