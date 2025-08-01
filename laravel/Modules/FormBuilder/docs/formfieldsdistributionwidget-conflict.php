<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\FormBuilder\Models\FormField;
use Modules\FormBuilder\Enums\FieldTypeEnum;

/**
 * Widget per la distribuzione dei tipi di campo nei form.
 * 
 * Mostra:
 * - Distribuzione tipi campo
 * - Campi più utilizzati
 * - Analisi utilizzo
 * 
 * @see \Modules\FormBuilder\docs\filament\widgets\form-fields-distribution-widget.md Documentazione
 */
class FormFieldsDistributionWidget extends ChartWidget
{
    protected static ?string $heading = 'Distribuzione Campi';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        if (!class_exists(FieldTypeEnum::class) || !class_exists(FormField::class)) {
            return [
                'datasets' => [['label' => 'Campi per Tipo', 'data' => [], 'backgroundColor' => []]],
                'labels' => [],
            ];
        }
        
        $cases = FieldTypeEnum::cases();
        /** @phpstan-ignore argument.templateType */
        $fieldTypes = collect($cases)->map(function ($type) {
            return [
                'type' => $type->getLabel(),
                'count' => FormField::where('type', '=', $type->value)->count(),
            ];
        })->filter(fn ($item) => $item['count'] > 0);

        return [
            'datasets' => [
                [
                    'label' => 'Campi per Tipo',
                    'data' => $fieldTypes->pluck('count')->toArray(),
                    'backgroundColor' => [
                        '#3B82F6', '#10B981', '#F59E0B', '#EF4444',
                        '#8B5CF6', '#06B6D4', '#84CC16', '#F97316',
                    ],
                ],
            ],
            'labels' => $fieldTypes->pluck('type')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}