<?php

return [
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter template name',
            'help' => 'The identifying name of the template',
            'tooltip' => 'This field is required',
        ],
        'subject' => [
            'label' => 'Subject',
            'placeholder' => 'Enter notification subject',
            'help' => 'The subject that will appear in the notification',
            'tooltip' => 'This field is required',
        ],
        'body_text' => [
            'label' => 'Text',
            'placeholder' => 'Enter notification text',
            'help' => 'The text content of the notification',
            'tooltip' => 'This field is required',
        ],
        'body_html' => [
            'label' => 'HTML',
            'placeholder' => 'Enter notification HTML content',
            'help' => 'The HTML content of the notification',
            'tooltip' => 'This field is required',
        ],
        'preview_data' => [
            'label' => 'Preview Data',
            'placeholder' => 'Enter preview data',
            'help' => 'The data used to display the preview',
            'tooltip' => 'JSON format',
        ],
    ],
    'navigation' => [
        'label' => 'Notification Templates',
        'group' => 'Notifications',
        'icon' => 'heroicon-o-bell',
    ],
    'messages' => [
        'success' => [
            'created' => 'Template created successfully',
            'updated' => 'Template updated successfully',
            'deleted' => 'Template deleted successfully',
        ],
        'errors' => [
            'not_found' => 'Template not found',
            'unauthorized' => 'Unauthorized',
        ],
    ],
]; 