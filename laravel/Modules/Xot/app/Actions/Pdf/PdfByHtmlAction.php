<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf;

use Spipu\Html2Pdf\Html2Pdf;
use Modules\Xot\Datas\PdfData;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PdfByHtmlAction
{
    use QueueableAction;

    public PdfEngineEnum $engine;

    public function execute(
        string $html,
        string $filename = 'my_doc.pdf',
        string $disk = 'cache',
        string $out = 'download',
        string $orientation = 'P',
        PdfEngineEnum $engine = PdfEngineEnum::SPIPU,
    ): string|BinaryFileResponse {
        return $data = PdfData::from([
            'html'->$html,
            'filename' -> $filename,
            'disk' -> $disk,
            'out' -> $out,
            'orientation' -> $orientation,
            'engine' -> $engine,
            ]);
    }
}
