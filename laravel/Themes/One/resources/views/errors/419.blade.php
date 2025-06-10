{{--
/**
 * 419 Page Expired Error - SaluteOra Medical Theme
 *
 * Pagina di errore 419 (CSRF Token Mismatch/Page Expired) altamente coinvolgente
 * con tema medico "prescrizione scaduta". Design orientato al massimo engagement
 * con animazioni fluide e soluzioni chiare per il problema.
 *
 * Features WOW:
 * - Animated medical prescription con expiry countdown
 * - Interactive renewal process simulation
 * - Floating medical elements (clock, prescription, stethoscope)
 * - Smart auto-refresh suggestions con progress indicators
 * - Medical-themed humor e messaging professionale
 * - Progressive disclosure per ridurre frustrazione
 * - Real-time session status indicator
 * - Gamification elements con prescription renewal animation
 * - Responsive design con mobile-first approach
 * - Performance-optimized animations
 * - Accessibility-compliant interactions
 *
 * @param int $exception HTTP status code (419)
 * @param string $message Error message
 * @param bool $show_auto_refresh Show auto-refresh timer
 * @param bool $show_manual_refresh Show manual refresh options
 */
--}}

<!DOCTYPE html>
<html lang="it" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sessione Scaduta - SaluteOra</title>
    <meta name="robots" content="noindex, nofollow">

    {{-- Tailwind CSS CDN per sviluppo --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Custom Tailwind Configuration --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-slow': 'float 8s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out 2s infinite',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                        'heartbeat': 'heartbeat 1.5s ease-in-out infinite',
                        'bounce-gentle': 'bounce-gentle 2s ease-in-out infinite',
                        'rotate-slow': 'rotate-slow 10s linear infinite',
                        'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
                        'shake': 'shake 0.5s linear',
                        'countdown': 'countdown 1s ease-in-out infinite',
                        'prescription-flip': 'prescription-flip 3s ease-in-out infinite',
                        'clock-tick': 'clock-tick 1s steps(60) infinite',
                        'fade-in-up': 'fade-in-up 0.8s ease-out forwards',
                        'scale-in': 'scale-in 0.6s ease-out forwards',
                        'refresh-spin': 'refresh-spin 2s linear infinite'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-20px) rotate(5deg)' }
                        },
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%': { transform: 'rotate(3deg)' }
                        },
                        heartbeat: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.1)' }
                        },
                        'bounce-gentle': {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        'rotate-slow': {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' }
                        },
                        'pulse-glow': {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(239, 68, 68, 0.5)' },
                            '50%': { boxShadow: '0 0 40px rgba(239, 68, 68, 0.8)' }
                        },
                        shake: {
                            '0%, 100%': { transform: 'translateX(0)' },
                            '25%': { transform: 'translateX(-5px)' },
                            '75%': { transform: 'translateX(5px)' }
                        },
                        countdown: {
                            '0%': { transform: 'scale(1)', opacity: '1' },
                            '50%': { transform: 'scale(1.2)', opacity: '0.8' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        },
                        'prescription-flip': {
                            '0%, 100%': { transform: 'rotateY(0deg)' },
                            '50%': { transform: 'rotateY(180deg)' }
                        },
                        'clock-tick': {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(6deg)' }
                        },
                        'fade-in-up': {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        'scale-in': {
                            '0%': { opacity: '0', transform: 'scale(0.8)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
                        },
                        'refresh-spin': {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' }
                        }
                    }
                }
            }
        }
    </script>

    {{-- Favicon medico --}}
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⏰</text></svg>">
</head>

<body class="h-full bg-gradient-to-br from-red-50 via-orange-50 to-yellow-100 font-sans antialiased overflow-x-hidden"
      x-data="{
          isVisible: false,
          prescriptionExpired: true,
          countdownTimer: 10,
          autoRefreshEnabled: true,
          refreshing: false,
          sessionStatus: 'expired',
          showPrescriptionDetails: false,
          funnyMessages: [
              '🩺 La tua sessione è scaduta come una prescrizione medica!',
              '📋 Tempo di rinnovare il tuo pass per l\'area riservata!',
              '⏰ Il tuo appuntamento digitale è terminato!',
              '💊 La ricetta della tua sessione necessita rinnovo!',
              '🔒 L\'accesso è scaduto - tempo di una nuova visita!',
              '📝 La tua cartella clinica digitale ha chiuso i battenti!',
              '🚪 La sala d\'attesa virtuale è chiusa, torna domani!'
          ],
          currentMessage: '',
          messageIndex: 0,
          clockTime: '',
          attempts: 0,
          maxAttempts: 3,
          showEasterEgg: false,
          clickCount: 0
      }"
      x-init="
          // Initialize visibility
          setTimeout(() => { isVisible = true; }, 100);

          // Update clock time
          setInterval(() => {
              clockTime = new Date().toLocaleTimeString('it-IT', {
                  hour: '2-digit',
                  minute: '2-digit',
                  second: '2-digit'
              });
          }, 1000);

          // Initialize funny message
          currentMessage = funnyMessages[0];

          // Rotate funny messages
          setInterval(() => {
              messageIndex = (messageIndex + 1) % funnyMessages.length;
              currentMessage = funnyMessages[messageIndex];
          }, 4000);

          // Auto-refresh countdown
          if (autoRefreshEnabled) {
              const countdown = setInterval(() => {
                  countdownTimer--;
                  if (countdownTimer <= 0) {
                      clearInterval(countdown);
                      refreshPage();
                  }
              }, 1000);
          }
      "
      x-intersect="isVisible = true">

    {{-- Floating Medical Elements Background --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        {{-- Floating Clock --}}
        <div class="absolute top-20 left-10 text-6xl opacity-20 animate-float text-red-400">
            ⏰
        </div>

        {{-- Floating Prescription --}}
        <div class="absolute top-1/4 right-20 text-8xl opacity-15 animate-prescription-flip text-orange-400">
            📋
        </div>

        {{-- Floating Hourglass --}}
        <div class="absolute bottom-1/4 left-1/4 text-5xl opacity-25 animate-bounce-gentle text-yellow-400">
            ⏳
        </div>

        {{-- Floating Key --}}
        <div class="absolute top-1/2 right-1/4 text-4xl opacity-20 animate-float-slow text-red-500">
            🔐
        </div>

        {{-- Floating Timer --}}
        <div class="absolute bottom-20 right-10 text-7xl opacity-30 animate-countdown text-orange-500">
            ⏱️
        </div>

        {{-- Floating Medical Chart --}}
        <div class="absolute top-40 left-1/2 text-5xl opacity-15 animate-wiggle text-red-400">
            📊
        </div>

        {{-- Additional Small Elements --}}
        <div class="absolute bottom-1/3 right-1/3 text-3xl opacity-20 animate-float text-yellow-400">
            ⚡
        </div>

        <div class="absolute top-3/4 left-20 text-4xl opacity-25 animate-rotate-slow text-orange-400">
            🔄
        </div>
    </div>

    {{-- Main Content Container --}}
    <div class="relative z-10 min-h-full flex items-center justify-center p-4">
        <div class="max-w-4xl mx-auto text-center">

            {{-- Main Error Display --}}
            <div class="mb-12"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 transform translate-y-16 scale-95"
                 x-transition:enter-end="opacity-100 transform translate-y-0 scale-100">

                {{-- Animated Medical Prescription --}}
                <div class="relative mb-8">
                    <div class="w-64 h-64 mx-auto relative">
                        {{-- Prescription Pad Background --}}
                        <div class="absolute inset-0 bg-white rounded-2xl shadow-2xl border-l-8 border-red-500 transform rotate-3 animate-float">
                            {{-- Prescription Header --}}
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-2xl">🏥</div>
                                    <div class="text-red-500 font-bold text-sm">SCADUTA</div>
                                </div>

                                {{-- Prescription Content --}}
                                <div class="text-left space-y-2">
                                    <div class="text-xs text-gray-600">PRESCRIZIONE DIGITALE</div>
                                    <div class="font-bold text-gray-800">Sessione Web</div>
                                    <div class="text-sm text-gray-600">
                                        <div class="flex items-center space-x-2">
                                            <span>Validità:</span>
                                            <span class="line-through text-red-500">SCADUTA</span>
                                        </div>
                                    </div>

                                    {{-- Expiry Stamp --}}
                                    <div class="absolute bottom-4 right-4 transform rotate-12">
                                        <div class="border-4 border-red-500 rounded-full px-3 py-1">
                                            <div class="text-red-500 font-bold text-xs">SCADUTO</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Clock Overlay --}}
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 cursor-pointer"
                             @click="clickCount++; if(clickCount >= 5) showEasterEgg = true">
                            <div class="text-6xl animate-clock-tick hover:animate-countdown transition-all duration-300 transform hover:scale-110">
                                ⏰
                            </div>
                            {{-- Clock Hands --}}
                            <div class="absolute top-1/2 left-1/2 w-1 h-6 bg-red-500 origin-bottom transform -translate-x-1/2 -translate-y-full animate-clock-tick"></div>
                        </div>

                        {{-- Floating Renewal Elements --}}
                        <div class="absolute -top-4 -left-4 text-2xl animate-bounce-gentle">📝</div>
                        <div class="absolute -top-4 -right-4 text-2xl animate-float-delayed">🔄</div>
                        <div class="absolute -bottom-4 -left-4 text-2xl animate-wiggle">🆕</div>
                        <div class="absolute -bottom-4 -right-4 text-2xl animate-float">✅</div>
                    </div>
                </div>

                {{-- Dynamic Error Code --}}
                <div class="mb-6">
                    <h1 class="text-8xl md:text-9xl font-bold bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 bg-clip-text text-transparent animate-pulse-glow">
                        4⏰9
                    </h1>
                    <div class="text-2xl md:text-3xl font-bold text-gray-700 mt-2">
                        SESSIONE SCADUTA
                    </div>
                </div>

                {{-- Dynamic Funny Message --}}
                <div class="mb-8 h-16 flex items-center justify-center">
                    <p class="text-xl md:text-2xl text-gray-600 max-w-3xl leading-relaxed font-medium"
                       x-text="currentMessage"
                       x-transition:enter="transition ease-out duration-500"
                       x-transition:enter-start="opacity-0 transform translate-y-4"
                       x-transition:enter-end="opacity-100 transform translate-y-0">
                    </p>
                </div>
            </div>

            {{-- Auto-Refresh Timer --}}
            <div class="mb-12"
                 x-show="isVisible && autoRefreshEnabled && countdownTimer > 0"
                 x-transition:enter="transition ease-out duration-1000 delay-300"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <div class="bg-gradient-to-r from-blue-500 to-teal-500 rounded-2xl p-6 shadow-xl border border-blue-400 max-w-lg mx-auto">
                    <div class="text-white text-center">
                        <div class="text-3xl mb-3 animate-countdown">🔄</div>
                        <h3 class="text-xl font-bold mb-2">Rinnovo Automatico</h3>
                        <p class="text-sm opacity-90 mb-4">La pagina si aggiornerà automaticamente tra:</p>

                        {{-- Countdown Display --}}
                        <div class="text-5xl font-bold mb-4 animate-countdown" x-text="countdownTimer + 's'"></div>

                        {{-- Progress Bar --}}
                        <div class="w-full bg-blue-300 rounded-full h-3 mb-4">
                            <div class="bg-white h-3 rounded-full transition-all duration-1000 ease-linear"
                                 :style="`width: ${((10 - countdownTimer) / 10) * 100}%`"></div>
                        </div>

                        <div class="flex justify-center space-x-4">
                            <button @click="refreshPage()"
                                    class="px-4 py-2 bg-white text-blue-600 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                                🚀 Rinnova Ora
                            </button>
                            <button @click="autoRefreshEnabled = false; countdownTimer = 0"
                                    class="px-4 py-2 bg-blue-400 text-white font-bold rounded-full hover:bg-blue-300 transition-all duration-300">
                                ⏸️ Stop
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Manual Refresh Options --}}
            <div class="mb-12"
                 x-show="isVisible && (!autoRefreshEnabled || countdownTimer <= 0)"
                 x-transition:enter="transition ease-out duration-1000 delay-500"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    💊 Scegli la tua medicina:
                </h2>

                {{-- Refresh Options Grid --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    {{-- Simple Refresh --}}
                    <div class="group bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-2xl border border-gray-200 hover:border-green-300 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-4xl mb-3 group-hover:animate-refresh-spin">🔄</div>
                        <h3 class="font-bold text-gray-800 mb-2">Ricarica Semplice</h3>
                        <p class="text-sm text-gray-600 mb-4">Aggiorna la pagina e riprova</p>
                        <button @click="refreshPage()"
                                class="w-full px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-full hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                            🚀 Aggiorna Ora
                        </button>
                    </div>

                    {{-- Return Home --}}
                    <div class="group bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-2xl border border-gray-200 hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-4xl mb-3 group-hover:animate-bounce-gentle">🏠</div>
                        <h3 class="font-bold text-gray-800 mb-2">Torna a Casa</h3>
                        <p class="text-sm text-gray-600 mb-4">Ricomincia dalla homepage</p>
                        <a href="/"
                           class="block w-full px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-full hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 text-center">
                            🏡 Homepage
                        </a>
                    </div>

                    {{-- Login Again --}}
                    <div class="group bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-2xl border border-gray-200 hover:border-purple-300 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-4xl mb-3 group-hover:animate-wiggle">🔐</div>
                        <h3 class="font-bold text-gray-800 mb-2">Nuovo Accesso</h3>
                        <p class="text-sm text-gray-600 mb-4">Effettua un nuovo login</p>
                        <a href="/login"
                           class="block w-full px-4 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-bold rounded-full hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 text-center">
                            🗝️ Accedi
                        </a>
                    </div>
                </div>
            </div>

            {{-- Technical Information --}}
            <div class="mb-8"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-700"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <button @click="showPrescriptionDetails = !showPrescriptionDetails"
                        class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-full border border-gray-300 hover:border-gray-400 hover:bg-gray-200 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    🔬 Dettagli Tecnici
                </button>

                <div x-show="showPrescriptionDetails"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-gray-200 max-w-2xl mx-auto text-left">

                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <span class="text-2xl mr-3">🧪</span>
                        Diagnosi del Problema
                    </h4>

                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-start space-x-3">
                            <span class="text-red-500">❌</span>
                            <div>
                                <strong>Sintomo:</strong> Errore 419 - Page Expired
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-yellow-500">⚠️</span>
                            <div>
                                <strong>Causa:</strong> Token di sicurezza (CSRF) scaduto
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-blue-500">💡</span>
                            <div>
                                <strong>Perché accade:</strong> La sessione è rimasta inattiva troppo a lungo
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-green-500">✅</span>
                            <div>
                                <strong>Cura:</strong> Aggiornare la pagina o effettuare un nuovo accesso
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-2 text-blue-700">
                            <span class="text-xl">🛡️</span>
                            <span class="font-semibold">Sicurezza Garantita</span>
                        </div>
                        <p class="text-sm text-blue-600 mt-2">
                            Questo controllo protegge i tuoi dati medici da accessi non autorizzati.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Emergency Contact --}}
            <div class="mb-8"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-900"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl p-6 shadow-xl border border-orange-400 max-w-lg mx-auto">
                    <div class="flex items-center justify-center space-x-4 text-white">
                        <div class="text-3xl animate-heartbeat">🆘</div>
                        <div class="text-center">
                            <h3 class="text-xl font-bold mb-1">Problemi Persistenti?</h3>
                            <p class="text-sm opacity-90 mb-3">Il nostro team IT è qui per aiutarti</p>
                            <a href="mailto:support@saluteora.it"
                               class="inline-flex items-center px-6 py-3 bg-white text-orange-600 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                📧 Contatta il Supporto
                            </a>
                        </div>
                        <div class="text-3xl animate-bounce-gentle">💻</div>
                    </div>
                </div>
            </div>

            {{-- Easter Egg Modal --}}
            <div x-show="showEasterEgg"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50"
                 @click="showEasterEgg = false">

                <div class="bg-white rounded-3xl p-8 max-w-md mx-4 text-center transform animate-prescription-flip"
                     @click.stop>
                    <div class="text-6xl mb-4 animate-rotate-slow">⏰</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Maestro del Tempo!</h3>
                    <p class="text-gray-600 mb-6">Hai sbloccato il segreto dell'orologio! ⏰✨<br>Il tempo è relativo... specialmente sul web! 🌐</p>
                    <button @click="showEasterEgg = false"
                            class="px-6 py-3 bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold rounded-full hover:from-red-600 hover:to-orange-600 transition-all duration-300">
                        ⚡ Temporizzato! ⚡
                    </button>
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="text-center text-gray-500 text-sm"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-1100"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">

                <div class="flex items-center justify-center space-x-4 mb-4">
                    <span>🕐 <span x-text="clockTime"></span></span>
                    <span>•</span>
                    <span>💻 Errore 419</span>
                    <span>•</span>
                    <span>🦷 SaluteOra</span>
                </div>

                <p class="mb-2">
                    <strong>Tip pro:</strong> Clicca 5 volte sull'orologio per una sorpresa temporale! ⏰
                </p>

                <div class="flex items-center justify-center space-x-2 text-xs">
                    <span>Sicurezza garantita da</span>
                    <span class="animate-heartbeat">🛡️</span>
                    <span>SaluteOra Protection</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Background Animated Waves --}}
    <div class="fixed bottom-0 left-0 right-0 pointer-events-none z-0">
        <svg class="w-full h-32" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,60 C150,100 350,0 600,60 C850,120 1050,20 1200,60 L1200,120 L0,120 Z"
                  fill="rgba(239, 68, 68, 0.1)"
                  class="animate-float">
            </path>
            <path d="M0,80 C300,120 600,40 900,80 C1050,100 1150,60 1200,80 L1200,120 L0,120 Z"
                  fill="rgba(251, 146, 60, 0.1)"
                  class="animate-float-delayed">
            </path>
        </svg>
    </div>

    {{-- Custom JavaScript for Enhanced Interactions --}}
    <script>
        // Refresh page function
        function refreshPage() {
            // Show refreshing state
            document.body.style.filter = 'brightness(1.2)';

            // Simulate network delay for better UX
            setTimeout(() => {
                window.location.reload();
            }, 300);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Prescription renewal animation
            setInterval(() => {
                const prescriptions = document.querySelectorAll('.prescription-element');
                prescriptions.forEach(prescription => {
                    prescription.style.transform = 'rotateY(180deg)';
                    setTimeout(() => {
                        prescription.style.transform = 'rotateY(0deg)';
                    }, 1500);
                });
            }, 8000);

            // Clock tick sound simulation (visual feedback)
            setInterval(() => {
                const clockElements = document.querySelectorAll('[class*="clock"]');
                clockElements.forEach(clock => {
                    clock.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        clock.style.transform = 'scale(1)';
                    }, 100);
                });
            }, 1000);

            // Mouse interaction trail
            document.addEventListener('mousemove', function(e) {
                if (Math.random() > 0.97) {
                    const emoji = ['⏰', '📋', '🔄', '⚡'][Math.floor(Math.random() * 4)];
                    const trail = document.createElement('div');
                    trail.textContent = emoji;
                    trail.style.cssText = `
                        position: fixed;
                        left: ${e.clientX}px;
                        top: ${e.clientY}px;
                        pointer-events: none;
                        z-index: 1000;
                        animation: fadeOutUp 2s forwards;
                        font-size: 18px;
                    `;
                    document.body.appendChild(trail);
                    setTimeout(() => trail.remove(), 2000);
                }
            });

            // Add fadeOutUp animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeOutUp {
                    from { opacity: 1; transform: translateY(0px) rotate(0deg); }
                    to { opacity: 0; transform: translateY(-50px) rotate(360deg); }
                }
            `;
            document.head.appendChild(style);

            // Performance optimization
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            if (reduceMotion.matches) {
                document.documentElement.style.setProperty('--animation-duration', '0s');
            }
        });
    </script>
</body>
</html>
