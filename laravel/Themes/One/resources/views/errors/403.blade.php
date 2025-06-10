<!DOCTYPE html>
<html lang="it" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesso Negato - SaluteOra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.1/dist/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Animazioni personalizzate */
        .lock-wiggle {
            animation: wiggle 2.5s infinite;
        }
        
        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            10% { transform: rotate(10deg); }
            20% { transform: rotate(-8deg); }
            30% { transform: rotate(6deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(0deg); }
        }
        
        /* Pill animation */
        .pill-float {
            animation: float 5s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        
        /* Stethoscope animation */
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
        
        @keyframes pulse-ring {
            0% { transform: scale(.95); opacity: 0.7; }
            50% { transform: scale(1); opacity: 1; }
            100% { transform: scale(.95); opacity: 0.7; }
        }
        
        /* Wave effect */
        .wave {
            position: absolute;
            opacity: 0.5;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform-origin: center;
            animation: wave 3s infinite ease-out;
        }
        
        @keyframes wave {
            0% { transform: scale(0); opacity: 1; }
            70% { transform: scale(3); opacity: 0.3; }
            100% { transform: scale(4); opacity: 0; }
        }
        
        /* Gradient background animation */
        .gradient-bg {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Mobile safe area */
        @supports (padding: max(0px)) {
            body {
                padding-left: min(0vmin, env(safe-area-inset-left));
                padding-right: min(0vmin, env(safe-area-inset-right));
                padding-bottom: min(0vmin, env(safe-area-inset-bottom));
            }
        }
    </style>
</head>
<body class="h-full bg-gradient-to-br from-blue-50 to-teal-50 overflow-x-hidden">
    <div 
        x-data="error403()"
        x-init="init()"
        class="min-h-full flex flex-col items-center justify-center px-4 py-12 relative"
    >
        <!-- Elementi decorativi di sfondo -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Pills floating -->
            <div class="absolute top-1/4 left-1/5 pill-float delay-100">
                <div class="w-12 h-6 bg-blue-400 rounded-full opacity-20"></div>
            </div>
            <div class="absolute bottom-1/3 right-1/4 pill-float delay-300">
                <div class="w-8 h-4 bg-teal-400 rounded-full opacity-25"></div>
            </div>
            <div class="absolute top-1/3 right-1/5 pill-float delay-500">
                <div class="w-10 h-5 bg-rose-400 rounded-full opacity-20"></div>
            </div>
            
            <!-- Medical instruments silhouettes -->
            <div class="absolute bottom-1/4 left-1/6">
                <svg class="w-16 h-16 text-blue-200 opacity-20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10V3M8 10a2 2 0 104 0M8 10H4m8 0h4M3 21h18M12 3v7"></path>
                </svg>
            </div>
            <div class="absolute top-1/5 right-1/6">
                <svg class="w-16 h-16 text-teal-200 opacity-20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                </svg>
            </div>
        </div>
        
        <div class="max-w-3xl mx-auto text-center relative z-10">
            <!-- Icon animato -->
            <div class="mb-8 relative">
                <!-- Circle animation effect -->
                <div class="absolute inset-0 mx-auto pulse-ring">
                    <div class="w-32 h-32 mx-auto rounded-full bg-red-500/10"></div>
                </div>
                
                <div 
                    x-show="showElements.icon"
                    x-transition:enter="transition ease-out duration-500 transform"
                    x-transition:enter-start="opacity-0 scale-75"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="w-32 h-32 mx-auto rounded-full flex items-center justify-center bg-gradient-to-br from-red-500 to-red-600 text-white shadow-xl">
                    <div class="lock-wiggle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
                
                <!-- Wave effects -->
                <div class="wave absolute inset-0 mx-auto w-32 h-32 rounded-full"></div>
                <div class="wave absolute inset-0 mx-auto w-32 h-32 rounded-full" style="animation-delay: 1s"></div>
                <div class="wave absolute inset-0 mx-auto w-32 h-32 rounded-full" style="animation-delay: 2s"></div>
            </div>
            
            <!-- Titolo animato -->
            <div 
                x-show="showElements.title"
                x-transition:enter="transition ease-out duration-500 delay-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mb-6">
                <h1 class="text-5xl sm:text-7xl font-bold text-gray-900">
                    <span class="inline-block">4</span>
                    <span class="inline-block mx-2 relative">
                        <span class="relative z-10">0</span>
                        <svg class="absolute -top-1 -right-1 w-5 h-5 text-red-500 animate-pulse" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </span>
                    <span class="inline-block">3</span>
                </h1>
                <h2 class="text-2xl sm:text-3xl font-medium text-gray-700 mt-2">Accesso Negato</h2>
            </div>
            
            <!-- Messaggio animato -->
            <div 
                x-show="showElements.message"
                x-transition:enter="transition ease-out duration-500 delay-500 transform"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mb-10">
                <p class="text-lg text-gray-600 max-w-lg mx-auto">
                    {{ $exception->getMessage() ?: 'Ci dispiace! Non hai i permessi necessari per accedere a questa pagina.' }}
                </p>
            </div>
            
            <!-- Card informativa animata -->
            <div 
                x-show="showElements.info"
                x-transition:enter="transition ease-out duration-500 delay-700 transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="mb-12">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl border border-teal-100">
                    <h3 class="text-xl font-medium text-gray-800 mb-4 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Hai bisogno di aiuto?
                    </h3>
                    <p class="text-gray-600 mb-6">Questa restrizione potrebbe essere dovuta a:</p>
                    <ul class="space-y-3 text-left text-gray-600 max-w-md mx-auto">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Non sei registrato o non hai effettuato l'accesso al sistema</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Il tuo account non dispone dei permessi necessari</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>La tua sessione è scaduta (prova ad accedere nuovamente)</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Pulsanti principali -->
            <div 
                x-show="showElements.buttons"
                x-transition:enter="transition ease-out duration-500 delay-900 transform"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-4 sm:space-y-0 sm:space-x-4 flex flex-col sm:flex-row justify-center items-center">
                <a 
                    href="/"
                    class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-500 to-teal-500 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Torna alla Home
                </a>
                <a 
                    href="/login"
                    class="w-full sm:w-auto px-8 py-3 bg-white text-blue-600 font-medium rounded-lg shadow-md hover:shadow-lg border border-gray-200 transform transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Accedi
                </a>
                <a 
                    href="/contatti"
                    class="w-full sm:w-auto px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg shadow-md hover:shadow-lg border border-gray-200 transform transition-all duration-200 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contattaci
                </a>
            </div>
        </div>
    </div>

    <script>
        function error403() {
            return {
                showElements: {
                    icon: false,
                    title: false,
                    message: false,
                    info: false,
                    buttons: false,
                },
                init() {
                    this.animateElements();
                    this.initParticles();
                },
                animateElements() {
                    // Animazione sequenziale degli elementi
                    setTimeout(() => this.showElements.icon = true, 100);
                    setTimeout(() => this.showElements.title = true, 600);
                    setTimeout(() => this.showElements.message = true, 900);
                    setTimeout(() => this.showElements.info = true, 1200);
                    setTimeout(() => this.showElements.buttons = true, 1500);
                },
                initParticles() {
                    // Con GSAP possiamo aggiungere animazioni più complesse
                    if(typeof gsap !== 'undefined') {
                        gsap.to('.heartbeat', {
                            scale: 1.1,
                            repeat: -1,
                            yoyo: true,
                            duration: 0.8,
                            ease: "power1.inOut"
                        });
                    }
                }
            }
        }
    </script>
</body>
</html>
