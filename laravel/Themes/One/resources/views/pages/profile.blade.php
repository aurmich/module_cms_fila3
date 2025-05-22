<?php
declare(strict_types=1);
use function Livewire\Volt\{state, mount};
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

<x-layouts.main>
    <x-slot name="title">
        {{ __('Profile') }}
    </x-slot>
    @volt('profile')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Profile Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Update your account\'s profile information and email address.') }}
                            </p>
                        </header>

                        <form wire:submit="updateProfile" class="mt-6 space-y-6">
                            <div>
                                <x-filament::input.wrapper>
                                    <x-filament::input.label for="name" value="{{ __('Name') }}" />
                                    <x-filament::input.text
                                        wire:model="name"
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                        autofocus
                                        autocomplete="name"
                                    />
                                    <x-filament::input.error for="name" />
                                </x-filament::input.wrapper>
                            </div>

                            <div>
                                <x-filament::input.wrapper>
                                    <x-filament::input.label for="email" value="{{ __('Email') }}" />
                                    <x-filament::input.text
                                        wire:model="email"
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="username"
                                    />
                                    <x-filament::input.error for="email" />
                                </x-filament::input.wrapper>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-filament::button type="submit">
                                    {{ __('Save') }}
                                </x-filament::button>

                                <x-filament::loading-indicator wire:loading wire:target="updateProfile" />
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Update Password') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </header>

                        <form wire:submit="updatePassword" class="mt-6 space-y-6">
                            <div>
                                <x-filament::input.wrapper>
                                    <x-filament::input.label for="current_password" value="{{ __('Current Password') }}" />
                                    <x-filament::input.text
                                        wire:model="current_password"
                                        id="current_password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="current-password"
                                    />
                                    <x-filament::input.error for="current_password" />
                                </x-filament::input.wrapper>
                            </div>

                            <div>
                                <x-filament::input.wrapper>
                                    <x-filament::input.label for="new_password" value="{{ __('New Password') }}" />
                                    <x-filament::input.text
                                        wire:model="new_password"
                                        id="new_password"
                                        type="password"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="new-password"
                                    />
                                    <x-filament::input.error for="new_password" />
                                </x-filament::input.wrapper>
                            </div>

                            <div>
                                <x-filament::input.wrapper>
                                    <x-filament::input.label for="new_password_confirmation" value="{{ __('Confirm Password') }}" />
                                    <x-filament::input.text
                                        wire:model="new_password_confirmation"
                                        id="new_password_confirmation"
                                        type="password"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="new-password"
                                    />
                                    <x-filament::input.error for="new_password_confirmation" />
                                </x-filament::input.wrapper>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-filament::button type="submit">
                                    {{ __('Update Password') }}
                                </x-filament::button>

                                <x-filament::loading-indicator wire:loading wire:target="updatePassword" />
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.main>
