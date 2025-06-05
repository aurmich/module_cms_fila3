<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * Nome del modulo - OBBLIGATORIO per XotBaseServiceProvider
     * Deve corrispondere esattamente al nome della cartella del modulo
     */
    public string $name = 'SaluteOra';

    protected string $moduleNamespace = 'Modules\SaluteOra\Http\Controllers';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;


}
