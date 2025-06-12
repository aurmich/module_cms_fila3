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


<div class="bg-[#E6EBF7] lg:grid grid-cols-1 sm:grid grid-cols-1">
      {{-- TITOLO E BOTTONI --}}
      <div class="flex flex-col justify-center">
          <section 
              class="flex flex-col justify-center min-h-[700px] bg-[#E6EBF7] relative overflow-hidden"
              aria-labelledby="hero-heading">
              <div class="m-5">
                  <div>
                      <div class="text-center md:max-w-2xl md:mx-auto lg:col-span-6">
                          <h1 
                              id="hero-heading"
                              class="text-[#272C4D] text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                              Bentornata, </br> nome
                          </h1>
                          
                          <p class="mt-3 text-gray-600 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                              {{ $subtitle }}
                          </p>
          
                          @if($cta_text)
                              <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                  <div class="rounded-md shadow">
                                      <a 
                                          href="{{ Blade::render($cta_link) }}"
                                          class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md bg-[#272C4D] !text-white md:py-4 md:text-lg md:px-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
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
              {{-- BOTTONI --}}
               <div class="w-full flex justify-center bg-[#E6EBF7] !py-8 sm:py-32 mx-auto">
                <div class="w-full mx-auto max-w-7xl lg:px-6 sm:px-3">
                    <div class="flex flex-col items-center mx-auto w-full max-w-2xl px-4 sm:px-6 lg:px-0 gap-4">
                      <div class="w-[350px] bg-gradient-to-r from-cyan-500 to-[#1A467F] p-6 text-white rounded-lg text-lg items-center flex justify-center cursor-pointer">Prenota una visita
                      <span class="cursor-pointer ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                            </svg>
                        </span>
                      </div>
                    </div>
                </div>
               </div>  
          </section>
</div>

      {{-- CALENDARIO --}}
      </div>