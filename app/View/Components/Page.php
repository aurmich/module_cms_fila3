<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

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

class Page extends Component
{
    public string $side;
    public string $slug;
    public array $blocks=[];

    public function __construct(string $side,string $slug,null|string $type=null){
        $this->side=$side;
        if($type!==null){
            $slug=$type.'-'.$slug;
        }
        $this->slug = $slug;
        $field=$side.'_blocks';
        //Assert::isInstanceOf($page = PageModel::firstOrCreate(['slug' => $slug], ['title' => $slug, $field => []]), PageModel::class, '['.__LINE__.']['.__FILE__.']');
        $page=PageModel::firstOrCreate(['slug' => $slug]);
        //$page=PageModel::firstWhere(['slug' => $slug]);
        if($page===null){
            abort(404,'page not found: '.$slug);
        }
        $blocks = $page->$field ;
        if(!is_array($blocks)){
            $primary_lang=XotData::make()->primary_lang;
            $blocks = $page->getTranslation($field,$primary_lang);
        }
        if(!is_array($blocks)){
            $blocks = [];
        }
               
        
        $this->blocks = BlockData::collect($blocks);
    }
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {

        $view = 'cms::components.page-content';
        $view_params = [];
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
