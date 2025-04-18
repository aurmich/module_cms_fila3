<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Blade;
use Modules\Cms\Models\Page as PageModel;
use Illuminate\Contracts\View\View as ViewContract;

class PageContent extends Component
{
    public string $slug;
    public array $blocks=[];

    public function __construct(string $slug){
        $this->slug = $slug;
        Assert::isInstanceOf($page = PageModel::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]), PageModel::class, '['.__LINE__.']['.__FILE__.']');
        $blocks = $page->content_blocks ;
        if(!is_array($blocks)){
            $blocks = [];
        }
        $this->blocks = $blocks;
    }
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
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
