<div class="bg-[#E6EBF7] p-5">
    <div class="bg-[#E6EBF7]">
        <!-- Back button -->
        <div class="w-full flex justify-start p-6">
            <!-- DA AGGIORNARE URL -->
            <a href="/it">
                <div class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-9">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                </div>
            </a>
        </div>

        <!-- Avatar e nome -->
        <div class="p-10">
            <div class="w-full flex flex-col justify-center items-center">
                <div class="w-48 h-48 bg-[#E6EBF7] rounded-full flex items-center justify-center overflow-hidden shadow-lg">
                    <img class="h-40 object-contain" src="/img/donna-personaggio.png" alt="Avatar" />
                </div>
                <h1 class="text-center mt-5">Mara Rossi</h1>
            </div>
        </div>

        <!-- Sezione principale -->
        <div class="w-full flex flex-col-reverse lg:flex-row">
            <!-- Colonna sinistra: Dati -->
            <div class="w-full lg:w-2/4 flex justify-center">
                <div class="w-full lg:w-5/6 bg-[#E6EBF7] shadow-2xl rounded-[15px] mt-5 lg:mt-0">
                    <div class="flex flex-row items-center justify-between bg-[#E6EBF7] m-5 px-2">
                        <h2>I miei dati</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>
                    </div>

                    <!-- Form -->
                    <div class="flex flex-col lg:flex-row justify-center items-center">
                        <div class="w-full lg:w-3/6 p-5">
                            <input class="bg-transparent" placeholder="Nome" type="text" id="name" />
                        </div>
                        <div class="w-full lg:w-3/6 p-5">
                            <input class="bg-transparent" placeholder="Cognome" type="text" id="surname" />
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row justify-center items-center">
                        <div class="w-full lg:w-3/6 p-5">
                            <input class="bg-transparent" placeholder="Email" type="email" id="email" />
                        </div>
                        <div class="w-full lg:w-3/6 p-5">
                            <input class="bg-transparent" placeholder="Cellulare" type="number" id="phone" />
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row justify-center items-center">
                        <div class="w-full lg:w-3/6 p-5">
                            <input class="bg-transparent" placeholder="Domicilio" type="text" id="domicilio" />
                        </div>
                        <!-- <div class="w-full lg:w-3/6 p-5">
                            <input class="bg-transparent" placeholder="Cellulare" type="number" id="phone" />
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Colonna destra: Appuntamento -->
            <div class="w-full lg:w-2/4 flex justify-center items-center p-5">
                <div class="w-full lg:w-2/4 bg-white rounded-lg shadow-lg">
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
            </div>
        </div>
    </div>  
</div>
