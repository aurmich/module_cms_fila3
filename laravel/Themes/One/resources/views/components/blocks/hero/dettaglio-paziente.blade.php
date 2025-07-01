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



{{-- STEP PRENOTA VISITA --}}

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
                        <a href="/it/patient/book">
                      <div class="w-[350px] bg-gradient-to-r from-cyan-500 to-[#1A467F] p-6 text-white rounded-lg text-lg items-center flex justify-center cursor-pointer">Prenota una visita
                      <span class="cursor-pointer ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                            </svg>
                        </span>
                      </div>
                       </a>
                    </div>
                </div>
               </div>  
          </section>
  </div>      
</div>



{{-- AREA PERSONALE PAZIENTE --}}
<!-- <section 
    class="flex items-start bg-[#E6EBF7] relative overflow-hidden">
    <div class="w-full px-4 sm:px-6 lg:px-8 pt-12">
        <div>
            <div class="w-full flex flex-col-reverse lg:flex-row justify-evenly gap-8">
                <div class="flex justify-center">
                    <div class="h-full flex flex-col items-start justify-center">
                    <h1
                        class="text-[#272C4D] text-4xl tracking-tight font-extrabold sm:text-5xl lg:text-5xl text-center">
                        {{ $title }}
                    </h1>
                    <span class="text-lg mt-4 text-center lg:text-left">Qui puoi trovare i dettagli del tuo appuntamento</span>
                    </div>

                </div>
             
                <div class="flex justify-center">
                    <img class="w-32 lg:w-44" src="/img/donna-area-paziente.svg"/>
                </div>
            </div>
        </div>
    </div>
</section> -->

{{-- APPUNTAMENTO --}}

{{-- @if(3-2 == 5) --}}

<!-- <div class="w-full flex flex-col lg:flex-row items-center justify-center p-5">
 <div class="w-full lg:w-2/4 flex items-center p-9">
                <div class="w-full lg:w-2/4 bg-white rounded-lg shadow-2xl">
                    <div class="p-5">
                        <h4 class="mb-5 font-semibold">Appuntamento in programma</h4>

                        <div class="flex flex-row items-center mb-2">
                            <span class="mr-2 font-medium">Data:</span>
                            <p>19/06/2025</p>
                        </div>
                        <div class="flex flex-row items-center mb-2">
                            <span class="mr-2 font-medium">Orario:</span>
                            <p>10:00 - 11:00</p>
                        </div>
                        <div class="flex flex-row items-center mb-2">
                            <span class="mr-2 font-medium">Studio:</span>
                            <p>OralB</p>
                        </div>
                        <div class="flex flex-row items-center mb-2">
                            <span class="mr-2 font-medium">Indirizzo studio:</span>
                            <p>Via dei test 79</p>
                        </div>
                        <div class="flex flex-row items-center mb-2">
                            <span class="mr-2 font-medium">Telefono:</span>
                            <p>0425 57899</p>
                        </div>
                        <div class="flex flex-row items-center">
                            <span class="mr-2 font-medium">Email:</span>
                            <p>studioralb@email.com</p>
                        </div>
                    </div>
                </div>
</div> -->



       <!-- <div class="ml-5">
           <div class="flex flex-col justify-center">
               <h3 class="text-[#FF5F7E]">
                   Il tuo referto è pronto!
               </h3>
       
               <div class="relative w-64 h-48 mt-5 rounded-[25px] bg-[#E6EBF7] shadow-2xl overflow-hidden">
                   <img src="/img/referto.svg" class="w-full h-full" />
       
                   <button class="flex items-center justify-between absolute bottom-0 left-0 w-full bg-[#E6EBF7B3] text-[#272C4D] px-3 text-center text-xl font-extrabold py-5 transition-all duration-300 ease-in-out hover:py-9">
                       Scarica referto!
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                       </svg>
                   </button>
               </div>
           </div>
       </div> -->
</div>


