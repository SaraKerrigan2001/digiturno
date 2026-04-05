<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Asesor - SENA APE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
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
                            50: '#f0f0ff', 
                            100: '#e1e1ff', 
                            500: '#10069F', 
                            600: '#0c047a' 
                        } 
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.3)',
                        'soft': '0 10px 25px -5px rgba(16, 6, 159, 0.1), 0 8px 10px -6px rgba(16, 6, 159, 0.1)',
                    }
                }
            }
        }
    </script>
    <style>
        .split-bg {
            background-image: url("{{ asset('images/fondo.jpg') }}");
            background-size: cover;
            background-position: center;
        }
        .fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
        .slide-up { animation: slideUp 0.6s ease-out forwards; opacity: 0; transform: translateY(20px); }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        @keyframes fadeIn { to { opacity: 1; } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        
        /* Glassmorphism utility */
        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans overflow-hidden antialiased">

    <div class="flex min-h-screen">
        
        <!-- Left Side: Immersive Brand Side -->
        <div class="hidden lg:flex lg:w-[55%] split-bg relative items-center justify-center p-12">
            <!-- Elegant Neutral/White Overlay -->
            <div class="absolute inset-0 bg-white/30 backdrop-blur-sm"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-black/40 via-transparent to-black/20"></div>
            
            <div class="relative z-10 w-full max-w-lg text-center slide-up">
                <!-- Premium White Glassmorphism Card -->
                <div class="glass-panel bg-white/40 border-white/40 p-10 rounded-3xl shadow-[0_8px_32px_0_rgba(0,0,0,0.1)] transition-transform duration-500 hover:scale-[1.02] backdrop-blur-xl">
                    <div class="bg-white p-4 rounded-2xl w-24 h-24 mx-auto mb-6 flex items-center justify-center shadow-xl">
                        <img src="{{ asset('images/logo.jpeg') }}" class="w-full h-auto" alt="SENA Logo">
                    </div>
                    
                    <h2 class="text-3xl lg:text-4xl font-poppins font-bold text-gray-900 leading-tight mb-4 tracking-tight drop-shadow-sm">
                        Agencia Pública de Empleo
                    </h2>
                    
                    <p class="text-gray-800 text-base lg:text-lg font-medium leading-relaxed opacity-90 mx-auto max-w-md">
                        Plataforma institucional para la gestión y coordinación eficiente de la atención ciudadana.
                    </p>
                </div>
                
                <div class="mt-8 flex items-center justify-center space-x-4 fade-in delay-200">
                    <div class="px-4 py-1.5 bg-white/60 backdrop-blur-md rounded-full text-gray-800 text-[10px] font-bold tracking-widest uppercase shadow-sm">
                        v4.5.0 Stable
                    </div>
                    <div class="px-4 py-1.5 bg-white/60 backdrop-blur-md rounded-full text-gray-800 text-[10px] font-bold tracking-widest uppercase flex items-center shadow-sm">
                        <span class="w-1.5 h-1.5 bg-sena-blue rounded-full mr-2 shadow-[0_0_8px_#10069F] animate-pulse"></span>
                        Servidor Activo
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Clean Focus Login -->
        <div class="w-full lg:w-[45%] flex flex-col bg-white border-l border-gray-100 shadow-2xl z-20">
            <div class="flex-1 flex flex-col items-center justify-center px-8 sm:px-16 py-12">
                
                <div class="w-full max-w-[380px] slide-up delay-100">
                    
                    <!-- Mobile Logo -->
                    <div class="lg:hidden text-center mb-8">
                        <div class="w-16 h-16 bg-white border border-gray-100 shadow-sm rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <img src="{{ asset('images/logoSena.png') }}" class="h-8 w-auto" alt="SENA Logo">
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="mb-10 text-center lg:text-left">
                        <h1 class="text-3xl font-poppins font-bold text-[#111827] tracking-tight mb-2">Iniciar Sesión</h1>
                        <p class="text-gray-500 text-sm font-medium">Ingrese sus credenciales de funcionario.</p>
                    </div>

                    @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-start space-x-3 text-red-700 mb-8 fade-in">
                        <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ url('/asesor/login') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <!-- Input Documento -->
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">
                                Documento de Identidad
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-id-card text-lg"></i>
                                </div>
                                <input type="text" name="pers_doc" value="{{ old('pers_doc') }}" required
                                    class="w-full pl-12 pr-4 py-3.5 bg-[#EEF2F6] border-none rounded-xl text-gray-900 focus:ring-2 focus:ring-sena-500/50 outline-none transition-all duration-300 placeholder:text-gray-400 font-semibold"
                                    placeholder="12345678">
                            </div>
                        </div>

                        <!-- Input Contraseña -->
                        <div class="space-y-1">
                            <div class="flex justify-between items-center mb-1">
                                <label class="text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">
                                    Contraseña
                                </label>
                                <a href="{{ url('/asesor/recuperar-clave') }}" class="text-[11px] font-bold text-sena-blue hover:text-sena-blue/80 transition-colors">
                                    ¿Olvidó su clave?
                                </a>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-lock text-lg"></i>
                                </div>
                                <input type="password" name="password" required
                                    class="w-full pl-12 pr-4 py-3.5 bg-[#EEF2F6] border-none rounded-xl text-gray-900 focus:ring-2 focus:ring-sena-500/50 outline-none transition-all duration-300 placeholder:text-gray-500 font-bold"
                                    placeholder="••••••">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" 
                                class="w-full bg-sena-blue hover:bg-sena-blue/90 text-white font-bold py-3.5 rounded-xl shadow-md hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 flex items-center justify-center space-x-2">
                                <span>Ingresar al Sistema</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Enlaces Adicionales de Navegación -->
                    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                        <a href="{{ url('/') }}" class="flex items-center space-x-2 text-xs font-bold text-gray-400 hover:text-sena-blue transition-colors">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Volver al Kiosco</span>
                        </a>
                        <a href="{{ route('coordinador.login') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors">
                            Login Coordinador →
                        </a>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="p-8 text-center bg-gray-50/50 mt-auto border-t border-gray-100">
                <p class="text-[11px] font-medium text-gray-400 uppercase tracking-widest leading-relaxed">
                    SENA &copy; 2026<br>
                    <span class="text-gray-300">Agencia Pública de Empleo</span>
                </p>
            </div>
        </div>
    </div>

    <style>
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
    </style>
</body>
</html>
