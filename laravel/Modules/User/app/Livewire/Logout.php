<?php
declare(strict_types=1);

namespace Modules\User\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public $processing = false;

    public function logout()
    {
        $this->processing = true;

        try {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('home');
        } catch (\Exception $e) {
            $this->processing = false;
            session()->flash('error', __('Errore durante il logout. Riprova.'));
        }
    }

    public function render()
    {
        return view('user::livewire.logout');
    }
}
