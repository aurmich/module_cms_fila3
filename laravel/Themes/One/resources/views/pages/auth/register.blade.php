<?php
declare(strict_types=1);
use Modules\SaluteOra\Models\User;
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
    <div class="register-container">
        <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12">
            <!-- Logo e intestazione -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <x-ui.logo class="h-12 text-blue-900" />
                </div>
                <h1 class="text-3xl font-light text-blue-900">Benvenuto in <span class="font-bold">SaluteOra</span></h1>
                <p class="text-gray-600 mt-2">Crea il tuo account per accedere a tutti i servizi4</p>
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
