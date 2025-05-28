<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Filament\Resources\StudioResource\Pages;

use Filament\Infolists\Components\Component;
use Modules\SaluteOra\Filament\Resources\StudioResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewStudio extends XotBaseViewRecord
{
    protected static string $resource = StudioResource::class;

    /**
     * Implementazione del metodo astratto dalla classe base.
     * Delega alla risorsa per mantenere la coerenza e seguire il principio DRY.
     *
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return StudioResource::getInfolistSchema();
    }
}