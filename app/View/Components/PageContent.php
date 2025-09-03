<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

<<<<<<< HEAD
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

class PageContent extends Component
{
    public string $slug;
<<<<<<< HEAD
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
=======
    public array $blocks=[];

    public function __construct(string $slug){
        $this->slug = $slug;
        Assert::isInstanceOf($page = PageModel::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]), PageModel::class, '['.__LINE__.']['.__FILE__.']');
        $blocks = $page->content_blocks ;
        if(!is_array($blocks)){
            $primary_lang=XotData::make()->primary_lang;
            $blocks = $page->getTranslation('content_blocks',$primary_lang);
        }
        
        
        if(!is_array($blocks)){
>>>>>>> f492947 (.)
            $blocks = [];
        }
        $this->blocks = BlockData::collect($blocks);
    }
<<<<<<< HEAD

=======
>>>>>>> f492947 (.)
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
        // @phpstan-ignore-next-line
=======
>>>>>>> f492947 (.)
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
