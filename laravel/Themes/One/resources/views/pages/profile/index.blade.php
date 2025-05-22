<?php
declare(strict_types=1);
use function Livewire\Volt\{state, mount};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

state([
    'user' => null,
    'name' => '',
    'email' => '',
    'current_password' => '',
    'new_password' => '',
    'new_password_confirmation' => '',
]);

mount(function () {
    $this->user = Auth::user();
    $this->name = $this->user->name;
    $this->email = $this->user->email;
});

$updateProfile = function () {
    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
    ]);

    $this->user->update($validated);

    $this->dispatch('profile-updated');
};

$updatePassword = function () {
    $validated = $this->validate([
        'current_password' => ['required', 'current_password'],
        'new_password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $this->user->update([
        'password' => Hash::make($validated['new_password']),
    ]);

    $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    $this->dispatch('password-updated');
};

?>

@volt
<x-layouts.app>
    <x-slot name="title">
        {{ __('Profile') }}
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-filament::card>
                <div class="p-6">
                    <h1 class="text-2xl font-semibold mb-4">{{ __('profile.title') }}</h1>

                    <div class="space-y-6">
                        <!-- Informazioni personali -->
                        <div>
                            <h2 class="text-lg font-medium mb-2">{{ __('profile.personal_info') }}</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('profile.name') }}</p>
                                    <p class="font-medium">{{ auth()->user()->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('profile.email') }}</p>
                                    <p class="font-medium">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Azioni -->
                        <div class="flex space-x-4">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                {{ __('profile.edit') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                    {{ __('auth.logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </x-filament::card>
        </div>
    </div>
</x-layouts.app>
@endvolt
