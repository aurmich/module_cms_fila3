<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf;

use Spipu\Html2Pdf\Html2Pdf;
use Modules\Xot\Datas\PdfData;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StreamDownloadPdfAction
{
    use QueueableAction;

    public PdfEngineEnum $engine;

    /**
     * Genera un PDF dall'HTML fornito.
     *
     * @param string $html Contenuto HTML da convertire
     * @param string $filename Nome del file PDF
     * @param string $disk Disco di storage
     * @param string $out Tipo di output (download, path, etc.)
     * @param string $orientation Orientamento (P=Portrait, L=Landscape)
     * @param PdfEngineEnum $engine Engine da utilizzare
     * @return string|BinaryFileResponse
     */
    public function execute(
        ?string $html=null,
        ?string $view=null,
        ?array $data=null,
        string $filename = 'my_doc.pdf',
        
    ){

        if($html==null && $view!=null){
            $html = view($view, $data)->render();
        }

        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [10, 10, 10, 10]);
        $html2pdf->writeHTML($html);
        
        // Genera e scarica il PDF
        return response()->streamDownload(
            function () use ($html2pdf) {
                $html2pdf->output();
            },
            'report-' . $filename
        );
    }
}
