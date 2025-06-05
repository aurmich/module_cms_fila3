<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Informazioni il progetto -->
            <div class="col-span-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">il progetto</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm">
                    Piattaforma dedicata alle gestanti in condizioni di vulnerabilità socio-economica e agli odontoiatri che partecipano al progetto.
                </p>
            </div>

            <!-- Link Utili per Gestanti -->
            <div class="col-span-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Per le Gestanti</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('patient.dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 text-sm">
                            Area Personale
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('patient.doctors') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 text-sm">
                            Trova Odontoiatra
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('patient.documentation') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 text-sm">
                            Documentazione
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Link Utili per Odontoiatri -->
            <div class="col-span-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Per gli Odontoiatri</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('doctor.dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 text-sm">
                            Area Professionale
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.patients') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 text-sm">
                            Gestione Pazienti
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.documentation') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 text-sm">
                            Documentazione Clinica
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contatti e Supporto -->
            <div class="col-span-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contatti</h3>
                <ul class="space-y-2">
                    <li class="text-gray-600 dark:text-gray-300 text-sm">
                        <a href="mailto:supporto@saluteora.it" class="hover:text-primary-600 dark:hover:text-primary-400">
                            supporto@saluteora.it
                        </a>
                    </li>
                    <li class="text-gray-600 dark:text-gray-300 text-sm">
                        <a href="tel:+390123456789" class="hover:text-primary-600 dark:hover:text-primary-400">
                            +39 012 345 6789
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-600 dark:text-gray-300 text-sm">
                    © {{ date('Y') }} il progetto. Tutti i diritti riservati.
                </div>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="{{ route('privacy-policy') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 text-sm">
                        Privacy Policy
                    </a>
                    <a href="{{ route('terms') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 text-sm">
                        Termini e Condizioni
                    </a>
                    <a href="{{ route('cookie-policy') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 text-sm">
                        Cookie Policy
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>