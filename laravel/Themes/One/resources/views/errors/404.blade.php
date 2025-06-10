{{--
/**
 * 404 Error Page - SaluteOra Medical Theme
 *
 * Pagina di errore 404 altamente coinvolgente con tema medico/odontoiatrico.
 * Design orientato al massimo engagement con animazioni fluide,
 * micro-interazioni e tono simpatico ma professionale.
 *
 * Features WOW:
 * - Animated medical mascot con emotional expressions
 * - Floating medical elements (stethoscope, teeth, pills)
 * - Interactive search suggestions con real-time filtering
 * - Emergency contact widget prominente
 * - Playful but professional medical puns e messaging
 * - Progressive disclosure per ridurre frustrazione
 * - Gamification elements (easter eggs, hover surprises)
 * - Responsive design con mobile-first approach
 * - Performance-optimized animations
 * - Accessibility-compliant interactions
 *
 * @param int $exception HTTP status code (404)
 * @param string $message Error message
 * @param bool $show_search_suggestions Show smart suggestions
 * @param bool $show_emergency_contact Show emergency widget
 */
--}}

<!DOCTYPE html>
<html lang="it" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oops! Pagina non trovata - SaluteOra</title>
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
                        'dance': 'dance 3s ease-in-out infinite'
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
                            '0%, 100%': { boxShadow: '0 0 20px rgba(20, 184, 166, 0.5)' },
                            '50%': { boxShadow: '0 0 40px rgba(20, 184, 166, 0.8)' }
                        },
                        shake: {
                            '0%, 100%': { transform: 'translateX(0)' },
                            '25%': { transform: 'translateX(-5px)' },
                            '75%': { transform: 'translateX(5px)' }
                        },
                        dance: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '25%': { transform: 'translateY(-5px) rotate(-2deg)' },
                            '50%': { transform: 'translateY(-10px) rotate(0deg)' },
                            '75%': { transform: 'translateY(-5px) rotate(2deg)' }
                        }
                    }
                }
            }
        }
    </script>

    {{-- Favicon medico --}}
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🦷</text></svg>">
</head>

<body class="h-full bg-gradient-to-br from-teal-50 via-blue-50 to-indigo-100 font-sans antialiased overflow-x-hidden"
      x-data="{
          isVisible: false,
          errorMood: 'curious',
          searchQuery: '',
          showEasterEgg: false,
          clickCount: 0,
          suggestions: [
              { text: '🏠 Torna alla Home', url: '/', icon: '🏠' },
              { text: '📞 Contatti e Prenotazioni', url: '/contatti', icon: '📞' },
              { text: '🦷 Servizi Odontoiatrici', url: '/servizi', icon: '🦷' },
              { text: '🤰 Odontoiatria in Gravidanza', url: '/gravidanza', icon: '🤰' },
              { text: '📋 Prenota una Visita', url: '/prenota', icon: '📋' },
              { text: '📚 Blog e Consigli', url: '/blog', icon: '📚' },
              { text: '❓ FAQ Frequenti', url: '/faq', icon: '❓' },
              { text: '🚨 Emergenze 24/7', url: 'tel:+39800123456', icon: '🚨' }
          ],
          filteredSuggestions: [],
          currentTime: '',
          funnyMessages: [
              'Questa pagina è andata dal dentista e non è ancora tornata! 🦷',
              'Errore 404: Pagina in sala d\'attesa infinita 🪑',
              'La pagina che cerchi ha preso un appuntamento... altrove! 📅',
              'Houston, abbiamo un problema... dentale! 🚀🦷',
              'Questa pagina si è persa nel labirinto delle gengive! 🌀',
              'Errore: Pagina sotto anestesia locale 💉',
              'La pagina è in quarantena per controllo igiene! 🧼'
          ],
          currentMessage: '',
          messageIndex: 0
      }"
      x-init="
          // Initialize visibility
          setTimeout(() => { isVisible = true; }, 100);

          // Update current time
          setInterval(() => {
              currentTime = new Date().toLocaleTimeString('it-IT', {
                  hour: '2-digit',
                  minute: '2-digit',
                  second: '2-digit'
              });
          }, 1000);

          // Initialize suggestions
          filteredSuggestions = suggestions;

          // Initialize funny message
          currentMessage = funnyMessages[0];

          // Rotate funny messages
          setInterval(() => {
              messageIndex = (messageIndex + 1) % funnyMessages.length;
              currentMessage = funnyMessages[messageIndex];
          }, 5000);
      "
      x-intersect="isVisible = true">

    {{-- Floating Medical Elements Background --}}
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        {{-- Floating Stethoscope --}}
        <div class="absolute top-20 left-10 text-6xl opacity-20 animate-float text-teal-400">
            🩺
        </div>

        {{-- Floating Teeth --}}
        <div class="absolute top-1/4 right-20 text-8xl opacity-15 animate-float-delayed text-blue-400">
            🦷
        </div>

        {{-- Floating Pills --}}
        <div class="absolute bottom-1/4 left-1/4 text-5xl opacity-25 animate-bounce-gentle text-green-400">
            💊
        </div>

        {{-- Floating Syringe --}}
        <div class="absolute top-1/2 right-1/4 text-4xl opacity-20 animate-float-slow text-purple-400">
            💉
        </div>

        {{-- Floating Heart --}}
        <div class="absolute bottom-20 right-10 text-7xl opacity-30 animate-heartbeat text-red-400">
            ❤️
        </div>

        {{-- Floating Medical Cross --}}
        <div class="absolute top-40 left-1/2 text-5xl opacity-15 animate-rotate-slow text-red-500">
            ➕
        </div>

        {{-- Additional Small Elements --}}
        <div class="absolute bottom-1/3 right-1/3 text-3xl opacity-20 animate-dance text-yellow-400">
            🌟
        </div>

        <div class="absolute top-3/4 left-20 text-4xl opacity-25 animate-wiggle text-pink-400">
            🏥
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

                {{-- Animated Medical Mascot --}}
                <div class="relative mb-8">
                    <div class="w-48 h-48 mx-auto relative">
                        {{-- Main Character (Animated Tooth) --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-9xl animate-bounce-gentle cursor-pointer transform transition-transform duration-300 hover:scale-110"
                                 @click="clickCount++; if(clickCount >= 5) showEasterEgg = true"
                                 :class="errorMood === 'curious' ? 'animate-bounce-gentle' :
                                         errorMood === 'sad' ? 'animate-wiggle' :
                                         'animate-dance'">
                                🦷
                            </div>

                            {{-- Character Eyes (Dynamic) --}}
                            <div class="absolute top-8 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                <div class="w-3 h-3 bg-black rounded-full animate-pulse"></div>
                                <div class="w-3 h-3 bg-black rounded-full animate-pulse"></div>
                            </div>

                            {{-- Character Expression --}}
                            <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2">
                                <div x-show="errorMood === 'curious'" class="text-2xl">🤔</div>
                                <div x-show="errorMood === 'sad'" class="text-2xl">😢</div>
                                <div x-show="errorMood === 'happy'" class="text-2xl">😊</div>
                            </div>
                        </div>

                        {{-- Floating Medical Tools around Character --}}
                        <div class="absolute -top-4 -left-4 text-2xl animate-float">🩺</div>
                        <div class="absolute -top-4 -right-4 text-2xl animate-float-delayed">💉</div>
                        <div class="absolute -bottom-4 -left-4 text-2xl animate-bounce-gentle">💊</div>
                        <div class="absolute -bottom-4 -right-4 text-2xl animate-wiggle">🧬</div>
                    </div>
                </div>

                {{-- Dynamic Error Code --}}
                <div class="mb-6">
                    <h1 class="text-8xl md:text-9xl font-bold bg-gradient-to-r from-teal-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent animate-pulse-glow">
                        4😵4
                    </h1>
                    <div class="text-2xl md:text-3xl font-bold text-gray-700 mt-2">
                        PAGINA IN CURA
                    </div>
                </div>

                {{-- Dynamic Funny Message --}}
                <div class="mb-8 h-16 flex items-center justify-center">
                    <p class="text-xl md:text-2xl text-gray-600 max-w-2xl leading-relaxed font-medium"
                       x-text="currentMessage"
                       x-transition:enter="transition ease-out duration-500"
                       x-transition:enter-start="opacity-0 transform translate-y-4"
                       x-transition:enter-end="opacity-100 transform translate-y-0">
                    </p>
                </div>
            </div>

            {{-- Interactive Search & Suggestions --}}
            <div class="mb-12 max-w-2xl mx-auto"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-300"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    🔍 Cosa stavi cercando?
                </h2>

                {{-- Search Input --}}
                <div class="relative mb-8">
                    <input type="text"
                           x-model="searchQuery"
                           @input="filteredSuggestions = suggestions.filter(s => s.text.toLowerCase().includes(searchQuery.toLowerCase()))"
                           placeholder="Cerca servizi, informazioni, contatti..."
                           class="w-full px-6 py-4 text-lg border-2 border-gray-300 rounded-2xl focus:border-teal-500 focus:ring-4 focus:ring-teal-200 transition-all duration-300 shadow-lg">

                    {{-- Search Icon --}}
                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Smart Suggestions Grid --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <template x-for="(suggestion, index) in filteredSuggestions.slice(0, 8)" :key="index">
                        <a :href="suggestion.url"
                           class="group relative bg-white/80 backdrop-blur-sm rounded-xl p-4 shadow-lg hover:shadow-2xl border border-gray-200 hover:border-teal-300 transition-all duration-300 transform hover:-translate-y-2 hover:scale-105">

                            {{-- Icon --}}
                            <div class="text-3xl mb-3 group-hover:animate-bounce" x-text="suggestion.icon"></div>

                            {{-- Text --}}
                            <div class="text-sm font-semibold text-gray-700 group-hover:text-teal-600 transition-colors duration-200"
                                 x-text="suggestion.text.replace(suggestion.icon, '').trim()"></div>

                            {{-- Hover Effect --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-teal-400/20 to-blue-400/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                    </template>
                </div>
            </div>

            {{-- Emergency Contact Widget --}}
            <div class="mb-12"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-500"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-2xl p-6 shadow-xl border border-red-400 max-w-lg mx-auto animate-pulse-glow">
                    <div class="flex items-center justify-center space-x-4 text-white">
                        <div class="text-3xl animate-heartbeat">🚨</div>
                        <div class="text-center">
                            <h3 class="text-xl font-bold mb-1">Emergenza Odontoiatrica?</h3>
                            <p class="text-sm opacity-90 mb-3">Siamo sempre qui per te</p>
                            <a href="tel:+39800123456"
                               class="inline-flex items-center px-6 py-3 bg-white text-red-600 font-bold rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                📞 Chiama Ora: 800 123 456
                            </a>
                        </div>
                        <div class="text-3xl animate-bounce-gentle">⚡</div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-8"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-700"
                 x-transition:enter-start="opacity-0 transform translate-y-16"
                 x-transition:enter-end="opacity-100 transform translate-y-0">

                {{-- Primary Action --}}
                <a href="/"
                   class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-600 to-blue-600 text-white font-bold rounded-full shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-6 h-6 mr-3 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    🏠 Torna alla Home
                </a>

                {{-- Secondary Action --}}
                <a href="/contatti"
                   class="group inline-flex items-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-full border-2 border-gray-300 hover:border-teal-500 hover:text-teal-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <svg class="w-6 h-6 mr-3 group-hover:animate-wiggle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    📞 Contattaci
                </a>
            </div>

            {{-- Easter Egg Modal --}}
            <div x-show="showEasterEgg"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50"
                 @click="showEasterEgg = false">

                <div class="bg-white rounded-3xl p-8 max-w-md mx-4 text-center transform animate-bounce-gentle"
                     @click.stop>
                    <div class="text-6xl mb-4 animate-dance">🎉</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Congratulazioni!</h3>
                    <p class="text-gray-600 mb-6">Hai trovato l'easter egg! Il dente ballerino ti ringrazia per la tua persistenza! 🦷💃</p>
                    <button @click="showEasterEgg = false"
                            class="px-6 py-3 bg-gradient-to-r from-teal-500 to-blue-500 text-white font-bold rounded-full hover:from-teal-600 hover:to-blue-600 transition-all duration-300">
                        Fantastico! 🎊
                    </button>
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="text-center text-gray-500 text-sm"
                 x-show="isVisible"
                 x-transition:enter="transition ease-out duration-1000 delay-1000"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">

                <div class="flex items-center justify-center space-x-4 mb-4">
                    <span>🕐 <span x-text="currentTime"></span></span>
                    <span>•</span>
                    <span>💻 Errore 404</span>
                    <span>•</span>
                    <span>🦷 SaluteOra</span>
                </div>

                <p class="mb-2">
                    <strong>Suggerimento pro:</strong> Prova a cliccare 5 volte sul dente per una sorpresa! 🎁
                </p>

                <div class="flex items-center justify-center space-x-2 text-xs">
                    <span>Pagina creata con</span>
                    <span class="animate-heartbeat">❤️</span>
                    <span>dal team SaluteOra</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Background Animated Waves --}}
    <div class="fixed bottom-0 left-0 right-0 pointer-events-none z-0">
        <svg class="w-full h-32" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,60 C150,100 350,0 600,60 C850,120 1050,20 1200,60 L1200,120 L0,120 Z"
                  fill="rgba(20, 184, 166, 0.1)"
                  class="animate-float">
            </path>
            <path d="M0,80 C300,120 600,40 900,80 C1050,100 1150,60 1200,80 L1200,120 L0,120 Z"
                  fill="rgba(59, 130, 246, 0.1)"
                  class="animate-float-delayed">
            </path>
        </svg>
    </div>

    {{-- Custom JavaScript for Enhanced Interactions --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Konami Code Easter Egg
            const konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'KeyB', 'KeyA'];
            let userInput = [];

            document.addEventListener('keydown', function(e) {
                userInput.push(e.code);
                userInput = userInput.slice(-konamiCode.length);

                if (userInput.join('') === konamiCode.join('')) {
                    // Activate super easter egg
                    document.body.style.filter = 'hue-rotate(180deg)';
                    setTimeout(() => {
                        document.body.style.filter = '';
                        alert('🎮 Konami Code attivato! Sei un vero gamer! 🎯');
                    }, 2000);
                }
            });

            // Mouse trail effect
            let mouseTrail = [];
            document.addEventListener('mousemove', function(e) {
                mouseTrail.push({x: e.clientX, y: e.clientY, time: Date.now()});
                mouseTrail = mouseTrail.filter(point => Date.now() - point.time < 1000);

                // Create medical emoji trail
                if (Math.random() > 0.95) {
                    const emoji = ['🦷', '💊', '🩺', '💉'][Math.floor(Math.random() * 4)];
                    const trail = document.createElement('div');
                    trail.textContent = emoji;
                    trail.style.cssText = `
                        position: fixed;
                        left: ${e.clientX}px;
                        top: ${e.clientY}px;
                        pointer-events: none;
                        z-index: 1000;
                        animation: fadeOut 2s forwards;
                        font-size: 20px;
                    `;
                    document.body.appendChild(trail);
                    setTimeout(() => trail.remove(), 2000);
                }
            });

            // Add fadeOut animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeOut {
                    from { opacity: 1; transform: translateY(0px); }
                    to { opacity: 0; transform: translateY(-50px); }
                }
            `;
            document.head.appendChild(style);

            // Performance optimization for animations
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            if (reduceMotion.matches) {
                document.documentElement.style.setProperty('--animation-duration', '0s');
            }
        });
    </script>
</body>
</html>
