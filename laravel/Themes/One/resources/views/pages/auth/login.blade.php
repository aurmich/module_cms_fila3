<?php

declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, rules};

middleware(['guest']);
name('login');



?>

<x-layouts.main>
    @volt('login')
    <div id="wave-container" class="flex flex-col items-stretch justify-center w-full min-h-screen py-10 sm:items-center relative overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-indigo-50 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800">
        <!-- Reactive subtle background waves -->
        <svg id="wave-svg" class="absolute inset-0 w-full h-full opacity-10 pointer-events-none" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#A5B4FC" fill-opacity="0.1" d="M0,224L60,213.3C120,203,240,181,360,176C480,171,600,181,720,181.3C840,181,960,171,1080,160C1200,149,1320,139,1380,133.3L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
        </svg>
        <!-- Floating decorative shapes -->
        <div class="absolute top-8 left-8 w-16 h-16 bg-pink-300 rounded-full mix-blend-multiply opacity-30 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-20 h-20 bg-yellow-300 rounded-full mix-blend-multiply opacity-20 animate-bounce"></div>
        <div class="mx-auto w-full max-w-md">
            <a href="{{ route('home') }}" class="block text-center">
                <x-filament::icon name="heroicon-o-home" class="w-auto h-10 mx-auto text-primary-600" />
            </a>

            <h2 class="mt-5 text-2xl font-extrabold leading-9 text-center text-[#1A467F]">
                {{ __('auth.login.title') }}
            </h2>
            <div class="text-sm leading-5 text-center text-gray-600 dark:text-gray-400 space-x-0.5">
                <span>{{ __('auth.login.or') }}</span>
                <a href="{{ route('register') }}" class="text-[#0D9488] font-medium">
                    {{ __('auth.login.create_account') }}
                </a>
            </div>
        </div>

        <div class="mt-8 mx-auto w-full max-w-md relative">
            <!-- Glassmorphism login card -->
            <div class="relative z-10 bg-white/50 dark:bg-gray-800/50 backdrop-blur-md rounded-2xl p-8 shadow-lg ring-1 ring-white/20">
                <!-- Lottie animation placeholder -->
                <div class="flex justify-center mb-4">
                    <lottie-player src="/animations/login-character.json" background="transparent" speed="1" loop autoplay class="w-32 h-32"></lottie-player>
                </div>
                <!-- Livewire Login Form -->
                <div class="space-y-6">
                    @livewire(\Modules\User\Filament\Widgets\LoginWidget::class)
                </div>
            </div>
            <!-- Subtle SVG bottom decoration -->
            <svg class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-full h-16 text-white/50" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="currentColor" d="M0,192L40,186.7C80,181,160,171,240,176C320,181,400,203,480,197.3C560,192,640,160,720,133.3C800,107,880,85,960,96C1040,107,1120,149,1200,149.3C1280,149,1360,107,1440,85.3L1440,320L1360,320C1280,320,1200,320,1120,320C1040,320,960,320,880,320C800,320,720,320,640,320C560,320,480,320,400,320C320,320,240,320,160,320C80,320,40,320,0,320Z"></path>
            </svg>
        </div>
    </div>
    @endvolt
    <!-- Mousemove handler for wave effect -->
    <script>
        document.getElementById('wave-container').addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const dx = ((e.clientX - rect.left) / rect.width - 0.5) * 30;
            const dy = ((e.clientY - rect.top) / rect.height - 0.5) * 20;
            const svg = document.getElementById('wave-svg');
            svg.style.transform = `translate(${dx}px, ${dy}px)`;
        });
    </script>
</x-layouts.main>
