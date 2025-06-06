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
<div class="p-8">
    <div>
      <button type="button" class="absolute -left-1.5 -top-1 flex items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
        <span class="sr-only">Previous month</span>
        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
          <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
        </svg>
      </button>
      <button type="button" class="absolute -right-1.5 -top-1 flex items-center justify-center p-1.5 text-gray-400 hover:text-gray-500">
        <span class="sr-only">Next month</span>
        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
          <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        </svg>
      </button>
      <section class="text-center">
        <h2 class="text-sm font-semibold text-gray-900">January</h2>
        <div class="mt-6 grid grid-cols-7 text-xs/6 text-gray-500">
          <div>M</div>
          <div>T</div>
          <div>W</div>
          <div>T</div>
          <div>F</div>
          <div>S</div>
          <div>S</div>
        </div>
        <div class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200">
          <!--
            Always include: "py-1.5 hover:bg-gray-100 focus:z-10"
            Is current month, include: "bg-white text-gray-900"
            Is not current month, include: "bg-gray-50 text-gray-400"
  
            Top left day, include: "rounded-tl-lg"
            Top right day, include: "rounded-tr-lg"
            Bottom left day, include: "rounded-bl-lg"
            Bottom right day, include: "rounded-br-lg"
          -->
          <button type="button" class="relative rounded-tl-lg bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <!--
              Always include: "mx-auto flex size-7 items-center justify-center rounded-full"
              Is today, include: "bg-indigo-600 font-semibold text-white"
            -->
            <time datetime="2021-12-27" class="mx-auto flex size-7 items-center justify-center rounded-full">27</time>
          </button>
          <button type="button" class="relative bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2021-12-28" class="mx-auto flex size-7 items-center justify-center rounded-full">28</time>
          </button>
          <button type="button" class="relative bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2021-12-29" class="mx-auto flex size-7 items-center justify-center rounded-full">29</time>
          </button>
          <button type="button" class="relative bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2021-12-30" class="mx-auto flex size-7 items-center justify-center rounded-full">30</time>
          </button>
          <button type="button" class="relative bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2021-12-31" class="mx-auto flex size-7 items-center justify-center rounded-full">31</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-01" class="mx-auto flex size-7 items-center justify-center rounded-full">1</time>
          </button>
          <button type="button" class="relative rounded-tr-lg bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-02" class="mx-auto flex size-7 items-center justify-center rounded-full">2</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-03" class="mx-auto flex size-7 items-center justify-center rounded-full">3</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-04" class="mx-auto flex size-7 items-center justify-center rounded-full">4</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-05" class="mx-auto flex size-7 items-center justify-center rounded-full">5</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-06" class="mx-auto flex size-7 items-center justify-center rounded-full">6</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-07" class="mx-auto flex size-7 items-center justify-center rounded-full">7</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-08" class="mx-auto flex size-7 items-center justify-center rounded-full">8</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-09" class="mx-auto flex size-7 items-center justify-center rounded-full">9</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-10" class="mx-auto flex size-7 items-center justify-center rounded-full">10</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-11" class="mx-auto flex size-7 items-center justify-center rounded-full">11</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-12" class="mx-auto flex size-7 items-center justify-center rounded-full bg-indigo-600 font-semibold text-white">12</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-13" class="mx-auto flex size-7 items-center justify-center rounded-full">13</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-14" class="mx-auto flex size-7 items-center justify-center rounded-full">14</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-15" class="mx-auto flex size-7 items-center justify-center rounded-full">15</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-16" class="mx-auto flex size-7 items-center justify-center rounded-full">16</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-17" class="mx-auto flex size-7 items-center justify-center rounded-full">17</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-18" class="mx-auto flex size-7 items-center justify-center rounded-full">18</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-19" class="mx-auto flex size-7 items-center justify-center rounded-full">19</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-20" class="mx-auto flex size-7 items-center justify-center rounded-full">20</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-21" class="mx-auto flex size-7 items-center justify-center rounded-full">21</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-22" class="mx-auto flex size-7 items-center justify-center rounded-full">22</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-23" class="mx-auto flex size-7 items-center justify-center rounded-full">23</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-24" class="mx-auto flex size-7 items-center justify-center rounded-full">24</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-25" class="mx-auto flex size-7 items-center justify-center rounded-full">25</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-26" class="mx-auto flex size-7 items-center justify-center rounded-full">26</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-27" class="mx-auto flex size-7 items-center justify-center rounded-full">27</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-28" class="mx-auto flex size-7 items-center justify-center rounded-full">28</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-29" class="mx-auto flex size-7 items-center justify-center rounded-full">29</time>
          </button>
          <button type="button" class="relative bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-30" class="mx-auto flex size-7 items-center justify-center rounded-full">30</time>
          </button>
          <button type="button" class="relative rounded-bl-lg bg-white py-1.5 text-gray-900 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-01-31" class="mx-auto flex size-7 items-center justify-center rounded-full">31</time>
          </button>
          <button type="button" class="relative bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-02-01" class="mx-auto flex size-7 items-center justify-center rounded-full">1</time>
          </button>
          <button type="button" class="relative bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-02-02" class="mx-auto flex size-7 items-center justify-center rounded-full">2</time>
          </button>
          <button type="button" class="relative bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-02-03" class="mx-auto flex size-7 items-center justify-center rounded-full">3</time>
          </button>
          <button type="button" class="relative bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-02-04" class="mx-auto flex size-7 items-center justify-center rounded-full">4</time>
          </button>
          <button type="button" class="relative bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-02-05" class="mx-auto flex size-7 items-center justify-center rounded-full">5</time>
          </button>
          <button type="button" class="relative rounded-br-lg bg-gray-50 py-1.5 text-gray-400 hover:bg-gray-100 focus:z-10">
            <time datetime="2022-02-06" class="mx-auto flex size-7 items-center justify-center rounded-full">6</time>
          </button>
        </div>
      </section>
    </div>
    <section class="mt-12">
      <h2 class="text-base font-semibold text-gray-900">Upcoming events</h2>
      <ol class="mt-2 divide-y divide-gray-200 text-sm/6 text-gray-500">
        <li class="py-4 sm:flex">
          <time datetime="2022-01-17" class="w-28 flex-none">Wed, Jan 12</time>
          <p class="mt-2 flex-auto sm:mt-0">Nothing on today’s schedule</p>
        </li>
      </ol>
    </section>
  </div>
  
</div>