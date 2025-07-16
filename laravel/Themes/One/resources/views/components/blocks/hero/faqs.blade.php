<div class="flex flex-col justify-center items-center">

    <!-- Back Button -->
    <div class="w-full flex justify-start">
        {{-- DA AGGIORNARE URL --}}
        <a href="{{ route('home') }}">
            <div class="cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="size-9">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
            </div>
        </a>
    </div>

    <!-- Page title -->
    <div class="p-10 w-full flex justify-center">
        <h1 class="text-center">FAQ'S</h1>
    </div>

    <!-- FAQ Content -->
    <div class="w-full lg:w-2/4 flex flex-col justify-center p-5">

        <!-- FAQ Item -->
        <div>
            <h3 class="text-[#272C4D]">A chi é rivolto questo servizio?</h3>
            <p class="text-[#272C4D] pt-2 text-lg">
                Il portale Salute Orale nasce per aiutare donne in stato di gravidanza con un ISEE inferiore a 20.000 euro.
                Ogni paziente ha diritto ad una sola visita per la durata del progetto.
            </p>
        </div>

        <div class="mt-5">
            <h3 class="text-[#272C4D]">Cosa offre questo servizio?</h3>
            <p class="text-[#272C4D] pt-2 text-lg">
                Il servizio fornisce una prima visita odontoiatrica completa (controllo+igiene) a titolo completamente gratuito
                per le pazienti in stato di gravidanza.
            </p>
        </div>

        <div class="mt-5">
            <h3 class="text-[#272C4D]">Da dove posso accedere al servizio?</h3>
            <p class="text-[#272C4D] pt-2 text-lg">
                Il servizio è disponibile come webapp mobile first. Questo vuol dire che è disponibile liberamente sul web,
                non richiede di scaricare nulla, ed è accessibile via pc o smartphone.
            </p>
        </div>

        <div class="mt-5">
            <h3 class="text-[#272C4D]">Come posso chiedere una visita?</h3>
            <p class="text-[#272C4D] pt-2 text-lg">
                Registrati e prenota la tua visita da questo portale. Assicurati di avere con te dati personali,
                autocertificazione ISEE e certificato medico di gravidanza.
            </p>
        </div>

        <div class="mt-5">
            <h3 class="text-[#272C4D]">Come prenoto un appuntamento?</h3>
            <p class="text-[#272C4D] pt-2 text-lg">
                Una volta registrata potrai cercare tutti gli studi dentistici attivi all’interno di un’area precisa
                e scegliere quello migliore in base a posizione e disponibilità oraria.
            </p>
        </div>

        <div class="mt-5">
            <h3 class="text-[#272C4D]">Devo prenotare uno studio vicino a casa mia?</h3>
            <p class="text-[#272C4D] pt-2 text-lg">
                Puoi prenotare il tuo appuntamento dove vuoi, a patto di riuscire a raggiungere lo studio in tempo per la tua visita.
            </p>
        </div>

        <div class="mt-5">
            <h3 class="text-[#272C4D]">Cosa succede se l'appuntamento viene rifiutato?</h3>
            <p class="text-[#272C4D] pt-2 text-lg">
                Può essere che il dentista rifiuti il tuo appuntamento. Non preoccuparti: potrai prenotare un nuovo appuntamento
                cambiando orario, dentista o area di ricerca.
            </p>
        </div>

        <div class="mt-5">
            <h3 class="text-[#272C4D]">Cosa devo fare se non posso andare ad un appuntamento già accettato?</h3>
            <p class="text-[#272C4D] pt-2 text-lg">
                Se non riesci ad andare ad un appuntamento già confermato, contatta il medico appena possibile
                (almeno 24h prima dell’appuntamento) e informalo della tua assenza!
                In questo modo potrai prenotare una nuova visita. Troverai i suoi contatti (telefono e mail)
                all’interno della tua scheda appuntamento.
                <strong>MANCARE UN APPUNTAMENTO SENZA CONTATTARE IL MEDICO IMPEDISCE DI ACCEDERE NUOVAMENTE AL SERVIZIO.</strong>
            </p>
        </div>

        <!-- Call to Action Box -->
        <div class="mt-5">
            <h3 class="text-[#FF5F7E]">
                Hai altri dubbi? <strong>CONSULTA LA GUIDA!</strong>
            </h3>

            <div class="pt-5 flex flex-col lg:flex-row justify-center items-center">

                <!-- Card 1 -->
                <div class="w-64 h-44 bg-cover bg-[#FCD5D0] rounded-[25px] shadow-2xl m-5">
                    <div class="grid grid-cols-2">
                        <div class="flex justify-center">
                            <img class="h-44 px-2 pt-2" src="/img/woman-characterrr.png" />
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <span class="text-[#FF5F7E] text-xl lg:text-2xl">
                                Vai <br /> alla <br /> guida
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="#FF5F7E" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="w-64 h-44 bg-[#FCD5D0] rounded-[25px] shadow-2xl m-5">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex justify-center">
                            <img class="h-44 p-2" src="/img/dentist.png" />
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <span class="text-[#FF5F7E] text-xl lg:text-2xl">
                                Vai <br /> alla <br /> guida
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="#FF5F7E" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.49 12 3.75 3.75m0 0-3.75 3.75m3.75-3.75H3.74V4.499" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
