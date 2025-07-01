<?php

declare(strict_types=1);

namespace Modules\User\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AuthLogout extends Component
{
    public function mount(): void
    {
        Auth::logout();
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $view='livewire.auth.logout';
        if(!view()->exists($view)){
            throw new \Exception("View $view not found");
        }
        $view_params=[];
        return view($view,$view_params);
    }
}
