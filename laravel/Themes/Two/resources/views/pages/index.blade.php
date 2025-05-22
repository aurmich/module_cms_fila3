<?php

use function Livewire\Volt\{state, mount};
//use App\Models\Post;

state(['posts' => []]);

mount(function () {
    //$this->posts = Post::latest()->take(5)->get();
});

?>

<div>
    <x-filament::page>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">
                        {{ __('theme::pages.index.title') }}
                    </h1>
                    <p class="text-gray-600 mb-6">
                        {{ __('theme::pages.index.description') }}
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('theme::pages.index.login') }}
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('theme::pages.index.register') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::page>
</div>
