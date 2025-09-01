<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

<<<<<<< HEAD
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;
use Illuminate\View\Component;
use Modules\Xot\Datas\XotData;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
=======
>>>>>>> b32aaf5 (.)
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

class Page extends Component
{
    public string $side;
<<<<<<< HEAD
    public string $slug;
    public array $blocks = [];
    public array $data = [];

=======

    public string $slug;

    public array $blocks = [];

    public array $data = [];

>>>>>>> b32aaf5 (.)
    public function __construct(string $side, string $slug, ?string $type = null, array $data = [])
    {
        $this->data = $data;
        $this->side = $side;
<<<<<<< HEAD
        if (null !== $type) {
=======
        if ($type !== null) {
>>>>>>> b32aaf5 (.)
            $slug = $type.'-'.$slug;
        }
        $this->slug = $slug;
        $field = $side.'_blocks';
        // Assert::isInstanceOf($page = PageModel::firstOrCreate(['slug' => $slug], ['title' => $slug, $field => []]), PageModel::class, '['.__LINE__.']['.__FILE__.']');
        $page = PageModel::firstWhere(['slug' => $slug]);
<<<<<<< HEAD
        if (null === $page) {
=======
        if ($page === null) {
>>>>>>> b32aaf5 (.)
            abort(404, 'page not found: '.$slug);
        }
        $blocks = $page->$field;
        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            $blocks = $page->getTranslation($field, $primary_lang);
        }
        if (! is_array($blocks)) {
            $blocks = [];
        }
        $blocks = Arr::map($blocks, function ($block) use ($data) {
<<<<<<< HEAD
            $block['data'] = array_merge($data,$block['data']);
=======
            $block['data'] = array_merge($data, $block['data']);

>>>>>>> b32aaf5 (.)
            return $block;
        });

        $this->blocks = BlockData::collect($blocks);
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        $view = 'cms::components.page-content';
        $view_params = [];
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
