<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;
use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Actions\GetViewAction;
use Illuminate\Contracts\View\View as ViewContract;

class Metatags extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): ViewContract
    {
        $metatag=MetatagData::make();
        $view=app(GetViewAction::class)->execute();
        
        $view_params = [
            'meta'=>$metatag,
        ];
        // @phpstan-ignore-next-line
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
        
    }
}
