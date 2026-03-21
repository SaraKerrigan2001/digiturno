@php
    $status = request()->get('status', isset($atencion) ? 'active' : 'idle');
    $isPause = $status == 'pause';
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'APE Advisor - Digital Queue Control')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        sena: { 50: '#e8f5e9', 100: '#c8e6c9', 500: '#39A900', 600: '#2d8700' },
                        amber: { 50: '#fff8e1', 100: '#ffecb3', 500: '#ffb300', 600: '#ffa000' }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f8fafc; font-family: 'Inter', sans-serif; }
        .sidebar-item { transition: all 0.3s ease; }
        .active-glow { box-shadow: 0 0 15px rgba(57, 169, 0, 0.2); }
    </style>
    @yield('styles')
</head>
<body class="h-screen overflow-hidden flex bg-[#F0F2F5]">

    <!-- Sidebar -->
    <aside class="w-72 bg-white flex flex-col border-r border-gray-100 shrink-0 z-30">
        <div class="px-8 py-10 flex flex-col space-y-4">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/Logo.png') }}" class="h-12 w-auto object-contain" alt="SENA Logo">
                <div class="h-8 w-px bg-gray-100 mx-2"></div>
                <div>
                    <h1 class="text-xl font-black text-gray-900 tracking-tight leading-none uppercase">SENA APE</h1>
                    <p class="text-[9px] font-bold text-sena-500 uppercase tracking-wider mt-1 leading-none">Sistema de Gestión de Turnos</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-2">
            <a href="{{ route('asesor.index') }}" class="sidebar-item flex items-center space-x-4 px-5 py-4 rounded-2xl {{ Request::routeIs('asesor.index') && !$isPause ? 'bg-sena-50 text-sena-500 font-bold active-glow' : 'text-gray-400 hover:bg-gray-50' }}">
                <i class="fa-solid fa-house-chimney text-lg"></i>
                <span class="text-sm">Dashboard</span>
            </a>
            <a href="{{ route('asesor.actividad') }}" class="sidebar-item flex items-center space-x-4 px-5 py-4 rounded-2xl {{ Request::routeIs('asesor.actividad') ? 'bg-sena-50 text-sena-500 font-bold active-glow' : 'text-gray-400 hover:bg-gray-50' }}">
                <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                <span class="text-sm">Actividad Reciente</span>
            </a>
            <a href="{{ route('asesor.tramites') }}" class="sidebar-item flex items-center space-x-4 px-5 py-4 rounded-2xl {{ Request::routeIs('asesor.tramites') ? 'bg-sena-50 text-sena-500 font-bold active-glow' : 'text-gray-400 hover:bg-gray-50' }}">
                <i class="fa-solid fa-file-invoice text-lg"></i>
                <span class="text-sm">Trámites</span>
            </a>
            <a href="{{ route('asesor.reportes') }}" class="sidebar-item flex items-center space-x-4 px-5 py-4 rounded-2xl {{ Request::routeIs('asesor.reportes') ? 'bg-sena-50 text-sena-500 font-bold active-glow' : 'text-gray-400 hover:bg-gray-50' }}">
                <i class="fa-solid fa-chart-simple text-lg"></i>
                <span class="text-sm">Reportes</span>
            </a>
        </nav>

        <div class="p-8 border-t border-gray-50 mt-auto">
            @if($isPause)
                <a href="{{ url('/asesor') }}" class="w-full flex items-center justify-center bg-amber-500 text-white font-black py-4 rounded-full shadow-lg shadow-amber-500/30 hover:bg-amber-600 transition-all hover:scale-105 active:scale-95 space-x-3 text-xs uppercase tracking-widest mb-6">
                    <i class="fa-solid fa-play"></i>
                    <span>Reanudar Atención</span>
                </a>
            @else
                <a href="{{ url('/asesor?status=pause') }}" class="w-full flex items-center justify-center border-2 border-amber-500 text-amber-500 font-black py-4 rounded-full hover:bg-amber-50 transition-all hover:scale-105 active:scale-95 space-x-3 text-xs uppercase tracking-widest mb-6 px-2">
                    <i class="fa-solid fa-pause"></i>
                    <span>Pausa / Receso</span>
                </a>
            @endif

            <a href="{{ route('asesor.configuracion') }}" class="flex items-center space-x-4 px-5 py-3 rounded-xl text-gray-400 hover:text-gray-900 transition-colors mb-4">
                <i class="fa-solid fa-gear"></i>
                <span class="text-sm font-bold">Configuración</span>
            </a>

            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-[2rem] border border-gray-100">
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($asesor->persona->pers_nombres ?? 'Carlos Ruiz') }}&background=39A900&color=fff&bold=true" class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="Profile">
                    <div>
                        <p class="text-[11px] font-black text-gray-900 leading-tight">{{ explode(' ', $asesor->persona->pers_nombres ?? 'Carlos Ruiz')[0] }}</p>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Módulo {{ $asesor->modulo ?? '04' }}</p>
                    </div>
                </div>
                <button class="text-gray-300 hover:text-red-500 px-2 transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </div>
        </div>
    </aside>

    <!-- Main Section -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-24 px-10 flex items-center justify-between border-b border-gray-100 bg-white/80 backdrop-blur-md z-20 sticky top-0">
            <div class="flex items-center space-x-2">
                <span class="text-gray-400 font-medium text-sm">Agencia Pública de Empleo</span>
                <span class="text-gray-200">|</span>
                <span class="text-gray-400 font-medium text-sm">SENA Regional</span>
            </div>

            <div class="flex items-center space-x-8">
                <div class="flex items-center space-x-2 bg-emerald-50 px-4 py-2 rounded-full border border-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-black text-emerald-600 uppercase tracking-widest">En Línea</span>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-gray-900 hover:bg-gray-50 rounded-full transition relative">
                        <i class="fa-solid fa-bell"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-10 bg-gray-50/30">
            <div class="max-w-[1400px] mx-auto">
                @yield('content')
            </div>
        </div>

        <!-- Footer status bar -->
        <footer class="h-10 bg-white border-t border-gray-100 px-10 flex items-center justify-between z-20 shrink-0">
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full {{ $isPause ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                    <span class="text-[9px] font-black text-gray-500 uppercase tracking-[0.2em]">Estado: {{ $isPause ? 'Pausa' : 'Atendiendo' }}</span>
                </div>
                <div class="text-[9px] font-bold text-gray-400">Último ciudadano atendido: 10:42 AM</div>
            </div>
            <div class="flex items-center space-x-6">
                <div class="flex items-center space-x-2 text-gray-400">
                    <i class="fa-solid fa-wifi text-[10px]"></i>
                    <span class="text-[9px] font-bold">Sincronizado</span>
                </div>
                <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest">{{ $isPause ? 'v1.4.0-PAUSE' : 'v4.5.0-LIVE' }}</span>
            </div>
        </footer>
    </main>

    <script>
        function updateHeaderClock() {
            // ... (implementación si es necesaria)
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
