<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Modules\FormBuilder\Models\FormSubmission;

/**
 * Widget per il grafico delle submission dei form.
 * 
 * Mostra:
 * - Trend submission nel tempo
 * - Confronto periodi
 * - Previsioni future
 * 
 * @see \Modules\FormBuilder\docs\filament\widgets\form-submissions-chart-widget.md Documentazione
 */
class FormSubmissionsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Submission Form';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(function ($day) {
            $date = Carbon::now()->subDays($day);
            
            return [
                'date' => $date->format('M d'),
                'submissions' => FormSubmission::where('submitted_at', '>=', $date->startOfDay())->where('submitted_at', '<=', $date->endOfDay())->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Submission',
                    'data' => $days->pluck('submissions')->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => '#10B981',
                    'fill' => false,
                ],
            ],
            'labels' => $days->pluck('date')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}