<?php

declare(strict_types=1);

return [
    'label' => 'Refund Completed',
    'description' => 'The refund has been processed and completed',
    'tooltip' => 'The refund has been processed successfully',
    'color' => 'success',
    'bg_color' => '#10b981',
    'icon' => 'heroicon-o-check-circle',
    'modal_heading' => 'Refund Completed',
    'modal_description' => 'The refund has been processed successfully. The amount has been credited according to the specified methods.',
    
    'actions' => [
        'view_receipt' => [
            'label' => 'View Receipt',
            'tooltip' => 'View refund receipt',
        ],
        'download_receipt' => [
            'label' => 'Download Receipt',
            'tooltip' => 'Download receipt in PDF format',
        ],
        'send_confirmation' => [
            'label' => 'Send Confirmation',
            'confirmation' => 'Are you sure you want to send the refund confirmation?',
            'success' => 'Confirmation sent successfully',
            'error' => 'Error sending confirmation',
        ],
        'archive' => [
            'label' => 'Archive',
            'confirmation' => 'Are you sure you want to archive this refund?',
            'success' => 'Refund archived successfully',
            'error' => 'Error during archiving',
        ],
    ],
    
    'modal' => [
        'heading' => 'Refund Completed',
        'description' => 'The refund has been processed successfully. The amount has been credited according to the specified methods.',
        'confirm' => 'Confirm',
        'cancel' => 'Cancel',
    ],
    
    'messages' => [
        'processing_completed' => 'Processing completed successfully',
        'amount_credited' => 'Amount credited correctly',
        'confirmation_sent' => 'Confirmation sent to beneficiary',
        'receipt_available' => 'Receipt available for download',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Completion Message',
            'placeholder' => 'Enter a confirmation message',
            'helper_text' => '',
            'description' => 'Informational message about refund completion',
        ],
        'completion_date' => [
            'label' => 'Completion Date',
            'placeholder' => 'Completion date',
            'helper_text' => '',
            'description' => 'Date when the refund was completed',
        ],
        'refund_amount' => [
            'label' => 'Refunded Amount',
            'placeholder' => 'Refund amount',
            'helper_text' => '',
            'description' => 'Total amount of the processed refund',
        ],
        'payment_method' => [
            'label' => 'Payment Method',
            'placeholder' => 'Method used for refund',
            'helper_text' => '',
            'description' => 'Method used for refund credit',
        ],
        'transaction_id' => [
            'label' => 'Transaction ID',
            'placeholder' => 'Transaction identifier',
            'helper_text' => '',
            'description' => 'Unique identifier code for the refund transaction',
        ],
    ],
]; 