<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Coordinador - DigiTurno</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { brand: { 50: '#f8fafc', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 900: '#0c4a6e' } } }
            }
        }
    </script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans h-screen flex overflow-hidden">

    <!-- Sidebar Coordinador -->
    <aside class="w-64 bg-slate-800 text-white flex flex-col hidden md:flex shrink-0">
        <div class="h-16 flex items-center justify-center border-b border-slate-700 bg-slate-900">
            <h1 class="text-xl font-bold tracking-wide text-white"><i class="fa-solid fa-chart-line text-brand-500 mr-2"></i>Coordinación</h1>
        </div>
        <div class="p-6 pb-2 border-b border-slate-700">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-12 h-12 rounded-full bg-slate-700 flex items-center justify-center font-bold text-xl border-2 border-brand-500">C</div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-white truncate">Carlos Coord.</p>
                    <p class="text-xs text-brand-400 font-semibold tracking-wider">SUPERVISOR</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 overflow-y-auto py-4 space-y-1">
            <a href="#" class="flex items-center px-6 py-3 bg-brand-600 text-white border-l-4 border-white shadow-inner"><i class="fa-solid fa-gauge-high w-5 mr-3"></i>Dashboard</a>
            <a href="#" class="flex items-center px-6 py-3 text-slate-300 hover:bg-slate-700 hover:text-white transition"><i class="fa-solid fa-users w-5 mr-3"></i>Gestión de Asesores</a>
            <a href="#" class="flex items-center px-6 py-3 text-slate-300 hover:bg-slate-700 hover:text-white transition"><i class="fa-solid fa-clock-rotate-left w-5 mr-3"></i>Historial Atenciones</a>
            <a href="#" class="flex items-center px-6 py-3 text-slate-300 hover:bg-slate-700 hover:text-white transition"><i class="fa-solid fa-file-contract w-5 mr-3"></i>Reportes PDF/Excel</a>
        </nav>
        <div class="p-4 bg-slate-900">
            <a href="login.php" class="flex items-center justify-center px-4 py-3 bg-slate-800 text-red-400 hover:bg-red-500 hover:text-white rounded-lg font-medium transition duration-200">
                <i class="fa-solid fa-power-off mr-2"></i> Cerrar Sesión
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full relative overflow-y-auto bg-gray-100">
        <!-- Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800">Estadísticas en Tiempo Real</h2>
            <div class="flex items-center space-x-6 text-slate-600">
                <button class="hover:text-brand-600 transition relative">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
                </button>
            </div>
        </header>

        <!-- Contenido -->
        <div class="p-8 max-w-7xl mx-auto w-full space-y-8">
            
            <!-- INFO: 
               Las métricas deben calcularse basándose en la tabla 'atencion':
               - Turnos Hoy: COUNT(atnc_id) filtrando por el día actual.
               - Tiempo Prom.: Promedio de la diferencia entre atnc_hora_fin y atnc_hora_inicio.
            -->
            <!-- KPIs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- KPI 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Turnos Hoy</p>
                        <h3 class="text-3xl font-black text-slate-800">{{ $metricas['turnosHoy'] ?? 0 }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner"><i class="fa-solid fa-users"></i></div>
                </div>
                <!-- KPI 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">En Espera</p>
                        <h3 class="text-3xl font-black text-orange-600">{{ $metricas['enEspera'] ?? 0 }}</h3>
                    </div>
                    <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner"><i class="fa-solid fa-hourglass-half"></i></div>
                </div>
                <!-- KPI 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Tiempo Prom.</p>
                        <h3 class="text-3xl font-black text-green-600">{{ $metricas['tiempoPromedio'] ?? '00' }}<span class="text-xl text-green-500 font-bold">m</span></h3>
                    </div>
                    <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner"><i class="fa-solid fa-stopwatch"></i></div>
                </div>
                <!-- KPI 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Asesores On</p>
                        <h3 class="text-3xl font-black text-purple-600">{{ $metricas['asesoresOn'] ?? 0 }}<span class="text-xl text-gray-400 font-medium ml-1">/ {{ $metricas['totalAsesores'] ?? 0 }}</span></h3>
                    </div>
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner"><i class="fa-solid fa-headset"></i></div>
                </div>
            </div>

            <!-- Monitoreo de Módulos (Grid) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Monitoreo de Módulos de Atención</h3>
                    <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-50 focus:outline-none transition"><i class="fa-solid fa-rotate-right mr-2"></i>Actualizar</button>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        @forelse($modulosAtencion ?? [] as $mod)
                        <!-- Módulo -->
                        <div class="border {{ $mod['estado'] == 'Activo' ? 'border-green-200 bg-white' : 'border-gray-200 bg-gray-50 opacity-80' }} rounded-xl p-5 shadow-sm relative overflow-hidden">
                            @if($mod['estado'] == 'Activo')
                            <div class="absolute top-0 right-0 p-3">
                                <span class="flex h-3 w-3 relative"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span></span>
                            </div>
                            @else
                            <div class="absolute top-0 right-0 p-3">
                                <span class="flex h-3 w-3 relative rounded-full bg-gray-400"></span>
                            </div>
                            @endif

                            <div class="text-sm font-bold text-gray-400 mb-1 uppercase tracking-wider">Módulo {{ $mod['nro_modulo'] }}</div>
                            <h4 class="text-xl font-bold {{ $mod['estado'] == 'Activo' ? 'text-slate-800' : 'text-slate-600' }} mb-4 border-b pb-2">{{ $mod['asesor_nombre'] }}</h4>
                            
                            @if($mod['estado'] == 'Activo')
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 font-semibold uppercase">Atendiendo</p>
                                    <p class="text-3xl font-black {{ $mod['tur_tipo'] == 'Prioritario' ? 'text-orange-600' : ($mod['tur_tipo'] == 'Victimas' ? 'text-purple-600' : 'text-brand-600') }}">
                                        {{ $mod['tur_numero'] }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 mb-1 font-semibold uppercase">Tiempo</p>
                                    <p class="text-lg font-bold {{ $mod['tiempo_segundos'] > 600 ? 'text-red-500' : 'text-gray-800' }}">
                                        {{ floor($mod['tiempo_segundos'] / 60) }}:{{ str_pad($mod['tiempo_segundos'] % 60, 2, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                            </div>
                            @else
                            <div class="flex justify-between items-center h-[54px]">
                                <p class="text-sm font-bold text-gray-500 uppercase tracking-widest"><i class="fa-solid fa-mug-hot mr-2"></i>Pausa / Libre</p>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="col-span-full py-12 text-center text-gray-500">No hay módulos registrados para monitoreo.</div>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>
