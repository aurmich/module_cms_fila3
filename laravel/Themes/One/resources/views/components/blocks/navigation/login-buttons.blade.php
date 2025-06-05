@props([
    'alignment' => 'right',
])

<div class="flex items-center space-x-4">
    <a href="{{ route('login') }}" class="text-sm font-medium text-[#E2E8F0] hover:text-[#E2E8F0]">
        {{ __('auth.login.title') }}
    </a>

    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md !text-white bg-[#0D9488]">
        {{ __('auth.register.title') }}
    </a>
</div>
