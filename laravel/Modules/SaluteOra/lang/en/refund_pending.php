<?php

declare(strict_types=1);

return [
    'fields' => [
        'message' => [
            'label' => 'Refund Message',
            'placeholder' => 'Refund request details',
            'help' => 'Message to document the refund request',
            'description' => 'Communication regarding the pending refund',
            'helper_text' => '',
        ],
        'invoice' => [
            'label' => 'Invoice',
            'placeholder' => 'Upload Invoice',
            'help' => 'Upload the fiscal document for the refund request',
            'description' => 'Invoice file to attach for the refund',
            'helper_text' => '',
        ],
    ],
]; 