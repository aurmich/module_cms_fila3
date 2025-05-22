<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Export;

// use Modules\Xot\Services\ArrayService;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Xot\Exports\ViewExport;
use Spatie\QueueableAction\QueueableAction;

/**
 * Classe per l'esportazione di viste in formato Excel.
 */
class ExportXlsByView
{
    use QueueableAction;

    /**
     * Esporta una vista in Excel.
     *
     * @param Collection<int|string, mixed> $rows La collezione da esportare
     * @param array<int, string> $fields Campi da includere nell'export
     * @param string $filename Nome del file Excel
     * @param string|null $transKey Chiave di traduzione per i campi
     *
     * @return BinaryFileResponse
     */
    public function execute(
        Collection $rows,
        array $fields,
        string $filename = 'test.xlsx',
        ?string $transKey = null,
    ): BinaryFileResponse {
        // Assicuriamo che $fields sia un array di stringhe
        $stringFields = array_map(function (string|int|float|bool $field): string {
            return strval($field);
        }, array_values($fields));

        $export = new ViewExport(
            rows: $rows,
            fields: $stringFields,
            transKey: $transKey
        );

        return Excel::download($export, $filename);
    }
}
