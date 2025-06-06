@props([
    'title' => '',
    'subtitle' => '',
    'image' => '',
    'cta' => null,
    'secondaryCta' => null,
    'overlay' => 'gradient', // none, dark, light, gradient
    'minHeight' => 'min-h-[70vh] md:min-h-[80vh]',
    'contentPosition' => 'center', // start, center, end
    'className' => ''
])

@php
    // Handle translations
    $title = is_array($title) ? $title[app()->getLocale()] ?? $title['en'] ?? '' : $title;
    $subtitle = is_array($subtitle) ? $subtitle[app()->getLocale()] ?? $subtitle['en'] ?? '' : $subtitle;
    $image = is_array($image) ? $image[app()->getLocale()] ?? $image['en'] ?? '' : $image;
    
    // Position classes
    $contentPositionClasses = [
        'start' => 'items-start text-left',
        'center' => 'items-center text-center',
        'end' => 'items-end text-right',
    ][$contentPosition] ?? 'items-center text-center';

    // Overlay classes
    $overlayClasses = [
        'gradient' => 'bg-gradient-to-b from-black/60 to-black/20',
        'dark' => 'bg-black/50',
        'light' => 'bg-white/20',
        'none' => '',
    ][$overlay] ?? 'bg-gradient-to-b from-black/60 to-black/20';

    // Process CTA buttons
    $primaryCta = [];
    if (is_array($cta) && count($cta) >= 2) {
        $primaryCta = [
            'text' => is_array($cta[0]) ? ($cta[0][app()->getLocale()] ?? $cta[0]['en'] ?? '') : $cta[0],
            'url' => $cta[1]
        ];
    }

    $secondaryCtaData = [];
    if (is_array($secondaryCta) && count($secondaryCta) >= 2) {
        $secondaryCtaData = [
            'text' => is_array($secondaryCta[0]) ? ($secondaryCta[0][app()->getLocale()] ?? $secondaryCta[0]['en'] ?? '') : $secondaryCta[0],
            'url' => $secondaryCta[1]
        ];
    }
@endphp

<section class="relative {{ $minHeight }} flex items-center overflow-hidden {{ $className }}" 
         x-data="{ 
            scrolled: false,
            mounted: false,
            init() {
                this.mounted = true;
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 50;
                });
            }
         }"
         :class="{ 'pt-16': scrolled }"
         style="transition: padding 0.3s ease-in-out;">
    
    <!-- Background Image -->
    @if($image)
        <div class="absolute inset-0 -z-10">
            <img 
                src="{{ $image }}" 
                alt="" 
                class="absolute inset-0 w-full h-full object-cover"
                :class="{ 'scale-105': !scrolled, 'scale-100': scrolled }"
                style="transition: transform 8s cubic-bezier(0.16, 1, 0.3, 1);"
                loading="lazy"
            >
        </div>
    @endif

    <!-- Overlay -->
    @if($overlay !== 'none')
        <div class="absolute inset-0 -z-10 {{ $overlayClasses }}"></div>
    @endif

    <!-- Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-4xl mx-auto {{ $contentPositionClasses }} flex flex-col gap-6">
            <div class="space-y-6 text-white"
                 x-data="{ 
                    show: false,
                    mounted() { 
                        this.$nextTick(() => {
                            setTimeout(() => this.show = true, 100);
                        });
                    } 
                 }"
                 x-init="mounted()"
                 x-intersect="show = true">
                
                @if($subtitle)
                    <p class="text-lg md:text-xl font-medium tracking-wide uppercase"
                       x-show="show"
                       x-transition:enter="transition-all duration-700 ease-out"
                       x-transition:enter-start="opacity-0 translate-y-4"
                       x-transition:enter-end="opacity-100 translate-y-0">
                        {{ $subtitle }}
                    </p>
                @endif

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight"
                    x-show="show"
                    x-transition:enter="transition-all duration-700 ease-out delay-100"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    {{ $title }}
                </h1>

                @if(!empty($primaryCta) || !empty($secondaryCtaData))
                    <div class="flex flex-wrap gap-4 pt-4"
                         x-show="show"
                         x-transition:enter="transition-all duration-700 ease-out delay-200"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        
                        @if(!empty($primaryCta))
                            <a href="{{ $primaryCta['url'] }}" 
                               class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:scale-105">
                                {{ $primaryCta['text'] }}
                            </a>
                        @endif

                        @if(!empty($secondaryCtaData))
                            <a href="{{ $secondaryCtaData['url'] }}" 
                               class="inline-flex items-center justify-center px-8 py-3 border border-white/20 text-base font-medium rounded-md text-white bg-white/10 hover:bg-white/20 md:py-4 md:text-lg md:px-10 transition-all duration-300 transform hover:scale-105">
                                {{ $secondaryCtaData['text'] }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10" 
         x-show="!scrolled && mounted"
         x-transition:enter="transition ease-out duration-1000 delay-1000"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0">
        <div class="animate-bounce">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>
</section>

@push('styles')
<style>
    .animate-fadeInDown {
        animation: fadeInDown 1s ease-out forwards;
    }
    .animate-fadeInUp {
        animation: fadeInUp 1s ease-out 0.2s forwards;
    }
    .animate-bounce {
        animation: bounce 2s infinite;
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }
</style>
@endpush
