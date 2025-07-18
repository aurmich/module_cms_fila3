<?php

declare(strict_types=1);

return [
    'adm_home' => '01',
    'enable_ads' => '1',
    'main_module' => 'SaluteOra',
    'primary_lang' => 'it',
    'pub_theme' => 'One',
    'search_action' => 'it/videos',
    'show_trans_key' => false,
    'disable_admin_dynamic_route' => true,
    'disable_frontend_dynamic_route' => false,
    'register_adm_theme' => false,
    'register_pub_theme' => true,
    'tenant_class' => 'Modules\SaluteOra\Models\Studio',
    'colors' => [
        'primary' => '#FF5F7E',
    ],
    'force_ssl' => env('FORCE_SSL', false),
];
