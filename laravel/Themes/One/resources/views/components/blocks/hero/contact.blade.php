@props([
    'title' => 'Contattaci per la tua salute orale',
    'subtitle' => 'Il nostro team di specialisti è qui per te 24/7',
    'background_color' => 'bg-gradient-to-br from-teal-50 via-blue-50 to-indigo-100',
    'text_color' => 'text-gray-900',
    'icon' => 'phone-support',
    'icon_color' => 'text-teal-600',
    'image' => '/img/hero-contact-medical.jpg',
    'cta_text' => 'Parla con uno specialista',
    'cta_link' => '/contatti',
    'cta_color' => 'bg-teal-600 hover:bg-teal-700 text-white',
    'emergency_phone' => '+39 800 123 456'
])

<div class="relative min-h-screen flex items-center justify-center overflow-hidden {{ $background_color }}"
     x-data="{
        isVisible: false,
        currentTime: '',
        pulseActive: true
     }"
     x-init="
        setInterval(() => {
            currentTime = new Date().toLocaleTimeString('it-IT', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }, 1000);
        currentTime = new Date().toLocaleTimeString('it-IT', {
            hour: '2-digit',
            minute: '2-digit'
        });
     "
     x-intersect="isVisible = true">

    {{-- Animated Background Elements --}}
    <div class="absolute inset-0">
        {{-- Main gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-teal-600/10 via-blue-600/5 to-indigo-600/10"></div>

        {{-- Floating geometric shapes --}}
        <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-teal-400/20 to-blue-500/20 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-40 h-40 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full blur-xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/4 w-24 h-24 bg-gradient-to-br from-indigo-400/20 to-purple-500/20 rounded-full blur-xl animate-pulse delay-2000"></div>

        {{-- Medical icons pattern --}}
        <div class="absolute inset-0 opacity-5 overflow-hidden">
            <div class="absolute top-1/4 left-1/4 text-8xl animate-float-slow">🩺</div>
            <div class="absolute top-1/3 right-1/4 text-6xl animate-float-medium">💊</div>
            <div class="absolute bottom-1/3 left-1/3 text-7xl animate-float-fast">🏥</div>
            <div class="absolute bottom-1/4 right-1/3 text-5xl animate-float-slow">❤️</div>
        </div>
    </div>

    {{-- Main Content Container --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            {{-- Left Column: Content --}}
            <div class="text-center lg:text-left">

                {{-- Status Badge --}}
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/80 backdrop-blur-sm border border-green-200 mb-8"
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 transform -translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3 animate-pulse"></div>
                    <span class="text-sm font-medium text-green-700">Online ora - Supporto attivo</span>
                    <span class="ml-2 text-xs text-gray-500" x-text="currentTime"></span>
                </div>

                {{-- Main Title with Staggered Animation --}}
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold {{ $text_color }} leading-tight mb-6">
                    <div x-show="isVisible"
                         x-transition:enter="transition ease-out duration-1000 delay-200"
                         x-transition:enter-start="opacity-0 transform translate-y-16"
                         x-transition:enter-end="opacity-100 transform translate-y-0">
                        <span class="block">Siamo qui</span>
                        <span class="block bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent hover:scale-105 transition-transform duration-300 cursor-default">
                            per te
                        </span>
                    </div>
                </h1>

                {{-- Subtitle --}}
                <p class="text-xl sm:text-2xl text-gray-600 mb-8 leading-relaxed max-w-2xl"
                   x-show="isVisible"
                   x-transition:enter="transition ease-out duration-1000 delay-400"
                   x-transition:enter-start="opacity-0 transform translate-y-16"
                   x-transition:enter-end="opacity-100 transform translate-y-0">
                    {{ $subtitle }}
                </p>

                {{-- Emergency Contact Highlight --}}
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 border border-red-200 mb-8 shadow-lg"
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-1000 delay-600"
                     x-transition:enter-start="opacity-0 transform translate-y-16"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="flex items-center justify-center lg:justify-start space-x-4">
                        <div class="relative">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center"
                                 :class="pulseActive ? 'animate-pulse' : ''">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full animate-ping"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Emergenze 24/7</p>
                            <a href="tel:{{ $emergency_phone }}"
                               class="text-xl font-bold text-red-600 hover:text-red-700 transition-colors duration-200">
                                {{ $emergency_phone }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start"
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-1000 delay-800"
                     x-transition:enter-start="opacity-0 transform translate-y-16"
                     x-transition:enter-end="opacity-100 transform translate-y-0">

                    {{-- Primary CTA --}}
                    <a href="{{ $cta_link }}"
                       class="group relative inline-flex items-center px-8 py-4 {{ $cta_color }} font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        <span class="relative z-10">{{ $cta_text }}</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>

                        {{-- Shine effect --}}
                        <div class="absolute inset-0 rounded-full bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                    </a>

                    {{-- Secondary CTA --}}
                    <a href="/prenota-visita"
                       class="group inline-flex items-center px-8 py-4 bg-white/80 backdrop-blur-sm text-gray-700 font-semibold rounded-full border-2 border-gray-200 hover:border-gray-300 hover:bg-white transition-all duration-300 hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Prenota visita
                    </a>
                </div>

                {{-- Trust Indicators --}}
                <div class="mt-12 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-sm text-gray-500"
                     x-show="isVisible"
                     x-transition:enter="transition ease-out duration-1000 delay-1000"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100">

                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Risposta in 2 minuti
                    </div>

                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        GDPR Compliant
                    </div>

                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        Certificato SSL
                    </div>
                </div>
            </div>

            {{-- Right Column: Interactive Contact Widget --}}
            <div class="relative"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-300"
                 x-transition:enter-start="opacity-0 transform translate-x-16"
                 x-transition:enter-end="opacity-100 transform translate-x-0">

                {{-- Floating Contact Cards --}}
                <div class="relative h-96 flex items-center justify-center">

                    {{-- Background Card --}}
                    <div class="absolute inset-0 bg-white/70 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/20"></div>

                    {{-- Content --}}
                    <div class="relative z-10 p-8 text-center">
                        {{-- Icon --}}
                        <div class="w-20 h-20 bg-gradient-to-br from-teal-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Parla con noi</h3>
                        <p class="text-gray-600 mb-6">I nostri specialisti sono pronti ad aiutarti</p>

                        {{-- Quick Contact Options --}}
                        <div class="space-y-3">
                            <a href="tel:{{ $emergency_phone }}"
                               class="block w-full py-3 bg-gradient-to-r from-teal-500 to-blue-500 text-white rounded-xl font-semibold hover:from-teal-600 hover:to-blue-600 transition-all duration-300 transform hover:scale-105">
                                📞 Chiama ora
                            </a>

                            <a href="/chat"
                               class="block w-full py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-300">
                                💬 Chat online
                            </a>

                            <a href="/prenota-video-call"
                               class="block w-full py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-pink-600 transition-all duration-300 transform hover:scale-105">
                                📹 Video consulto
                            </a>
                        </div>
                    </div>

                    {{-- Floating Action Bubbles --}}
                    <div class="absolute -top-4 -right-4 w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg animate-bounce cursor-pointer">
                        <span class="text-2xl">⚡</span>
                    </div>

                    <div class="absolute -bottom-4 -left-4 w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-lg animate-pulse cursor-pointer">
                        <span class="text-xl">✨</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom CSS Animations --}}
<style>
@keyframes float-slow {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

@keyframes float-medium {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(-3deg); }
}

@keyframes float-fast {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(2deg); }
}

.animate-float-slow {
    animation: float-slow 8s ease-in-out infinite;
}

.animate-float-medium {
    animation: float-medium 6s ease-in-out infinite;
}

.animate-float-fast {
    animation: float-fast 4s ease-in-out infinite;
}
</style>
