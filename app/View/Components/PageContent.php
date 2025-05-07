<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Illuminate\View\Component;
<<<<<<< HEAD
<<<<<<< HEAD
use Modules\Cms\Datas\BlockData;
=======
>>>>>>> feb96d7 (.)
=======
use Modules\Cms\Datas\BlockData;
>>>>>>> f1c9277 (.)
use Illuminate\Support\Facades\Blade;
use Modules\Cms\Models\Page as PageModel;
use Illuminate\Contracts\View\View as ViewContract;

/**
 * Componente per la visualizzazione del contenuto di una pagina.
 */
class PageContent extends Component
{
    /**
     * Lo slug della pagina.
     *
     * @var string
     */
    public string $slug;

    /**
     * I blocchi di contenuto della pagina.
     *
     * @var array
     */
    public array $blocks = [];

    /**
     * Costruttore del componente.
     *
     * @param string $slug Lo slug della pagina
     */
    public function __construct(string $slug)
    {
        $this->slug = $slug;
        Assert::isInstanceOf(
            $page = PageModel::firstOrCreate(
                ['slug' => $slug],
                ['title' => $slug, 'content_blocks' => []]
            ),
            PageModel::class,
            '['.__LINE__.']['.__FILE__.']'
        );
        $blocks = $page->content_blocks;
        if (!is_array($blocks)) {
            $blocks = [];
        }
<<<<<<< HEAD
<<<<<<< HEAD
        $this->blocks = BlockData::collect($blocks);
=======
        $this->blocks = $blocks;
>>>>>>> feb96d7 (.)
=======
        $this->blocks = BlockData::collect($blocks);
>>>>>>> f1c9277 (.)
    }

    /**
     * Renderizza il componente.
     *
     * @return ViewContract
     * @throws \Exception Se la vista non esiste
     */
    public function render(): ViewContract
    {
        $view = 'cms::components.page-content';
        $view_params = [];
        if (!view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
