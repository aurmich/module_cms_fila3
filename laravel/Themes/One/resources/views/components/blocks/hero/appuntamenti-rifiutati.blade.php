<div class="bg-[#E6EBF7]">
    <div>
        {{-- Freccia di ritorno --}}
        <div class="w-full flex justify-start p-6">
            {{-- DA AGGIORNARE URL --}}
            <a href="/it">
                <div class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         class="size-9">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                </div>
            </a>
        </div>

        {{-- Titolo pagina --}}
        <div class="p-10">
            <div class="w-full flex justify-center">
                <h1 class="text-center">Appuntamenti Rifiutati</h1>
            </div>
        </div>

        {{-- Card appuntamento rifiutato con modale info --}}
        <div class="w-full flex flex-col justify-center items-center my-9 px-6">
            <div x-data="{ showInfo: false }"
                 class="bg-[#DDE5EB] w-full lg:w-2/4 flex flex-row items-center justify-between p-5 rounded-[15px]">

                {{-- Dati appuntamento --}}
                <div>
                    <span class="text-[#BF0303] text-lg">Mara Rossi</span>
                    <div>
                        <p class="text-[#BF0303] text-xs">19 Giugno 2025</p>
                        <p class="text-[#BF0303] text-xs">10:00 - 11:00</p>
                    </div>
                </div>

                {{-- Azioni e icone --}}
                <div class="cursor-pointer flex flex-row items-center">

                    {{-- Icona telefono --}}
                    <div class="pr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="#BF0303"
                             class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M20.25 3.75v4.5m0-4.5h-4.5m4.5 0-6 6m3 12c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
                        </svg>
                    </div>

                    {{-- Pulsante "Apri Dettaglio" --}}
                    <div @click="showInfo = true" class="bg-[#F38B8B] rounded-full ml-5 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="#BF0303"
                             class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                </div>

                {{-- Modale dettaglio appuntamento --}}
                <div x-show="showInfo" x-cloak
                     class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-xl max-w-md w-3/4 lg:w-full">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Dettagli Appuntamento</h2>
                        <div class="text-sm text-gray-700 space-y-2">
                            <p><strong>Nome:</strong> Mara Rossi</p>
                            <p><strong>Data:</strong> 19 Giugno 2025</p>
                            <p><strong>Orario:</strong> 10:00 - 11:00</p>
                            <p><strong>Note:</strong> Prima visita conoscitiva.</p>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button @click="showInfo = false"
                                    class="px-4 py-2 bg-[#FF5F7E] text-white rounded-md">
                                Chiudi
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Fine modale --}}
            </div>
        </div>
    </div>
</div>
