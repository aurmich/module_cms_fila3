<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Fields;

use Filament\Forms\Components\Builder;

class LeftSidebarContent
{
<<<<<<< HEAD
    public static function make(string $name, string $_context = 'form'): Builder
    {
        return Builder::make($name)->blocks([])->collapsible();
=======
    public static function make(
        string $name,
        string $context = 'form',
    ): Builder {
        return Builder::make($name)
            ->blocks([
            ])
            ->collapsible();
>>>>>>> bc33217 (.)
    }
}
