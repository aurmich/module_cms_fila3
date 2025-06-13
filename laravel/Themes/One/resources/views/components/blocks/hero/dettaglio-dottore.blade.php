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
    class="flex items-start bg-[#E6EBF7] relative overflow-hidden"
    aria-labelledby="hero-heading">
    <div class="w-full px-4 sm:px-6 lg:px-8 pt-12">
        <div>
            <div class="w-full flex justify-evenly gap-8">
                <div class="flex justify-center">
                    <div class="h-full flex flex-col items-start justify-center">
                    <h1 
                        id="hero-heading"
                        class="text-[#272C4D] text-4xl tracking-tight font-extrabold sm:text-5xl lg:text-5xl text-center">
                        {{ $title }}
                    </h1>
                    <span class="text-lg mt-4">In questa pagina puoi gestire comodamente tutti i tuoi appuntamenti.</span>
                    </div>

                </div>
             
                <div>
                    <img class="w-64" src="/img/dottore-avatar-DETTAGLIO.png"/>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CALENDAR MONTH --}}
<div class="bg-[#E6EBF7] flex flex-col-reverse lg:flex-row justify-center p-12">
    <div class="w-full lg:w-7/12">
  <div class="">
        <header class="flex items-center justify-between border-b border-gray-200 px-6 py-4 lg:flex-none">
        <h1 class="text-base font-semibold text-gray-900">
          <time datetime="2022-01">January 2022</time>
        </h1>
        <div class="flex items-center">
          <div class="relative flex items-center rounded-md bg-white shadow-sm md:items-stretch">
            <button type="button" class="flex h-9 w-12 items-center justify-center rounded-l-md border-y border-l border-gray-300 pr-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pr-0 md:hover:bg-gray-50">
              <span class="sr-only">Previous month</span>
              <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
              </svg>
            </button>
            <button type="button" class="hidden border-y border-gray-300 px-3.5 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:relative md:block">Today</button>
            <span class="relative -mx-px h-5 w-px bg-gray-300 md:hidden"></span>
            <button type="button" class="flex h-9 w-12 items-center justify-center rounded-r-md border-y border-r border-gray-300 pl-1 text-gray-400 hover:text-gray-500 focus:relative md:w-9 md:pl-0 md:hover:bg-gray-50">
              <span class="sr-only">Next month</span>
              <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
       </header>
      <div class="lg:min-h-[600px] shadow ring-1 ring-black/5 lg:flex lg:flex-auto lg:flex-col">
        <div class="grid grid-cols-7 gap-px border-b border-gray-300 bg-gray-200 text-center text-xs/6 font-semibold text-gray-700 lg:flex-none">
          <div class="flex justify-center bg-white py-2">
            <span>M</span>
            <span class="sr-only sm:not-sr-only">on</span>
          </div>
          <div class="flex justify-center bg-white py-2">
            <span>T</span>
            <span class="sr-only sm:not-sr-only">ue</span>
          </div>
          <div class="flex justify-center bg-white py-2">
            <span>W</span>
            <span class="sr-only sm:not-sr-only">ed</span>
          </div>
          <div class="flex justify-center bg-white py-2">
            <span>T</span>
            <span class="sr-only sm:not-sr-only">hu</span>
          </div>
          <div class="flex justify-center bg-white py-2">
            <span>F</span>
            <span class="sr-only sm:not-sr-only">ri</span>
          </div>
          <div class="flex justify-center bg-white py-2">
            <span>S</span>
            <span class="sr-only sm:not-sr-only">at</span>
          </div>
          <div class="flex justify-center bg-white py-2">
            <span>S</span>
            <span class="sr-only sm:not-sr-only">un</span>
          </div>
        </div>
        <div class="flex bg-gray-200 text-xs/6 text-gray-700 lg:flex-auto">
          <div class="hidden w-full lg:grid lg:grid-cols-7 lg:grid-rows-6 lg:gap-px">
            <!--
              Always include: "relative py-2 px-3"
              Is current month, include: "bg-white"
              Is not current month, include: "bg-gray-50 text-gray-500"
            -->
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <!--
                Is today, include: "flex size-6 items-center justify-center rounded-full bg-indigo-600 font-semibold text-white"
              -->
              <time datetime="2021-12-27">27</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2021-12-28">28</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2021-12-29">29</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2021-12-30">30</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2021-12-31">31</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-01">1</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-01">2</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-03">3</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-04">4</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-05">5</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-06">6</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-07">7</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-08">8</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-09">9</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-10">10</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-11">11</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-12" class="flex size-6 items-center justify-center rounded-full bg-[#FF5F7E] font-semibold text-white">12</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-13">13</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-14">14</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-15">15</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-16">16</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-17">17</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-18">18</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-19">19</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-20">20</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-21">21</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-22">22</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-23">23</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-24">24</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-25">25</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-26">26</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-27">27</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-28">28</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-29">29</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-30">30</time>
            </div>
            <div class="relative bg-white px-3 py-2">
              <time datetime="2022-01-31">31</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2022-02-01">1</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2022-02-02">2</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2022-02-03">3</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2022-02-04">4</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2022-02-05">5</time>
            </div>
            <div class="relative bg-gray-50 px-3 py-2 text-gray-500">
              <time datetime="2022-02-06">6</time>
            </div>
          </div>
          <div class="isolate grid w-full grid-cols-7 grid-rows-6 gap-px lg:hidden">
            <!--
              Always include: "flex h-14 flex-col py-2 px-3 hover:bg-gray-100 focus:z-10"
              Is current month, include: "bg-white"
              Is not current month, include: "bg-gray-50"
              Is selected or is today, include: "font-semibold"
              Is selected, include: "text-white"
              Is not selected and is today, include: "text-indigo-600"
              Is not selected and is current month, and is not today, include: "text-gray-900"
              Is not selected, is not current month, and is not today: "text-gray-500"
            -->
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <!--
                Always include: "ml-auto"
                Is selected, include: "flex size-6 items-center justify-center rounded-full"
                Is selected and is today, include: "bg-indigo-600"
                Is selected and is not today, include: "bg-gray-900"
              -->
              <time datetime="2021-12-27" class="ml-auto">27</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2021-12-28" class="ml-auto">28</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2021-12-29" class="ml-auto">29</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2021-12-30" class="ml-auto">30</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2021-12-31" class="ml-auto">31</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-01" class="ml-auto">1</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-02" class="ml-auto">2</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-03" class="ml-auto">3</time>
              <span class="sr-only">2 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-04" class="ml-auto">4</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-05" class="ml-auto">5</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-06" class="ml-auto">6</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-07" class="ml-auto">7</time>
              <span class="sr-only">1 event</span>
              <span class="-mx-0.5 mt-auto flex flex-wrap-reverse">
                <span class="mx-0.5 mb-1 size-1.5 rounded-full bg-gray-400"></span>
              </span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-08" class="ml-auto">8</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-09" class="ml-auto">9</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-10" class="ml-auto">10</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-11" class="ml-auto">11</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 font-semibold text-indigo-600 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-12" class="ml-auto">12</time>
              <span class="sr-only">1 event</span>
              <span class="-mx-0.5 mt-auto flex flex-wrap-reverse">
                <span class="mx-0.5 mb-1 size-1.5 rounded-full bg-gray-400"></span>
              </span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-13" class="ml-auto">13</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-14" class="ml-auto">14</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-15" class="ml-auto">15</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-16" class="ml-auto">16</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-17" class="ml-auto">17</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-18" class="ml-auto">18</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-19" class="ml-auto">19</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-20" class="ml-auto">20</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-21" class="ml-auto">21</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 font-semibold text-white hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-22" class="ml-auto flex size-6 items-center justify-center rounded-full bg-gray-900">22</time>
              <span class="sr-only">2 events</span>
              <span class="-mx-0.5 mt-auto flex flex-wrap-reverse">
                <span class="mx-0.5 mb-1 size-1.5 rounded-full bg-gray-400"></span>
                <span class="mx-0.5 mb-1 size-1.5 rounded-full bg-gray-400"></span>
              </span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-23" class="ml-auto">23</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-24" class="ml-auto">24</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-25" class="ml-auto">25</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-26" class="ml-auto">26</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-27" class="ml-auto">27</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-28" class="ml-auto">28</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-29" class="ml-auto">29</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-30" class="ml-auto">30</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-white px-3 py-2 text-gray-900 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-01-31" class="ml-auto">31</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-02-01" class="ml-auto">1</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-02-02" class="ml-auto">2</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-02-03" class="ml-auto">3</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-02-04" class="ml-auto">4</time>
              <span class="sr-only">1 event</span>
              <span class="-mx-0.5 mt-auto flex flex-wrap-reverse">
                <span class="mx-0.5 mb-1 size-1.5 rounded-full bg-gray-400"></span>
              </span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-02-05" class="ml-auto">5</time>
              <span class="sr-only">0 events</span>
            </button>
            <button type="button" class="flex h-14 flex-col bg-gray-50 px-3 py-2 text-gray-500 hover:bg-gray-100 focus:z-10">
              <time datetime="2022-02-06" class="ml-auto">6</time>
              <span class="sr-only">0 events</span>
            </button>
          </div>
        </div>
      </div>
    </div>
 </div>
<div class="flex">
     <div class="bg-[#E6EBF7] flex flex-col justify-center p-6 lg:p-12">
      <div class="w-full">
      <div class="overflow-hidden rounded-lg bg-white shadow m-5">
                    <a href="/it/pages/appuntamenti-entrata">
                    <div class="px-4 py-5 sm:p-6 flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                    </svg>
                    <span class="ml-2 text-[#272C4D]">Appuntamenti in entrata</span>
                    </div>
                    </a>
                    </div>
         <div class="overflow-hidden rounded-lg bg-white shadow m-5">
          <a href="/it/pages/appuntamenti-accettati">
          <div class="bg-[#B4E1BE] px-4 py-5 sm:p-6 flex flex-row">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3E783E" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                   <span class="ml-2 text-[#3E783E]">Appuntamenti accettati</span>
               </div>
          </a>
          </div>
          <div class="overflow-hidden rounded-lg bg-white shadow m-5">
            <a href="/it/pages/appuntamenti-rifiutati">
            <div class="bg-[#F38B8B] px-4 py-5 sm:p-6 flex flex-row">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#BF0303" class="size-6">
               <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
              <span class="ml-2 text-[#BF0303]">Appuntamenti rifiutati</span>
             </div>
            </a>
          </div>
      </div>
     </div>
    </div>
</div>


