<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinador - APE SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif']
                    },
                    colors: {
                        sena: { 
                            yellow: '#FFB500',
                            blue: '#10069F',
                            orange: '#FF671F',
                            400: '#3b82f6', 
                            500: '#10069F', 
                            600: '#0c047a', 
                            50: '#f0f0ff' 
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .bg-fondo {
            background-image: url("{{ asset('images/fondo.jpg') }}");
            background-size: cover;
            background-position: center;
        }
        .fade-in { animation: fadeInUp 0.7s ease-out both; }
        .fade-in-delay { animation: fadeInUp 0.7s ease-out 0.15s both; }
        .fade-in-delay-2 { animation: fadeInUp 0.7s ease-out 0.3s both; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .orb-1 { animation: float1 8s ease-in-out infinite; }
        .orb-2 { animation: float2 10s ease-in-out infinite; }
        @keyframes float1 { 0%,100%{ transform: translate(0,0) scale(1); } 50%{ transform: translate(30px,-20px) scale(1.05); } }
        @keyframes float2 { 0%,100%{ transform: translate(0,0) scale(1); } 50%{ transform: translate(-20px,25px) scale(1.08); } }
    </style>
</head>
<body class="min-h-screen flex overflow-hidden font-sans">

    {{-- Left Panel: Immersive Brand Side --}}
    <div class="hidden lg:flex lg:w-[58%] relative overflow-hidden bg-fondo items-center justify-center p-12">
        {{-- Elegant Neutral/White Overlay --}}
        <div class="absolute inset-0 bg-white/30 backdrop-blur-sm"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-black/40 via-transparent to-black/20"></div>

        <div class="relative z-10 w-full max-w-lg text-center fade-in">
            {{-- Premium White Glassmorphism Card --}}
            <div class="bg-white/40 border border-white/40 p-10 rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.1)] transition-transform duration-500 hover:scale-[1.02] backdrop-blur-xl">
                <div class="bg-white p-4 rounded-2xl w-24 h-24 mx-auto mb-6 flex items-center justify-center shadow-xl">
                    <img src="{{ asset('images/logo.jpeg') }}" class="w-full h-auto" alt="SENA Logo">
                </div>
                
                {{-- Panel Badge --}}
                <div class="inline-flex items-center space-x-2 bg-white/80 border border-sena-100 shadow-sm backdrop-blur-md rounded-full px-4 py-2 mb-6 mx-auto">
                    <div class="flex items-center justify-center w-5 h-5 bg-sena-50 rounded-full">
                        <div class="w-2 h-2 bg-sena-blue rounded-full animate-pulse shadow-[0_0_8px_#10069F]"></div>
                    </div>
                    <span class="text-sena-blue text-[10px] font-bold uppercase tracking-widest">Panel de Coordinación</span>
                </div>

                <h2 class="text-3xl lg:text-4xl font-poppins font-black text-gray-900 leading-tight mb-4 tracking-tight drop-shadow-sm">
                    Control <span class="text-sena-blue">Operativo</span><br>Institucional
                </h2>
                
                <p class="text-gray-800 text-base lg:text-lg font-medium leading-relaxed opacity-90 mx-auto max-w-md">
                    Administra los módulos de atención, genera reportes en tiempo real y gestiona el personal de la sede desde un solo lugar.
                </p>
            </div>
            
            <div class="mt-8 flex items-center justify-center space-x-4 fade-in-delay-2">
                <div class="px-4 py-1.5 bg-white/60 backdrop-blur-md rounded-full text-gray-800 text-[10px] font-bold tracking-widest uppercase shadow-sm">
                    v4.9 Stable
                </div>
                <div class="px-4 py-1.5 bg-white/60 backdrop-blur-md rounded-full text-gray-800 text-[10px] font-bold tracking-widest uppercase flex items-center shadow-sm">
                    <span class="w-1.5 h-1.5 bg-sena-blue rounded-full mr-2 shadow-[0_0_8px_#10069F] animate-pulse"></span>
                    Servidor Activo
                </div>
            </div>
        </div>
    </div>

    {{-- Right Panel: Login Form --}}
    <div class="w-full lg:w-[42%] bg-white flex items-center justify-center px-8 sm:px-14 lg:px-16 py-12 relative">

        {{-- Subtle decorative circle --}}
        <div class="absolute top-0 right-0 w-48 h-48 bg-sena-50 rounded-bl-[80px] opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-sena-50 rounded-tr-[60px] opacity-40 pointer-events-none"></div>

        <div class="w-full max-w-sm relative z-10 fade-in-delay">

            {{-- Mobile Logo --}}
            <div class="flex justify-center mb-8 lg:hidden">
                <img src="{{ asset('images/logoSena.png') }}" alt="SENA" class="h-14 w-auto object-contain">
            </div>

            {{-- Header --}}
            <div class="mb-10">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-sena-blue rounded-xl flex items-center justify-center text-white shadow-lg shadow-sena-blue/25">
                        <i class="fa-solid fa-user-tie text-sm"></i>
                    </div>
                    <div class="w-6 h-px bg-gray-200"></div>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Acceso Exclusivo</span>
                </div>
                <h2 class="text-3xl font-poppins font-black text-gray-900 tracking-tight mb-2">Bienvenido</h2>
                <p class="text-sm font-medium text-gray-400 leading-relaxed">Ingresa tus credenciales para acceder al panel de coordinación APE SENA.</p>
            </div>

            {{-- Error --}}
            @if(session('error'))
            <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-2xl mb-6 flex items-center space-x-3 text-sm font-medium fade-in">
                <i class="fa-solid fa-circle-exclamation text-red-400 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-sena-50 border border-sena-100 text-sena-600 px-4 py-3 rounded-2xl mb-6 flex items-center space-x-3 text-sm font-medium fade-in">
                <i class="fa-solid fa-circle-check text-sena-500 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('coordinador.login') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Correo Electrónico</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-300 group-focus-within:text-sena-500 transition-colors">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-gray-50 border border-gray-200 text-gray-800 placeholder-gray-400 rounded-2xl pl-11 pr-4 py-3.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-blue focus:border-transparent focus:bg-white transition-all"
                            placeholder="correo@sena.edu.co">
                    </div>
                    @error('email')<p class="text-red-500 text-[11px] font-medium ml-1 mt-1">{{ $message }}</p>@enderror
                </div>

                {{-- Password --}}
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-widest ml-1">Contraseña</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-300 group-focus-within:text-sena-500 transition-colors">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" name="password" id="coordPassInput" required
                            class="w-full bg-gray-50 border border-gray-200 text-gray-800 placeholder-gray-400 rounded-2xl pl-11 pr-11 py-3.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-blue focus:border-transparent focus:bg-white transition-all"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePass()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-300 hover:text-gray-500 transition-colors">
                            <i class="fa-solid fa-eye text-sm" id="passEyeIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-3">
                    <button type="submit" class="w-full bg-gradient-to-r from-sena-blue to-sena-blue/80 hover:from-sena-blue/90 hover:to-sena-blue text-white font-black py-4 rounded-2xl shadow-lg shadow-sena-blue/25 hover:shadow-sena-blue/40 transform hover:-translate-y-0.5 active:translate-y-0 transition-all uppercase tracking-[0.15em] text-xs flex items-center justify-center space-x-3">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Ingresar al Sistema</span>
                    </button>
                </div>
            </form>

            {{-- Footer --}}
            <div class="mt-10 pt-8 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center space-x-2 text-xs font-bold text-gray-400 hover:text-sena-blue transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Volver al Kiosco</span>
                </a>
                <a href="{{ route('asesor.login') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors">
                    Login Asesor →
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePass() {
            const input = document.getElementById('coordPassInput');
            const icon = document.getElementById('passEyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
