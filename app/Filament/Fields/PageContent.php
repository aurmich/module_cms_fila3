<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Fields;

use Filament\Forms\Components\Builder;
use Modules\UI\Actions\Block\GetAllBlocksAction;
use Modules\Xot\Datas\ComponentFileData;
use Webmozart\Assert\Assert;

/**
 * Classe per la gestione dei campi di contenuto pagina in Filament.
 */
class PageContent
{
    /**
     * Crea un nuovo campo builder per i contenuti della pagina.
     *
     * @param string $name Nome del campo
     * @param string $context Contesto di utilizzo (form, table, etc.)
     */
    public static function make(
        string $name,
        string $context = 'form',
    ): Builder {
        $blocks = app(GetAllBlocksAction::class)->execute();

        $blocks = $blocks->map(
            function ($block) use ($context) {
                Assert::isInstanceOf($block, ComponentFileData::class, '['.__LINE__.']['.__FILE__.']');
                $class = $block->class;

<<<<<<< HEAD
<<<<<<< HEAD
                return $class::make(context: $context);
=======
                return $class::make($context);
>>>>>>> feb96d7 (.)
=======
                return $class::make(context: $context);
>>>>>>> f1c9277 (.)
            }
        );

        /**
         * @var array<Builder\Block>
         */
        $blocks_array = $blocks->items();

        return Builder::make($name)
            ->blocks($blocks_array)
            ->collapsible();
    }
}
