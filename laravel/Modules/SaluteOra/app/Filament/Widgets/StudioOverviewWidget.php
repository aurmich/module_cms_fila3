<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Widgets;

use Filament\Widgets\Widget;
use Modules\SaluteOra\Models\Studio;
use Illuminate\Support\Facades\DB;

class StudioOverviewWidget extends Widget
{
    protected static string $view = 'saluteora::filament.widgets.studio-overview';

    protected function getViewData(): array
    {
        $stats = [
            'total' => Studio::count(),
            'active' => Studio::where('active', true)->count(),
            'inactive' => Studio::where('active', false)->count(),
            'cities' => Studio::distinct('city')->count('city'),
            'doctors' => Studio::withCount('doctors')->sum('doctors_count'),
            'appointments' => Studio::withCount(['appointments' => function ($query) {
                $query->whereMonth('start_time', now()->month)
                    ->whereYear('start_time', now()->year);
            }])->sum('appointments_count'),
        ];

        $citiesData = Studio::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->orderByDesc('total')
            ->limit(8)
            ->pluck('total', 'city')
            ->toArray();

        return [
            'stats' => $stats,
            'citiesData' => $citiesData,
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->can('view_any_studio');
    }
}