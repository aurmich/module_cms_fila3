@props([
    'alignment' => 'right',
])

<div class="flex items-center space-x-4">
    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
        {{ __('auth.login.title') }}
    </a>

    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-gray-800">
        {{ __('auth.register.title') }}
    </a>
</div>
