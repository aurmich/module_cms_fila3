<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseChartWidget;


class StatesChartWidget extends XotBaseChartWidget
{
    protected static ?string $heading = null;
    protected static ?int $sort = 4;
    protected static bool $isLazy = true;

    public string $stateClass;
    public string $model;

    public function getHeading(): ?string
    {
        return static::transClass($this->model, 'widgets.states_chart.heading');
    }

    protected function getData(): array
    {
        $label = static::transClass($this->model, 'widgets.states_chart.label');
        try {
            $states = $this->model::selectRaw('state, COUNT(*) as count')
                ->groupBy('state')
                ->get()
                ->keyBy('state');

            $colors = [
                'active' => 'rgb(34, 197, 94)',
                'pending' => 'rgb(234, 179, 8)',
                'integration_requested' => 'rgb(107, 114, 128)',
            ];

            return [
                'datasets' => [
                    [
                        'label' => $label,
                        'data' => $states->pluck('count')->toArray(),
                        'backgroundColor' => $states->keys()->map(fn($state) => $colors[$state] ?? 'rgb(156, 163, 175)')->toArray(),
                        'borderColor' => $states->keys()->map(fn($state) => $colors[$state] ?? 'rgb(156, 163, 175)')->toArray(),
                        'borderWidth' => 1,
                    ],
                ],
                'labels' => $states->keys()->map(fn($state) => static::transClass($this->model, 'states.'.$state.'.label'))->toArray(),
            ];
        } catch (\Exception $e) {
            // Fallback appropriato senza logging inutile
            return [
                'datasets' => [
                    [
                        'label' => $label,
                        'data' => [],
                        'backgroundColor' => [],
                        'borderColor' => [],
                        'borderWidth' => 1,
                    ],
                ],
                'labels' => [],
            ];
        }
    }

    protected function getType(): string
    {
        return 'bar';
    }
} 