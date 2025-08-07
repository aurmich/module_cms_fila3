<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\FormBuilder\Models\Form;
use Modules\FormBuilder\Models\FormField;
use Modules\FormBuilder\Models\FormTemplate;
use Modules\FormBuilder\Models\FormSubmission;
use Modules\FormBuilder\Enums\FormStatusEnum;

/**
 * Widget per le statistiche generali dei form.
 * 
 * Mostra:
 * - Numero totale di form
 * - Form attivi
 * - Template disponibili
 * - Submission totali
 * 
 * @see \Modules\FormBuilder\docs\filament\widgets\form-stats-widget.md Documentazione
 */
class FormStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Form Totali', Form::count())
                ->description('Tutti i form nel sistema')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Form Attivi', Form::where('is_active', true)->count())
                ->description('Form attualmente attivi')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart([17, 16, 14, 15, 14, 13, 12]),

            Stat::make('Template Disponibili', FormTemplate::count())
                ->description('Template riutilizzabili')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('info')
                ->chart([3, 4, 3, 5, 4, 6, 5]),

            Stat::make('Submission Totali', FormSubmission::count())
                ->description('Invii form ricevuti')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning')
                ->chart([15, 4, 10, 2, 12, 4, 16]),
        ];
    }
}