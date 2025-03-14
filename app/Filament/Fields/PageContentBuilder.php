<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Fields;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\Xot\Datas\ComponentFileData;
use Webmozart\Assert\Assert;

class PageContentBuilder
{
    public static function make(
        string $name,
        string $context = 'form',
    ): Builder {
        $blocks = app(GetAllBlocksAction::class)->execute();

        $blocks = $blocks->map(
            function ($block) use ($context) {
                Assert::isInstanceOf($block, ComponentFileData::class, '['.__LINE__.']['.__FILE__.']');
                $class = $block->class;

                return $class::make($context);
            }
        );

        /**
         * @var array<Block>
         */
        $blocks_array = $blocks->items();

        return Builder::make($name)
            ->blocks($blocks_array)
            ->collapsible();
    }
}
