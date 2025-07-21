<?php

declare(strict_types=1);

return [
    'status' => [
        'pending' => [
            'label' => 'The report is waiting to be generated.',
            'tooltip' => 'The report has not been generated yet',
            'helper_text' => '',
        ],
        'processing' => [
            'label' => 'The report is being processed.',
            'tooltip' => 'The report is being generated',
            'helper_text' => '',
        ],
        'error' => [
            'label' => 'An error occurred while generating the report.',
            'tooltip' => 'Error during report generation',
            'helper_text' => '',
        ],
        'empty' => [
            'label' => 'No data available for this report.',
            'tooltip' => 'No data available',
            'helper_text' => '',
        ],
    ],
    'group' => [
        'label' => 'Group',
        'tooltip' => 'Report data category',
        'helper_text' => '',
    ],
    'json_parse_error' => [
        'label' => 'Error parsing JSON data',
        'tooltip' => 'Error reading JSON data',
        'helper_text' => '',
    ],
]; 