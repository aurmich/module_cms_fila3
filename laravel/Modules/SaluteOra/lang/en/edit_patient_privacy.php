<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Edit Patient Privacy',
        'icon' => 'heroicon-o-shield-check',
        'tooltip' => 'Manage patient privacy settings and consents',
        'description' => 'Edit privacy settings and consents for personal data processing',
    ],
    'actions' => [
        'save' => [
            'label' => 'Save Changes',
            'success' => 'Privacy settings saved successfully',
            'error' => 'Error saving privacy settings',
            'confirmation' => 'Do you confirm you want to save the privacy settings changes?',
        ],
        'cancel' => [
            'label' => 'Cancel',
            'confirmation' => 'Unsaved changes will be lost. Continue?',
        ],
        'reset' => [
            'label' => 'Reset Settings',
            'confirmation' => 'Reset privacy settings to default values?',
            'success' => 'Privacy settings reset successfully',
        ],
    ],
    'fields' => [
        'privacy_policy' => [
            'label' => 'Privacy Policy',
            'description' => 'Display of the complete privacy policy',
            'help' => 'The privacy policy contains details about personal data processing',
        ],
        'privacy_acceptance' => [
            'label' => 'Privacy Acceptance',
            'placeholder' => 'Select to accept the privacy policy',
            'help' => 'Acceptance of the privacy policy is mandatory by law',
            'validation' => [
                'required' => 'Acceptance of the privacy policy is mandatory',
                'accepted' => 'You must accept the privacy policy to continue',
            ],
        ],
        'newsletter_consent' => [
            'label' => 'Newsletter Consent',
            'placeholder' => 'Select to receive informational communications',
            'help' => 'Newsletter consent is optional and can be revoked at any time',
            'validation' => [
                'boolean' => 'Newsletter consent value must be true or false',
            ],
        ],
        'marketing_consent' => [
            'label' => 'Marketing Consent',
            'placeholder' => 'Select to receive commercial communications',
            'help' => 'Marketing consent is optional and can be revoked at any time',
            'validation' => [
                'boolean' => 'Marketing consent value must be true or false',
            ],
        ],
        'data_processing_consent' => [
            'label' => 'Data Processing Consent',
            'placeholder' => 'Select to consent to personal data processing',
            'help' => 'Consent to data processing is necessary for service provision',
            'validation' => [
                'required' => 'Consent to data processing is mandatory',
                'accepted' => 'You must accept data processing to continue',
            ],
        ],
        'third_party_sharing' => [
            'label' => 'Third Party Sharing',
            'placeholder' => 'Select to consent to sharing with third parties',
            'help' => 'Sharing with third parties occurs only for service purposes and with adequate safeguards',
            'validation' => [
                'boolean' => 'Third party sharing value must be true or false',
            ],
        ],
    ],
    'messages' => [
        'privacy_updated' => 'Privacy settings have been updated successfully',
        'consent_required' => 'Acceptance of the privacy policy is mandatory',
        'consent_revoked' => 'Consent has been revoked successfully',
        'consent_granted' => 'Consent has been granted successfully',
        'privacy_policy_viewed' => 'Privacy policy viewed',
        'data_processing_explained' => 'Data processing is carried out in compliance with GDPR',
    ],
    'sections' => [
        'privacy_settings' => [
            'label' => 'Privacy Settings',
            'description' => 'Manage privacy and data processing settings',
            'icon' => 'heroicon-o-shield-check',
        ],
        'consent_management' => [
            'label' => 'Consent Management',
            'description' => 'Manage consents for personal data processing',
            'icon' => 'heroicon-o-document-check',
        ],
        'communication_preferences' => [
            'label' => 'Communication Preferences',
            'description' => 'Configure preferences for informational and commercial communications',
            'icon' => 'heroicon-o-envelope',
        ],
    ],
    'validation' => [
        'privacy_acceptance_required' => 'Acceptance of the privacy policy is mandatory',
        'data_processing_required' => 'Consent to data processing is mandatory',
        'invalid_consent_value' => 'Consent value is not valid',
        'consent_already_granted' => 'Consent has already been granted',
        'consent_already_revoked' => 'Consent has already been revoked',
    ],
];
