@props(['currentLocale' => LaravelLocalization::getCurrentLocale()])

@php
    $userAgent = request()->header('User-Agent');
    $isMobile = preg_match('/Mobile|Android|iPhone|iPad|Opera Mini|IEMobile|WPDesktop/i', $userAgent);
    $backgroundImage = $isMobile
        ? "/img/LANDING-MOBILE.svg"
        : "/img/landing-salute-ora-updated.svg";
        $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale;
@endphp

<x-layouts.main :isLanding="true">
<!DOCTYPE html>
  <head>
    <meta charset="UTF-8" />
    <title>Landing Page SaluteOra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>

  <body
    style="background-image: url('{{ $backgroundImage }}'); background-repeat: no-repeat; background-position: top; background-size: cover;"
    class="min-h-screen m-0 p-0"
  >
    <!-- INIZIO HEADER -->
    <div>
      <div class="w-full h-32 p-6 lg:p-8 flex flex-row items-center justify-between">
        <div>
          <img src="/img/logo.png" class="h-9 lg:h-14" />
        </div>
        @if (!$isMobile)
        <div class="flex flex-row items-center">
          <a href="/it/">
            <span class="text-white p-4 text-xl">Home</span>
          </a>
          <a href="/it/pages/progetto">
            <span class="text-white p-4 text-xl">Progetto</span>
          </a>
          <a href="/it/pages/partners">
            <span class="text-white p-4 text-xl">Partners</span>
          </a>
        </div>
        <div>
          <a href="/it/auth/login">
            <span class="text-white text-xl p-4">Accedi</span>
          </a>
          <a href="/it/auth/register">
            <button
              class="text-white text-xl bg-transparent border-2 border-white py-4 px-6 rounded-lg"
            >
              Registrati
            </button>
          </a>
        </div>
        @endif
        @if ($isMobile)
        <div>
        <div class="flex md:hidden">
                <button type="button"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    aria-expanded="false">
                    <span class="sr-only">Apri menu principale</span>
                    {{-- Hamburger Icon --}}
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    {{-- Close Icon --}}
                    <svg x-show="mobileMenuOpen" class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        @endif
        <div class="w-8 lg:w-9 h-auto">
        <x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::icon-button
            :icon="'ui-flags.' . $flagCode"
            class="inline-flex items-center justify-center gap-2 px-2 py-2 rounded-lg bg-white shadow-sm border border-gray-200 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-primary-500"
            :label="$flagCode"
            aria-hidden="true"
        />
    </x-slot>

    <x-filament::dropdown.list>
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @php
                $flagCode = $localeCode === 'en' ? 'gb' : $localeCode;
            @endphp
            <x-filament::dropdown.list.item
                :icon="'ui-flags.' . $flagCode"
                tag="a"
                :href="LaravelLocalization::getLocalizedURL($localeCode)"
                :color="$currentLocale === $localeCode ? 'primary' : null"
            >
                <span class="font-medium">{{ $properties['native'] }}</span>
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
        </div>
      </div>
    </div>
    <!-- FINE HEADER -->
    <!-- INIZIO PRIMA SECTION -->
    <div class="p-6 lg:mt-60 lg:ml-32 lg:w-2/5 flex flex-col justify-start">
      <h1 class="text-[#FF5F7E] text-[45px] lg:text-5xl leading-tight font-bold lg:text-8xl mb-2.5">
        Benvenuta su <br />
        Salute Orale
      </h1>
      <span class="w-64 lg:w-auto text-[#FCD5D0] text-lg lg:text-2xl leading-slug">
        Il portale che vuole garantire alle pazienti vulnerabili in stato di
        gravidanza la possibilità di accedere a servizi odonoiatrici di
        prevenzione a titolo completamente gratuito
      </span>
      <a href="/it/auth/register">
        <button
          class="w-40 lg:w-44 bg-[#FF5F7E] text-white py-3 px-7 rounded-lg text-xl lg:text-2xl mt-4"
        >
          Inizia Ora
        </button>
      </a>
    </div>
    <!-- FINE PRIMA SECTION -->
    <!-- INIZIO SECONDA SECTION -->
    <div>
      <div class="p-6 mt-12 lg:mt-52 flex justify-center">
        <h2 class="text-[#FF5F7E] text-4xl text-center">
          Perché é importante la salute orale in gravidanza?
        </h2>
      </div>
      <div class="flex flex-col lg:flex-row justify-around items-center lg:items-start mt-10">
        <div class="w-96 flex flex-col justify-center m-5 text-center">
          <span class="text-[#FCD5D0] text-2xl mb-5">Prevenzione</span>
          <p class="text-[#FCD5D0] text-xl">
            La prevenzione odontoiatrica in gravidanza é fondamentale per la
            salute della mamma e del bambino
          </p>
        </div>
        <div class="w-96 flex flex-col justify-center m-5 text-center">
          <span class="text-[#FCD5D0] text-2xl mb-5">Assistenza</span>
          <p class="text-[#FCD5D0] text-xl">
            Offriamo assistenza odontoiatrica specialistica per le gestanti
          </p>
        </div>
        <div class="w-96 flex flex-col justify-center m-5 text-center">
          <span class="text-[#FCD5D0] text-2xl mb-5">Supporto</span>
          <p class="text-[#FCD5D0] text-xl">
            Supporto completo per le gestanti in condizioni di vulnerabilità
          </p>
        </div>
      </div>
    </div>
    <!-- FINE SECONDA SECTION -->
    <!-- INIZIO TERZA SECTION -->
    <div class="bg-[#FCD5D0] bg-cover m-4 lg:m-20 rounded-[35px]">
      <div
        class="flex flex-col lg:flex-row items-center justify-around lg:justify-center h-[750px] bg-cover bg-inmp-filigrana"
      >
        <div>
          <img class="h-72 lg:h-[500px]" src="/img/dentist.png" />
        </div>
        <div class="flex flex-col items-center">
          <h1 class="text-[#272C4D] text-center text-4xl lg:text-6xl">Vuoi partecipare al progetto?</h1>
          <span class="text-[#272C4D] text-center text-xl mt-10"
            >Unisciti alla rete di professionisti che si prendono cura della
            salute orale delle gestanti</span
          >
          <a href="/it/auth/register">
          <button
            class="w-44 text-[#272C4D] text-xl lg:text-2xl mt-10 border-[#272C4D] border-2 py-2 px-5 lg:py-3 lg:px-7 rounded-lg"
          >
            Registrati
          </button>
        </a>
        </div>
      </div>
    </div>
    <!-- FINE TERZA SECTION -->
    <!-- INIZIO QUARTA SECTION -->
    <div class="w-full flex justify-center">
      <h1 class="text-[#FF5F7E] text-3xl">Per informazioni aggiuntive</h1>
    </div>
    <div class="h-64 pt-5 flex flex-col lg:flex-row justify-center items-center">
      <div class="w-64 h-44 bg-cover bg-[#FCD5D0] rounded-[25px] m-5">
        <div class="grid grid-cols-2">
          <div class="flex justify-center">
            <img class="h-44 px-2 pt-2" src="/img/woman-characterrr.png" />
          </div>
          <div class="flex flex-col items-center justify-center">
            <span class="text-[#FF5F7E] text-xl lg:text-2xl"
              >Vai <br />
              alla <br />
              guida</span
            >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="#FF5F7E"
              class="size-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499"
              />
            </svg>
          </div>
        </div>
      </div>
      <div class="w-64 h-44 bg-[#FCD5D0] rounded-[25px] m-5">
        <div class="grid grid-cols-2 gap-2">
          <div class="flex justify-center">
            <img class="h-44 p-2" src="/img/dentist.png" />
          </div>
          <div class="flex flex-col items-center justify-center">
            <span class="text-[#FF5F7E] text-xl lg:text-2xl"
              >Vai <br />
              alla <br />
              guida</span
            >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="#FF5F7E"
              class="size-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499"
              />
            </svg>
          </div>
        </div>
      </div>
    </div>
    <!-- FINE QUARTA SECTION -->
    <!-- INIZIO QUINTA SECTION -->
    <div class="flex flex-col items-center  pt-7">
      <div>
        <h1 class="text-[#FF5F7E] text-3xl">Con la partecipazione di</h1>
      </div>
      <div class="flex flex-col lg:flex-row items-center">
        <div class="p-5">
          <img class="h-16 lg:h-[150px]" src="/img/coi-logo-updated.png" />
        </div>
        <div class="p-5">
          <img class="h-16 lg:h-[150px]" src="/img/fondazione-andi-white.png" />
        </div>
        <div class="p-5">
          <img class="h-16 lg:h-[150px]" src="/img/inmp-logo-piccolo-updated.png" />
        </div>
      </div>
    </div>
    <!-- FINE QUINTA SECTION -->
    <!-- INIZIO FOOTER -->
    <!-- <div class="mt-20">
      <hr class="text-[#FCD5D0]" />
     </div>
     <div class="h-64 flex flex-row items-center justify-evenly">
      <div class="flex flex-row items-center">
        <span class="text-white text-xl m-3">Privacy Policy</span>
        <span class="text-white text-xl m-3">Termini e Condizioni</span>
        <span class="text-white text-xl m-3">Cookie Policy</span>
      </div>
      <div class="m-5">
        <img src="/img/logo.png" class="h-14" />
      </div>
      <div class="flex flex-row items-center">
        <span class="text-white text-xl m-3">Home</span>
        <span class="text-white text-xl m-3">Progetto</span>
        <span class="text-white text-xl m-3">Partners</span>
        <span class="text-white text-xl m-3">FAQ'S</span>
      </div>
    </div> -->
    <!-- FINE FOOTER -->
</body>
</x-layouts.main>
