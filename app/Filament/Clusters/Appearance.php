<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Clusters;

use Filament\Clusters\Cluster;

class Appearance extends Cluster
{
    protected static null|string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static null|string $navigationGroup = 'Settings';
}
