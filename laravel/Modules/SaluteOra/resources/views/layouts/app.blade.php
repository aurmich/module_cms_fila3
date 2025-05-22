<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Registrazione Completata</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .floating-shape {
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        
        .pulse-button {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Background SVG animations -->
    <div class="fixed inset-0 z-0 overflow-hidden">
        <svg class="absolute top-0 left-0 w-full h-full opacity-5" viewBox="0 0 100 100" preserveAspectRatio="none">
            <!-- Stylized shapes -->
            <path class="floating-shape" d="M20,20 Q25,15 30,20 Q35,25 30,30 Q25,35 20,30 Q15,25 20,20" fill="#0047AB" style="animation-delay: 0s;"></path>
            <path class="floating-shape" d="M70,30 Q75,25 80,30 Q85,35 80,40 Q75,45 70,40 Q65,35 70,30" fill="#0047AB" style="animation-delay: 1.5s;"></path>
            <path class="floating-shape" d="M30,60 Q35,55 40,60 Q45,65 40,70 Q35,75 30,70 Q25,65 30,60" fill="#0047AB" style="animation-delay: 2.5s;"></path>
        </svg>
    </div>

    @yield('content')
</body>
</html>
