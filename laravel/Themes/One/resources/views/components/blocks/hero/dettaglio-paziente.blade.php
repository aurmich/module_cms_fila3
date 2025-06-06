@props([
    'title' => 'Titolo Hero',
    'subtitle' => 'Sottotitolo della hero section',
    'image' => null,
    'cta_text' => null,
    'cta_link' => '#',
    'background_color' => 'bg-white',
    'text_color' => 'text-slate-900',
    'cta_color' => 'bg-primary-600 hover:bg-primary-700'
])


<div class="bg-[#E6EBF7] flex flex-row">
{{-- TITOLO E BOTTONI --}}
<div>
    <section 
        class="bg-[#E6EBF7] relative overflow-hidden"
        aria-labelledby="hero-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <h1 
                        id="hero-heading"
                        class="text-[#1A467F] text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                        {{ $title }}
                    </h1>
                    
                    <p class="mt-3 text-gray-600 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                        {{ $subtitle }}
                    </p>
    
                    @if($cta_text)
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a 
                                    href="{{ Blade::render($cta_link) }}"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md bg-[#1A467F] !text-white md:py-4 md:text-lg md:px-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
                                    role="button"
                                    aria-label="{{ $cta_text }}"
                                >
                                    {{ $cta_text }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
    
                @if($image)
                    <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                        <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                            <img
                                class="w-full h-auto rounded-lg"
                                src="{{ $image }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                            >
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <div class="bg-[#E6EBF7] !py-8 sm:py-32">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-col mx-auto max-w-2xl lg:max-w-none">
           <div class="w-96 bg-[#DBE3EE] p-8 mb-8 rounded-lg text-lg flex justify-between">Anagrafica 
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
            </span>
          </div>
           <div class="w-96 bg-[#DBE3EE] p-8 rounded-lg text-lg flex justify-between">Azioni
           <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
            </span>
           </div>
        </div>
    </div>
</div>
</div>


{{-- CALENDARIO --}}
<div class="h-96">
{{-- Componente Calendar Minimalista per SaluteOra --}}
@props([
    'type' => 'patient', // patient|doctor|admin
])

<div class="calendar-container w-96 h-auto">
    @livewire(\Modules\UI\Filament\Widgets\UserCalendarWidget::class, ['type' => $type])
</div>

{{-- Stili CSS --}}
<style>
    .calendar-container {
        min-height: 300px;
        padding: 1rem;
        background: transparent;
    }
</style>
</div>
</div>