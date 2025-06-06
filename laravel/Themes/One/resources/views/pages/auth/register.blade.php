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
        <div class="bg-white mb-16">
            <!-- Logo e intestazione -->
            <div class="text-center mb-16">
                <div class="flex justify-center mb-4">
                    <x-ui.logo class="h-12 text-blue-900" />
                </div>
                <h1 class="text-3xl font-light text-blue-900">Benvenuto in <span class="font-bold">SaluteOra</span></h1>
                <p class="text-gray-600 mt-2">Crea il tuo account per accedere a tutti i servizi</p>
            </div>

            <!-- Card contenente il form di registrazione -->
            <div class="w-full lg:flex justify-around">
                @foreach($types as $type => $class)
                <div class="flex justify-center">
                    <a class="w-full flex flex-col items-center mb-7" href="{{ route('register.type', ['type'=>$type]) }}" tag="a">
                        <div class="w-80 h-80 rounded-full bg-white shadow-2xl overflow-hidden">
                        <img src="/img/{{ $type }}.jpg" class="w-full h-full object-cover"/>
                        </div>
                    <x-filament::button class="text-2xl !text-white transition-colors rounded-lg flex justify-center items-center !bg-[#1A467F] hover:bg-[#0D9488] hover:cursor-pointer shadow-2xl mt-5 text-lg p-5">
                            {{ ucfirst($type) }}
                    </x-filament::button>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- <div class="bg-[#E6EBF7] text-center text-sm text-gray-500">
            <p>Hai bisogno di assistenza? <a href="#" class="text-blue-800 hover:underline">Contattaci</a></p>
        </div> -->
    </div>
    @endvolt
</x-layouts.app>
