<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> bc33217 (.)
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;
<<<<<<< HEAD
=======
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Illuminate\View\Component;
use Modules\Xot\Datas\XotData;
use Modules\Cms\Datas\BlockData;
use Illuminate\Support\Facades\Blade;
use Modules\Cms\Models\Page as PageModel;
use Illuminate\Contracts\View\View as ViewContract;
>>>>>>> f492947 (.)
=======
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Cms\Datas\BlockData;
use Modules\Cms\Models\Page as PageModel;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;
>>>>>>> b48ea51 (.)
=======
>>>>>>> bc33217 (.)

class PageContent extends Component
{
    public string $slug;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> bc33217 (.)
    public array $blocks = [];

    public function __construct(string $slug)
    {
        $this->slug = $slug;
        Assert::isInstanceOf($page = PageModel::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]), PageModel::class, '['.__LINE__.']['.__FILE__.']');
        $blocks = $page->content_blocks;
        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            $blocks = $page->getTranslation('content_blocks', $primary_lang);
        }

        if (! is_array($blocks)) {
<<<<<<< HEAD
=======
    public array $blocks=[];
=======
    public array $blocks = [];
>>>>>>> b48ea51 (.)

    public function __construct(string $slug)
    {
        $this->slug = $slug;
        Assert::isInstanceOf($page = PageModel::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]), PageModel::class, '['.__LINE__.']['.__FILE__.']');
        $blocks = $page->content_blocks;
        if (! is_array($blocks)) {
            $primary_lang = XotData::make()->primary_lang;
            $blocks = $page->getTranslation('content_blocks', $primary_lang);
        }
<<<<<<< HEAD
        
        
        if(!is_array($blocks)){
>>>>>>> f492947 (.)
=======

        if (! is_array($blocks)) {
>>>>>>> b48ea51 (.)
=======
>>>>>>> bc33217 (.)
            $blocks = [];
        }
        $this->blocks = BlockData::collect($blocks);
    }
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> f492947 (.)
=======

>>>>>>> b48ea51 (.)
=======

>>>>>>> bc33217 (.)
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        /*
        $comps=Blade::getClassComponentAliases();
        $paths = Blade::getAnonymousComponentPaths();
        $filtered=Arr::where($comps,function ($value,$key){
            return Str::startsWith($key,'blocks.');
        });
        dddx([
            'filtered'=>$filtered
            ,'paths'=>$paths
        ]);
        */
        $view = 'cms::components.page-content';
        $view_params = [];
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
        // @phpstan-ignore-next-line
=======
>>>>>>> f492947 (.)
=======
        // @phpstan-ignore-next-line
>>>>>>> b48ea51 (.)
=======
        // @phpstan-ignore-next-line
>>>>>>> bc33217 (.)
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
