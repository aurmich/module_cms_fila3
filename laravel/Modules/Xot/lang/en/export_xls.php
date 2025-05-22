<?php

declare(strict_types=1);

return [
    'actions' => [
        'export_xls' => [
            'label' => 'Export XLS',
            'title' => 'Export to Excel',
            'description' => 'Export data to Excel format',
        ],
    ],
    'headers' => [
        'sheet_name' => 'Exported Data',
        'generated_at' => 'Generated at',
        'total_records' => 'Total records',
    ],
    'messages' => [
        'success' => 'Export completed successfully',
        'error' => 'An error occurred during export',
        'no_data' => 'No data to export',
        'processing' => 'Processing...',
    ],
]; 