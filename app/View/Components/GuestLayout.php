<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        $view = 'pub_theme::layouts.guest';
        $view_params = [];
<<<<<<< HEAD
<<<<<<< HEAD
        // @phpstan-ignore-next-line
=======
>>>>>>> f492947 (.)
=======
        // @phpstan-ignore-next-line
>>>>>>> b48ea51 (.)
        if (! view()->exists($view)) {
            throw new \Exception('view not found: '.$view);
        }

        return view($view, $view_params);
    }
}
