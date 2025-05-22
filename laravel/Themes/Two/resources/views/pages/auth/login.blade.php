<?php

use function Livewire\Volt\{state, mount};

state([
    'email' => '',
    'password' => '',
    'remember' => false,
]);

$login = function() {
    if (auth()->attempt([
        'email' => $this->email,
        'password' => $this->password,
    ], $this->remember)) {
        return redirect()->intended('/dashboard');
    }

    $this->addError('email', 'Credenziali non valide');
};

?>

<x-filament::page>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <livewire:user::filament.widgets.auth.login-widget />
        </div>
    </div>
</x-filament::page>
