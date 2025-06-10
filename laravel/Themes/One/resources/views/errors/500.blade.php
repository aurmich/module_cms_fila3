{{--
/**
 * 500 Internal Server Error - SaluteOra Medical Emergency Theme
 *
 * Pagina di errore 500 altamente coinvolgente con tema "emergenza medica".
 * Design orientato al massimo engagement con animazioni fluide e soluzioni pratiche.
 *
 * Features WOW:
 * - Animated medical emergency room simulation
 * - Interactive medical equipment con status indicators
 * - Floating medical emergency elements (ambulance, defibrillator, etc.)
 * - Real-time "patient" (server) vital signs monitoring
 * - Medical team notification system
 * - Progressive disclosure per ridurre panico
 * - Gamification con medical rescue simulation
 * - Emergency contact protocols
 * - Responsive design con mobile-first approach
 */
--}}

<!DOCTYPE html>
<html lang="it" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emergenza Server - SaluteOra</title>
    <meta name="robots" content="noindex, nofollow">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'emergency-pulse': 'emergency-pulse 1s ease-in-out infinite',
                        'heartbeat-critical': 'heartbeat-critical 0.8s ease-in-out infinite',
                        'ambulance-move': 'ambulance-move 3s linear infinite',
                        'equipment-beep': 'equipment-beep 2s ease-in-out infinite',
                        'rescue-bounce': 'rescue-bounce 1.5s ease-in-out infinite',
                        'vital-signs': 'vital-signs 1.2s ease-in-out infinite',
                        'server-flatline': 'server-flatline 3s ease-in-out infinite',
                        'defibrillator': 'defibrillator 2s ease-in-out infinite',
                        'alarm-flash': 'alarm-flash 0.5s ease-in-out infinite'
                    },
                    keyframes: {
                        'emergency-pulse': {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(239, 68, 68, 0.7)' },
                            '50%': { boxShadow: '0 0 40px rgba(239, 68, 68, 1)' }
                        },
                        'heartbeat-critical': {
                            '0%, 100%': { transform: 'scale(1)' },
                            '25%': { transform: 'scale(1.2)' },
                            '50%': { transform: 'scale(1)' },
                            '75%': { transform: 'scale(1.3)' }
                        },
                        'ambulance-move': {
                            '0%': { transform: 'translateX(-100px)' },
                            '100%': { transform: 'translateX(calc(100vw + 100px))' }
                        },
                        'equipment-beep': {
                            '0%, 100%': { opacity: '0.7' },
                            '50%': { opacity: '1' }
                        },
                        'rescue-bounce': {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-15px) rotate(5deg)' }
                        },
                        'vital-signs': {
                            '0%': { height: '20px' },
                            '25%': { height: '60px' },
                            '50%': { height: '30px' },
                            '75%': { height: '80px' },
                            '100%': { height: '20px' }
                        },
                        'server-flatline': {
                            '0%, 100%': { transform: 'scaleX(1)' },
                            '50%': { transform: 'scaleX(1.1)' }
                        },
                        'defibrillator': {
                            '0%, 100%': { transform: 'scale(1) rotate(0deg)' },
                            '50%': { transform: 'scale(1.2) rotate(5deg)' }
                        },
                        'alarm-flash': {
                            '0%, 100%': { backgroundColor: 'rgba(239, 68, 68, 0.8)' },
                            '50%': { backgroundColor: 'rgba(239, 68, 68, 1)' }
                        }
                    }
                }
            }
        }
    </script>

    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🚨</text></svg>">
</head>

<body class="h-full bg-gradient-to-br from-red-100 via-orange-50 to-red-50 font-sans antialiased overflow-x-hidden"
      x-data="{
          isVisible: false,
          emergencyLevel: 'critical',
          serverVitals: {
              cpu: 95,
              memory: 87,
              disk: 92,
              network: 45
          },
          medicalTeamETA: 3,
          resuscitationProgress: 0,
          showEmergencyDetails: false,
          emergencyMessages: [
              '🚨 EMERGENZA: Il server ha avuto un collasso improvviso!',
              '⚕️ Équipe medica IT in arrivo per rianimazione!',
              '🏥 Il paziente-server è in sala operatoria virtuale!',
              '💊 Somministrando patches di emergenza...',
              '🔧 Defibrillatore digitale in preparazione!',
              '🩺 Monitoraggio vitals del sistema in corso...',
              '🚑 Ambulanza-backup in viaggio verso il datacenter!'
          ],
          currentMessage: '',
          messageIndex: 0,
          showEasterEgg: false,
          clickCount: 0,
          attemptingResuscitation: false
      }"
      x-init="
          setTimeout(() => { isVisible = true; }, 100);

          currentMessage = emergencyMessages[0];

          setInterval(() => {
              messageIndex = (messageIndex + 1) % emergencyMessages.length;
              currentMessage = emergencyMessages[messageIndex];
          }, 3500);

          setInterval(() => {
              if (medicalTeamETA > 0) medicalTeamETA--;
          }, 60000);

          setInterval(() => {
              serverVitals.cpu = Math.max(80, Math.min(99, serverVitals.cpu + (Math.random() - 0.5) * 10));
              serverVitals.memory = Math.max(70, Math.min(95, serverVitals.memory + (Math.random() - 0.5) * 8));
              serverVitals.disk = Math.max(85, Math.min(98, serverVitals.disk + (Math.random() - 0.5) * 6));
              serverVitals.network = Math.max(20, Math.min(70, serverVitals.network + (Math.random() - 0.5) * 15));
          }, 2000);
      ">

    {{-- Floating Emergency Elements --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-20 left-10 text-6xl opacity-20 animate-rescue-bounce text-red-500">🚨</div>
        <div class="absolute top-1/4 right-20 text-8xl opacity-15 animate-equipment-beep text-orange-500">⚕️</div>
        <div class="absolute bottom-1/4 left-1/4 text-5xl opacity-25 animate-heartbeat-critical text-red-400">💔</div>
        <div class="absolute top-1/2 right-1/4 text-4xl opacity-20 animate-defibrillator text-yellow-500">⚡</div>
        <div class="absolute bottom-20 right-10 text-7xl opacity-30 animate-rescue-bounce text-red-600">🏥</div>
        <div class="absolute top-40 left-1/2 text-5xl opacity-15 animate-equipment-beep text-orange-400">🔧</div>
        <div class="absolute bottom-1/3 right-1/3 text-3xl opacity-20 animate-heartbeat-critical text-red-400">🆘</div>
        <div class="absolute top-3/4 left-20 text-4xl opacity-25 animate-rescue-bounce text-yellow-500">🚑</div>
    </div>

    {{-- Animated Ambulance --}}
    <div class="fixed top-10 left-0 w-full pointer-events-none z-10">
        <div class="animate-ambulance-move text-4xl">🚑💨</div>
    </div>

    {{-- Main Content --}}
    <div class="relative z-10 min-h-full flex items-center justify-center p-4">
        <div class="max-w-4xl mx-auto text-center">

            {{-- Emergency Room Display --}}
            <div class="mb-12"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 transform translate-y-16 scale-95"
                 x-transition:enter-end="opacity-100 transform translate-y-0 scale-100">

                {{-- Medical Emergency Console --}}
                <div class="relative mb-8">
                    <div class="w-80 h-80 mx-auto relative">
                        {{-- Main Emergency Console --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl shadow-2xl border-4 border-red-500 animate-emergency-pulse">

                            {{-- Emergency Screen --}}
                            <div class="p-6 text-white">
                                {{-- Emergency Header --}}
                                <div class="flex items-center justify-between mb-4">
                                    <div class="text-red-400 font-bold text-xs">EMERGENZA MEDICA</div>
                                    <div class="flex space-x-1">
                                        <div class="w-2 h-2 bg-red-500 rounded-full animate-alarm-flash"></div>
                                        <div class="w-2 h-2 bg-red-500 rounded-full animate-alarm-flash" style="animation-delay: 0.2s"></div>
                                        <div class="w-2 h-2 bg-red-500 rounded-full animate-alarm-flash" style="animation-delay: 0.4s"></div>
                                    </div>
                                </div>

                                {{-- Patient Status --}}
                                <div class="text-center mb-6">
                                    <div class="text-lg font-bold text-red-400 mb-2">PAZIENTE: SERVER-001</div>
                                    <div class="text-2xl mb-4 cursor-pointer"
                                         @click="clickCount++; if(clickCount >= 5) showEasterEgg = true">💻❤️‍🩹</div>
                                    <div class="text-red-300 text-sm">STATUS: CRITICO</div>
                                </div>

                                {{-- Vital Signs Monitor --}}
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs">CPU:</span>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-16 h-2 bg-gray-600 rounded">
                                                <div class="h-2 bg-red-500 rounded animate-vital-signs" :style="`width: ${serverVitals.cpu}%`"></div>
                                            </div>
                                            <span class="text-xs text-red-400" x-text="serverVitals.cpu + '%'"></span>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="text-xs">RAM:</span>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-16 h-2 bg-gray-600 rounded">
                                                <div class="h-2 bg-orange-500 rounded animate-vital-signs" :style="`width: ${serverVitals.memory}%`"></div>
                                            </div>
                                            <span class="text-xs text-orange-400" x-text="serverVitals.memory + '%'"></span>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="text-xs">DISK:</span>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-16 h-2 bg-gray-600 rounded">
                                                <div class="h-2 bg-yellow-500 rounded animate-vital-signs" :style="`width: ${serverVitals.disk}%`"></div>
                                            </div>
                                            <span class="text-xs text-yellow-400" x-text="serverVitals.disk + '%'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Floating Medical Equipment --}}
                        <div class="absolute -top-6 -left-6 text-3xl animate-defibrillator">⚡</div>
                        <div class="absolute -top-6 -right-6 text-3xl animate-equipment-beep">🩺</div>
                        <div class="absolute -bottom-6 -left-6 text-3xl animate-heartbeat-critical">💊</div>
                        <div class="absolute -bottom-6 -right-6 text-3xl animate-rescue-bounce">🔧</div>
                    </div>
                </div>

                {{-- Error Code Display --}}
                <div class="mb-6">
                    <h1 class="text-8xl md:text-9xl font-bold bg-gradient-to-r from-red-600 via-orange-600 to-red-800 bg-clip-text text-transparent animate-emergency-pulse">
                        5💔0
                    </h1>
                    <div class="text-2xl md:text-3xl font-bold text-gray-700 mt-2">
                        EMERGENZA SERVER
                    </div>
                </div>

                {{-- Dynamic Emergency Message --}}
                <div class="mb-8 h-16 flex items-center justify-center">
                    <p class="text-xl md:text-2xl text-gray-700 max-w-3xl leading-relaxed font-medium"
                       x-text="currentMessage"
                       x-transition:enter="transition ease-out duration-500"
                       x-transition:enter-start="opacity-0 transform translate-y-4"
                       x-transition:enter-end="opacity-100 transform translate-y-0">
                    </p>
                </div>
            </div>

            {{-- Medical Team ETA --}}
            <div class="mb-12"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-300"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl p-6 shadow-xl border border-orange-400 max-w-lg mx-auto animate-emergency-pulse">
                    <div class="text-white text-center">
                        <div class="text-4xl mb-3 animate-rescue-bounce">🚑</div>
                        <h3 class="text-xl font-bold mb-2">Équipe di Emergenza IT</h3>
                        <p class="text-sm opacity-90 mb-4">ETA: <span x-text="medicalTeamETA + ' minuti'"></span></p>

                        <div class="text-3xl font-bold mb-4 animate-heartbeat-critical">⚕️</div>

                        <div class="text-sm opacity-90">
                            🩺 Dr. DevOps<br>
                            🔧 Ing. SysAdmin<br>
                            💊 Spec. Database
                        </div>
                    </div>
                </div>
            </div>

            {{-- Resuscitation Options --}}
            <div class="mb-12"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-500"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    ⚡ Protocolli di Rianimazione:
                </h2>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    {{-- Emergency Refresh --}}
                    <div class="group bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-2xl border border-gray-200 hover:border-red-300 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-4xl mb-3 group-hover:animate-defibrillator">⚡</div>
                        <h3 class="font-bold text-gray-800 mb-2">Defibrillazione</h3>
                        <p class="text-sm text-gray-600 mb-4">Shock elettrico per rianimare</p>
                        <button @click="window.location.reload()"
                                class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold rounded-full hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105">
                            ⚡ CLEAR!
                        </button>
                    </div>

                    {{-- Return Home --}}
                    <div class="group bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-2xl border border-gray-200 hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-4xl mb-3 group-hover:animate-rescue-bounce">🏥</div>
                        <h3 class="font-bold text-gray-800 mb-2">Trasferimento</h3>
                        <p class="text-sm text-gray-600 mb-4">Torna al reparto principale</p>
                        <a href="/"
                           class="block w-full px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-full hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 text-center">
                            🏠 Reparto Home
                        </a>
                    </div>

                    {{-- Emergency Contact --}}
                    <div class="group bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg hover:shadow-2xl border border-gray-200 hover:border-yellow-300 transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-4xl mb-3 group-hover:animate-heartbeat-critical">📞</div>
                        <h3 class="font-bold text-gray-800 mb-2">Chiamata 118</h3>
                        <p class="text-sm text-gray-600 mb-4">Contatta il supporto tecnico</p>
                        <a href="mailto:emergency@saluteora.it"
                           class="block w-full px-4 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-bold rounded-full hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 transform hover:scale-105 text-center">
                            🚨 SOS Tecnico
                        </a>
                    </div>
                </div>
            </div>

            {{-- Technical Diagnosis --}}
            <div class="mb-8"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-700"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <button @click="showEmergencyDetails = !showEmergencyDetails"
                        class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-full border border-gray-300 hover:border-gray-400 hover:bg-gray-200 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    📋 Cartella Clinica Server
                </button>

                <div x-show="showEmergencyDetails"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-gray-200 max-w-2xl mx-auto text-left">

                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                        <span class="text-2xl mr-3">🩺</span>
                        Diagnosi Tecnica Emergenza
                    </h4>

                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-start space-x-3">
                            <span class="text-red-500">🚨</span>
                            <div><strong>Condizione:</strong> Errore 500 - Internal Server Error</div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-orange-500">💔</span>
                            <div><strong>Sintomi:</strong> Server non risponde alle richieste</div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-yellow-500">⚠️</span>
                            <div><strong>Possibili Cause:</strong> Sovraccarico, bug nel codice, problemi database</div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-blue-500">💊</span>
                            <div><strong>Terapia:</strong> Il team IT sta intervenendo per la riparazione</div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-green-500">✅</span>
                            <div><strong>Prognosi:</strong> Guarigione completa prevista entro pochi minuti</div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-red-50 rounded-lg border border-red-200">
                        <div class="flex items-center space-x-2 text-red-700">
                            <span class="text-xl">🚨</span>
                            <span class="font-semibold">Protocollo di Emergenza Attivo</span>
                        </div>
                        <p class="text-sm text-red-600 mt-2">
                            Il nostro team di rianimazione digitale è intervenuto immediatamente.
                        </p>
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

                <div class="bg-white rounded-3xl p-8 max-w-md mx-4 text-center transform animate-heartbeat-critical"
                     @click.stop>
                    <div class="text-6xl mb-4 animate-defibrillator">⚡💻⚡</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Eroe della Rianimazione!</h3>
                    <p class="text-gray-600 mb-6">Hai salvato il server con le tue cure digitali! 💻❤️‍🩹<br>Sei ufficialmente un paramedico IT! 🚑💊</p>
                    <button @click="showEasterEgg = false"
                            class="px-6 py-3 bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold rounded-full hover:from-red-600 hover:to-orange-600 transition-all duration-300">
                        🏥 Missione Compiuta! 🏥
                    </button>
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="text-center text-gray-500 text-sm"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-900"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">

                <div class="flex items-center justify-center space-x-4 mb-4">
                    <span>🚨 Emergenza Attiva</span>
                    <span>•</span>
                    <span>💻 Errore 500</span>
                    <span>•</span>
                    <span>🦷 SaluteOra</span>
                </div>

                <p class="mb-2">
                    <strong>Segreto medico:</strong> Clicca 5 volte sul cuore del server per diventare un eroe! 💻❤️‍🩹
                </p>

                <div class="flex items-center justify-center space-x-2 text-xs">
                    <span>Emergenze gestite da</span>
                    <span class="animate-heartbeat-critical">🚑</span>
                    <span>SaluteOra Emergency Team</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Background Emergency Waves --}}
    <div class="fixed bottom-0 left-0 right-0 pointer-events-none z-0">
        <svg class="w-full h-32" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,60 C150,100 350,0 600,60 C850,120 1050,20 1200,60 L1200,120 L0,120 Z"
                  fill="rgba(239, 68, 68, 0.15)"
                  class="animate-emergency-pulse">
            </path>
            <path d="M0,80 C300,120 600,40 900,80 C1050,100 1150,60 1200,80 L1200,120 L0,120 Z"
                  fill="rgba(251, 146, 60, 0.1)"
                  class="animate-rescue-bounce">
            </path>
        </svg>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Emergency sound simulation (visual feedback)
            setInterval(() => {
                const alarms = document.querySelectorAll('[class*="alarm"]');
                alarms.forEach(alarm => {
                    alarm.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        alarm.style.transform = 'scale(1)';
                    }, 200);
                });
            }, 1500);

            // Mouse emergency trail
            document.addEventListener('mousemove', function(e) {
                if (Math.random() > 0.96) {
                    const emoji = ['🚨', '⚡', '💔', '🚑'][Math.floor(Math.random() * 4)];
                    const trail = document.createElement('div');
                    trail.textContent = emoji;
                    trail.style.cssText = `
                        position: fixed;
                        left: ${e.clientX}px;
                        top: ${e.clientY}px;
                        pointer-events: none;
                        z-index: 1000;
                        animation: emergencyFade 2s forwards;
                        font-size: 20px;
                    `;
                    document.body.appendChild(trail);
                    setTimeout(() => trail.remove(), 2000);
                }
            });

            // Add emergency fade animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes emergencyFade {
                    from { opacity: 1; transform: translateY(0px) scale(1); }
                    to { opacity: 0; transform: translateY(-50px) scale(1.5); }
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
