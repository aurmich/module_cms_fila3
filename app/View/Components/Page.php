<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b4e4106 (.)
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;
use Illuminate\View\Component;
use Modules\Xot\Datas\XotData;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
<<<<<<< HEAD
=======
>>>>>>> 9266864 (.)
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;
=======
use Illuminate\Contracts\View\View as ViewContract;
>>>>>>> b4e4106 (.)

class Page extends Component
{
    public string $side;
    public string $slug;
    public array $blocks = [];
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b4e4106 (.)
    public array $data = [];

    public function __construct(string $side, string $slug, ?string $type = null, array $data = [])
    {
        $this->data = $data;
<<<<<<< HEAD
=======

    public function __construct(string $side, string $slug, ?string $type = null)
    {
>>>>>>> 9266864 (.)
=======
>>>>>>> b4e4106 (.)
        $this->side = $side;
        if (null !== $type) {
            $slug = $type.'-'.$slug;
        }
        $this->slug = $slug;
        $field = $side.'_blocks';
        // Assert::isInstanceOf($page = PageModel::firstOrCreate(['slug' => $slug], ['title' => $slug, $field => []]), PageModel::class, '['.__LINE__.']['.__FILE__.']');
        $page = PageModel::firstWhere(['slug' => $slug]);
        if (null === $page) {
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b4e4106 (.)
        $blocks = Arr::map($blocks, function ($block) use ($data) {
            $block['data'] = array_merge($data,$block['data']);
            return $block;
        });
<<<<<<< HEAD
=======
>>>>>>> 9266864 (.)
=======
>>>>>>> b4e4106 (.)

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
