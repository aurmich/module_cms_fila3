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

<section 
    class="flex items-center bg-[#E6EBF7] relative overflow-hidden min-h-[700px]"
    aria-labelledby="hero-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="lg:grid lg:grid-cols-1">
            <div class="text-center md:max-w-2xl md:mx-auto lg:col-span-6">
                <h1 
                    id="hero-heading"
                    class="text-[#1A467F] text-4xl tracking-tight font-extrabold sm:text-5xl lg:text-5xl text-center">
                    {{ $title }}
                </h1>
                
                <p class="mt-3 text-gray-600 sm:mt-5 sm:text-xl lg:text-lg">
                    {{ $subtitle }}
                </p>

                @if($cta_text)
                    <div class="mt-5 sm:mt-8 sm:flex justify-center">
                        <div class="rounded-md shadow">
                            <a 
                                href="{{ Blade::render($cta_link) }}"
                                class="flex items-center justify-center px-8 py-3 w-[350px] bg-gradient-to-r from-cyan-500 to-[#1A467F] p-6 rounded-lg text-lg !text-white"
                                role="button"
                                aria-label="{{ $cta_text }}"
                            >
                                {{ $cta_text }}
                                <span class="cursor-pointer ml-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                </svg>
                            </span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
