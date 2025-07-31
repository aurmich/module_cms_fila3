<?php
declare(strict_types=1);
use Modules\Patient\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Volt\Component;
use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('register');

new class extends Component
{
    public array $types = [];

    public function mount(): void
    {
        $this->types = (new User())->getChildTypes();
    }
};
?>

<x-layouts.app>
    @volt('register')
                <h1 class="text-3xl font-light text-blue-900">{!! __('pub_theme::auth.register.welcome_message') !!}</h1>
                <p class="text-gray-600 mt-2">{{ __('pub_theme::auth.register.description') }}</p> (.)
            </div>

            <!-- Card contenente il form di registrazione -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                @foreach($types as $type => $class)
                    <x-filament::button size="sm" href="{{ route('register.type', ['type'=>$type]) }}" tag="a">
                        {{ ucfirst($type) }}
                    </x-filament::button>
                @endforeach
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Hai bisogno di assistenza? <a href="#" class="text-blue-800 hover:underline">Contattaci</a></p>
        </div>
    </div>
    @endvolt
</x-layouts.app>
