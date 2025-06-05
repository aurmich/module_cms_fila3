<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, rules};

middleware(['guest']);
name('login');

state([
    'email' => '',
    'password' => '',
    'remember' => false,
]);

rules([
    'email' => ['required', 'email'],
    'password' => ['required'],
]);

$authenticate = function() {
    $this->validate();

    if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
        $this->addError('email', __('auth.failed'));
        return;
    }

    // Laravel gestirà automaticamente l'evento Login
    return redirect()->intended(route('home'));
};

?>

<x-layouts.main>
    <div class="flex flex-col items-stretch justify-center w-full min-h-screen py-10 sm:items-center">
        <div class="mx-auto w-full max-w-md">
            <a href="{{ route('home') }}" class="block text-center">
                <x-filament::icon name="heroicon-o-home" class="w-auto h-10 mx-auto text-primary-600" />
            </a>

            <h2 class="mt-5 text-2xl font-extrabold leading-9 text-center text-gray-900 dark:text-white">
                {{ __('auth.login.title') }}
            </h2>
            <div class="text-sm leading-5 text-center text-gray-600 dark:text-gray-400 space-x-0.5">
                <span>{{ __('auth.login.or') }}</span>
                <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-500 font-medium">
                    {{ __('auth.login.create_account') }}
                </a>
            </div>
        </div>

        <div class="mt-8 mx-auto w-full max-w-md">
            <div class="px-10 py-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                @volt('auth.login')
                <form wire:submit="authenticate" class="space-y-6">
                    <x-ui.input
                        label="{{ __('auth.login.email') }}"
                        type="email"
                        id="email"
                        name="email"
                        wire:model="email"
                        required
                        autocomplete="email"
                    />

                    <x-ui.input
                        label="{{ __('auth.login.password') }}"
                        type="password"
                        id="password"
                        name="password"
                        wire:model="password"
                        required
                        autocomplete="current-password"
                    />

                    <div class="flex items-center justify-between mt-6 text-sm leading-5">
                        <x-ui.checkbox
                            label="{{ __('auth.login.remember_me') }}"
                            id="remember"
                            name="remember"
                            wire:model="remember"
                        />

                        <a href="{{ route('password.request') }}" class="text-primary-600 hover:text-primary-500 font-medium">
                            {{ __('auth.login.forgot_password') }}
                        </a>
                    </div>

                    <x-ui.button type="primary" rounded="md" submit="true" class="w-full">
                        {{ __('auth.login.submit') }}
                    </x-ui.button>
                </form>
                @endvolt
            </div>
        </div>
    </div>
</x-layouts.main>
