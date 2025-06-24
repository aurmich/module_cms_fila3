<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use function Laravel\Folio\{middleware, name};
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Locked;
use Modules\User\Models\User;

name('profile.edit');
middleware(['auth', 'verified']);

/**
 * Profile edit component for managing user profile, password updates, and account deletion.
 * 
 * Provides secure functionality for:
 * - Updating profile information (name, email)
 * - Changing password with current password verification
 * - Account deletion with password confirmation
 */
$component = new class extends Component {
    /**
     * The authenticated user (locked property).
     *
     * @var User
     */
    #[Locked]
    public User $user;

    /**
     * User's name.
     *
     * @var string
     */
    #[Validate('required|string|min:2|max:255')]
    public string $name = '';

    /**
     * User's email.
     *
     * @var string
     */
    #[Validate('required|email|max:255')]
    public string $email = '';

    /**
     * Current password for password updates.
     *
     * @var string
     */
    #[Validate('required|string')]
    public string $current_password = '';

    /**
     * New password for password updates.
     *
     * @var string
     */
    #[Validate('required|confirmed|min:8')]
    public string $new_password = '';

    /**
     * New password confirmation.
     *
     * @var string
     */
    public string $new_password_confirmation = '';

    /**
     * Password confirmation for account deletion.
     *
     * @var string
     */
    #[Validate('required|string')]
    public string $delete_confirm_password = '';

    /**
     * Initialize the component with user data.
     *
     * @return void
     */
    public function mount(): void
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            abort(401, 'User not authenticated');
        }
        
        $this->user = $user;
        $this->name = $this->user->name ?? '';
        $this->email = $this->user->email ?? '';
    }

    /**
     * Update user profile information with validation and duplicate check.
     *
     * @return void
     */
    public function updateProfile(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user->getKey())],
        ]);

        // Check if there are actual changes to prevent unnecessary updates
        if ($this->user->name === $this->name && $this->user->email === $this->email) {
            $this->dispatch('toast', message: 'No changes detected.', data: [
                'position' => 'top-right', 
                'type' => 'info'
            ]);
            return;
        }

        try {
            // Update user with type-safe data
            $this->user->fill([
                'email' => $this->email,
                'name' => $this->name
            ])->save();

            $this->dispatch('toast', message: 'Profile updated successfully.', data: [
                'position' => 'top-right', 
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Failed to update profile.', data: [
                'position' => 'top-right', 
                'type' => 'error'
            ]);
        }
    }

    /**
     * Update user password with current password verification.
     *
     * @return void
     */
    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Verify current password
        $userPassword = $this->user->getAttribute('password');
        if (!is_string($userPassword) || !Hash::check($this->current_password, $userPassword)) {
            $this->dispatch('toast', message: 'Current password is incorrect.', data: [
                'position' => 'top-right', 
                'type' => 'error'
            ]);
            return;
        }

        try {
            // Update password with new hash and regenerate remember token
            $this->user->fill([
                'password' => Hash::make($this->new_password),
                'remember_token' => Str::random(60)
            ])->save();

            // Clear password fields for security
            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

            // Trigger password reset event
            event(new PasswordReset($this->user));

            $this->dispatch('toast', message: 'Password updated successfully.', data: [
                'position' => 'top-right', 
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Failed to update password.', data: [
                'position' => 'top-right', 
                'type' => 'error'
            ]);
        }
    }

    /**
     * Delete user account after password confirmation.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(): \Illuminate\Http\RedirectResponse
    {
        $this->validate([
            'delete_confirm_password' => ['required', 'string'],
        ]);

        // Verify password before deletion
        $userPassword = $this->user->getAttribute('password');
        if (!is_string($userPassword) || !Hash::check($this->delete_confirm_password, $userPassword)) {
            $this->dispatch('toast', message: 'Password is incorrect. Account deletion cancelled.', data: [
                'position' => 'top-right', 
                'type' => 'error'
            ]);
            $this->reset(['delete_confirm_password']);
            return Redirect::back();
        }

        try {
            $user = $this->user;

            // Logout user before deletion
            Auth::logout();

            // Delete user account
            $user->delete();

            // Invalidate session for security
            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return Redirect::to('/')->with('status', 'Account deleted successfully.');
        } catch (\Exception $e) {
            // Re-authenticate user if deletion fails
            Auth::login($this->user);
            
            $this->dispatch('toast', message: 'Failed to delete account. Please try again.', data: [
                'position' => 'top-right', 
                'type' => 'error'
            ]);
            
            return Redirect::back();
        }
    }
};

?>

<x-layouts.app>
    <x-slot name="header">
        <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    @volt('profile.edit')
        <div class="pb-5">
            <div class="mx-auto space-y-6">

                {{-- Update Profile Section --}}
                <section class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Profile Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        <form wire:submit="updateProfile" class="mt-6 space-y-6">
                            <x-ui.input 
                                label="Name" 
                                type="text" 
                                id="name" 
                                name="name" 
                                wire:model="name" 
                                required 
                                minlength="2"
                                maxlength="255"
                            />
                            
                            <x-ui.input 
                                label="Email address" 
                                type="email" 
                                id="email" 
                                name="email"
                                wire:model="email" 
                                required
                                maxlength="255"
                            />
                            
                            <div class="flex items-start">
                                <x-ui.button type="primary" submit="true">
                                    {{ __('Update Profile') }}
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </section>

                {{-- Update Password Section --}}
                <section class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Update Password') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </header>

                        <form wire:submit="updatePassword" class="mt-6 space-y-6">
                            <x-ui.input 
                                label="Current Password" 
                                type="password" 
                                id="current_password"
                                name="current_password" 
                                wire:model="current_password"
                                required
                                autocomplete="current-password"
                            />
                            
                            <x-ui.input 
                                label="New Password" 
                                type="password" 
                                id="new_password" 
                                name="new_password"
                                wire:model="new_password"
                                required
                                minlength="8"
                                autocomplete="new-password"
                            />
                            
                            <x-ui.input 
                                label="Confirm New Password" 
                                type="password" 
                                id="new_password_confirmation"
                                name="new_password_confirmation" 
                                wire:model="new_password_confirmation"
                                required
                                minlength="8"
                                autocomplete="new-password"
                            />

                            <div class="flex items-start">
                                <x-ui.button type="primary" submit="true">
                                    {{ __('Update Password') }}
                                </x-ui.button>
                            </div>
                        </form>
                    </div>
                </section>

                {{-- Delete Account Section --}}
                <section class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Delete Account') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                            </p>
                        </header>

                        <div class="flex items-start justify-start w-auto mt-6 text-left">
                            <x-ui.button 
                                type="danger" 
                                x-data
                                @click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            >
                                {{ __('Delete Account') }}
                            </x-ui.button>
                        </div>

                        {{-- Delete Account Confirmation Modal --}}
                        <x-ui.modal name="confirm-user-deletion" maxWidth="lg" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form wire:submit="destroy" class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete your account?') }}
                                </h2>
                                
                                <p class="mt-1 mb-6 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </p>

                                <x-ui.input 
                                    label="Password" 
                                    type="password" 
                                    id="delete_confirm_password"
                                    name="delete_confirm_password" 
                                    wire:model="delete_confirm_password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="{{ __('Enter your password to confirm deletion') }}"
                                />

                                <div class="flex justify-end mt-6 space-x-3">
                                    <x-ui.button type="secondary" x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-ui.button>

                                    <x-ui.button type="danger" submit="true">
                                        {{ __('Delete Account') }}
                                    </x-ui.button>
                                </div>
                            </form>
                        </x-ui.modal>
                    </section>
                </div>
            </div>
        </div>
    @endvolt
</x-layouts.app>
