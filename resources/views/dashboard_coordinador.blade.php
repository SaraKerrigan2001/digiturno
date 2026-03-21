@extends('layouts.coordinador')

@section('title', 'SENA APE - Dashboard Coordinador')

@section('content')
<!-- KPIs Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- KPI 1 -->
    <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-lg shrink-0">
            <i class="fa-solid fa-clock"></i>
        </div>
        <div class="text-right">
            <p class="text-[11px] font-semibold text-gray-400 mb-0.5">Tiempo Medio Espera</p>
            <h3 class="text-2xl font-black text-gray-800 leading-none">{{ $tiempoMedio }}m</h3>
            <p class="text-[10px] font-bold text-red-500 mt-1">-1.2% <span class="text-gray-400 font-medium">promedio</span></p>
        </div>
    </div>

    <!-- KPI 2 -->
    <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between">
        <div class="w-12 h-12 bg-sena-50 text-sena-500 rounded-full flex items-center justify-center text-lg shrink-0">
            <i class="fa-solid fa-grip"></i>
        </div>
        <div class="text-right">
            <p class="text-[11px] font-semibold text-gray-400 mb-0.5">Módulos Activos</p>
            <h3 class="text-2xl font-black text-gray-800 leading-none">{{ sprintf('%02d', $enAtencion) }}/10</h3>
            <p class="text-[10px] font-bold text-sena-500 mt-1">+2 <span class="text-gray-400 font-medium">nuevos hoy</span></p>
        </div>
    </div>

    <!-- KPI 3 -->
    <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between">
        <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center text-lg shrink-0">
            <i class="fa-solid fa-ticket"></i>
        </div>
        <div class="text-right">
            <p class="text-[11px] font-semibold text-gray-400 mb-0.5">Turnos Generados</p>
            <h3 class="text-2xl font-black text-gray-800 leading-none">{{ number_format($usuariosHoy) }}</h3>
            <p class="text-[10px] font-bold text-sena-500 mt-1">+15% <span class="text-gray-400 font-medium">vs ayer</span></p>
        </div>
    </div>

    <!-- KPI 4 -->
    <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 flex items-center justify-between">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center text-lg shrink-0">
            <i class="fa-solid fa-face-smile"></i>
        </div>
        <div class="text-right">
            <p class="text-[11px] font-semibold text-gray-400 mb-0.5">Nivel Satisfacción</p>
            <h3 class="text-2xl font-black text-gray-800 leading-none">{{ $satisfaccion }}</h3>
            <p class="text-[10px] font-bold text-sena-500 mt-1">+0.3% <span class="text-gray-400 font-medium">mejora</span></p>
        </div>
    </div>
</div>

<!-- Main Layout Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
    
    <!-- Left Column (Grid spans 2/3) -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Module Monitor Container -->
        <div class="bg-white p-6 rounded-[1.5rem] shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-chart-simple text-sena-500 text-lg"></i>
                    <h2 class="text-sm font-bold text-gray-900 tracking-wide uppercase">Monitor de Módulos (Torre de Control)</h2>
                </div>
                <div class="bg-sena-50 text-sena-500 px-3 py-1 rounded-full text-[10px] font-black flex items-center tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-sena-500 mr-2 animate-pulse"></span> {{ $enAtencion }} Atendiendo
                </div>
            </div>

            <!-- Modules Grid -->
            <div class="grid grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach(collect($asesoresStatus)->take(6) as $ase)
                @php
                    $estado = $ase['estado'] == 'Free' ? 'ATENDIENDO' : ($ase['estado'] == 'Break Time' ? 'DESCANSO' : 'LIBRE');
                    $color = $estado == 'ATENDIENDO' ? '#39A900' : ($estado == 'DESCANSO' ? '#f59e0b' : '#ef4444');
                    $timeLabel = $estado == 'ATENDIENDO' ? 'Sesión Actual' : ($estado == 'DESCANSO' ? 'Tiempo Descanso' : 'Tiempo Inactivo');
                    $timeText = $estado == 'ATENDIENDO' ? rand(5,20).':'.rand(10,59).' min' : rand(2,10).':00 min';
                    $icon = $estado == 'ATENDIENDO' ? 'fa-message' : ($estado == 'DESCANSO' ? 'fa-mug-hot' : 'fa-stopwatch');
                @endphp
                <div class="border border-gray-100 rounded-2xl p-4 flex flex-col justify-between hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300 min-h-[120px] bg-white group hover:-translate-y-1">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center overflow-hidden shrink-0 border border-gray-100 group-hover:border-sena-100">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ase['nombre']) }}&background=39A900&color=fff&bold=true" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-gray-900 leading-none">{{ explode(' ', $ase['nombre'])[0] }}</h4>
                                <p class="text-[9px] font-bold text-gray-400 mt-1 uppercase">Módulo {{ sprintf('%02d', $ase['modulo']) }}</p>
                            </div>
                        </div>
                        <span class="text-white text-[8px] font-black px-2 py-0.5 rounded shadow-sm tracking-wider" style="background-color: {{ $color }}">{{ $estado }}</span>
                    </div>
                    <div class="flex justify-between items-end mt-auto">
                        <div>
                            <p class="text-[9px] text-gray-400 font-black mb-0.5 tracking-wide uppercase">{{ $timeLabel }}</p>
                            <p class="text-xs font-black" style="color: {{ $color }}">{{ $timeText }}</p>
                        </div>
                        <i class="fa-solid {{ $icon }} text-gray-100 text-lg group-hover:text-sena-50 group-hover:scale-110 transition-all"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Geographic Map Container -->
        <div class="bg-white p-6 rounded-[1.5rem] shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100">
            <div class="flex items-center space-x-3 mb-6">
                <i class="fa-solid fa-map-location-dot text-sena-500 text-lg"></i>
                <h2 class="text-sm font-bold text-gray-900 tracking-wide uppercase">Distribución Geográfica de Sede</h2>
            </div>
            <div class="relative h-64 border-2 border-dashed border-gray-100 rounded-3xl flex items-center justify-center bg-gray-50/50 overflow-hidden">
                <!-- Abstract Map Graphic -->
                <div class="relative w-full h-full flex items-center justify-center opacity-10">
                   <i class="fa-solid fa-map text-[200px]"></i>
                </div>

                <!-- Pins - Fake positions -->
                <div class="absolute flex flex-col items-center justify-center group cursor-pointer" style="left: 20%; top: 35%;">
                    <div class="w-10 h-10 bg-sena-50 rounded-full flex items-center justify-center shadow-md border-2 border-white group-hover:scale-110 transition">
                        <div class="w-3 h-3 bg-sena-500 rounded-full"></div>
                    </div>
                    <span class="text-[9px] font-black text-gray-700 mt-2 bg-white px-2 py-1 rounded shadow-sm border border-gray-100">M1-M4</span>
                </div>

                <div class="absolute flex flex-col items-center justify-center group cursor-pointer" style="left: 45%; top: 60%;">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center shadow-md border-2 border-white group-hover:scale-110 transition">
                        <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                    </div>
                    <span class="text-[9px] font-black text-gray-500 mt-2 bg-white px-2 py-1 rounded shadow-sm border border-gray-100">Recepción</span>
                </div>

                <div class="absolute flex flex-col items-center justify-center group cursor-pointer" style="left: 65%; bottom: 30%;">
                    <div class="w-10 h-10 bg-sena-100 rounded-full flex items-center justify-center shadow-md border-2 border-white group-hover:scale-110 transition">
                        <div class="w-3 h-3 bg-sena-600 rounded-full"></div>
                    </div>
                    <span class="text-[9px] font-black text-gray-700 mt-2 bg-white px-2 py-1 rounded shadow-sm border border-gray-100">M5-M8</span>
                </div>

                <!-- Legend -->
                <div class="absolute bottom-4 right-4 bg-white p-4 rounded-2xl shadow-xl border border-gray-50 flex flex-col space-y-2 z-10 min-w-[120px]">
                    <span class="text-[9px] font-black text-gray-900 border-b border-gray-50 pb-2 uppercase tracking-widest">Leyenda</span>
                    <div class="flex items-center space-x-2"><span class="w-2 h-2 rounded-full bg-sena-500"></span><span class="text-[9px] font-bold text-gray-600">Activos</span></div>
                    <div class="flex items-center space-x-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span><span class="text-[9px] font-bold text-gray-600">Alerta</span></div>
                    <div class="flex items-center space-x-2"><span class="w-2 h-2 rounded-full bg-gray-300"></span><span class="text-[9px] font-bold text-gray-600">Mantenimiento</span></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column (Grid spans 1/3) -->
    <div class="lg:col-span-1 space-y-8 flex flex-col">
        
        <!-- Flow Per Hour Char Container -->
        <div class="bg-white p-6 rounded-[1.5rem] shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 h-64">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">FLUJO POR HORA</h3>
                <i class="fa-solid fa-chart-column text-gray-200"></i>
            </div>
            <div class="h-40">
                <canvas id="flowChart"></canvas>
            </div>
        </div>

        <!-- Document Types Container -->
        <div class="bg-white p-6 rounded-[1.5rem] shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 h-64">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">TIPOS DE DOCUMENTO</h3>
                <i class="fa-solid fa-chart-pie text-gray-200"></i>
            </div>
            
            <div class="flex items-center h-40">
                <div class="w-1/2 h-full relative">
                    <canvas id="docChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-xl font-black text-gray-900 leading-none">65%</span>
                        <span class="text-[8px] font-bold text-gray-400 mt-1 uppercase tracking-widest">CC</span>
                    </div>
                </div>
                <div class="w-1/2 pl-6 flex flex-col space-y-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-sena-500 rounded-full"></div>
                            <span class="text-[10px] font-bold text-gray-600">CC</span>
                        </div>
                        <span class="text-[10px] font-black text-gray-900">834</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span class="text-[10px] font-bold text-gray-600">NIT</span>
                        </div>
                        <span class="text-[10px] font-black text-gray-900">320</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 bg-gray-200 rounded-full"></div>
                            <span class="text-[10px] font-bold text-gray-600">Otros</span>
                        </div>
                        <span class="text-[10px] font-black text-gray-900">130</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts Container -->
        <div class="bg-white p-6 rounded-[1.5rem] shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 flex flex-col flex-1 min-h-[300px]">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">ALERTAS RECIENTES</h3>
                <span class="bg-red-500 text-white w-5 h-5 rounded-lg flex items-center justify-center text-[10px] font-black shadow-sm mr-2 animate-bounce">3</span>
            </div>

            <div class="space-y-4 flex-1 mb-6">
                <!-- Alert 1 -->
                <div class="flex items-start space-x-3 group cursor-pointer hover:bg-red-50/30 transition p-2 -ml-2 rounded-2xl border border-transparent hover:border-red-100">
                    <div class="w-9 h-9 rounded-xl bg-red-50 flex justify-center items-center shrink-0 border border-red-100 text-red-500">
                        <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-[11px] font-black text-gray-900 mb-0.5 uppercase tracking-wide">Tiempo espera > 20m</h4>
                        <p class="text-[10px] font-medium text-gray-500 mb-1 leading-tight">El Módulo Grupo B reporta retrasos técnicos.</p>
                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest">HACE 2 MINUTOS</p>
                    </div>
                </div>
                <!-- Alert 2 -->
                <div class="flex items-start space-x-3 group cursor-pointer hover:bg-amber-50/30 transition p-2 -ml-2 rounded-2xl border border-transparent hover:border-amber-100">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 flex justify-center items-center shrink-0 border border-amber-100 text-amber-500">
                        <i class="fa-solid fa-link-slash text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-[11px] font-black text-gray-900 mb-0.5 uppercase tracking-wide">Módulo 05 desconectado</h4>
                        <p class="text-[10px] font-medium text-gray-500 mb-1 leading-tight">Pérdida de conexión con el dispositivo biométrico.</p>
                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest">HACE 15 MINUTOS</p>
                    </div>
                </div>
                <!-- Alert 3 -->
                <div class="flex items-start space-x-3 group cursor-pointer hover:bg-blue-50/30 transition p-2 -ml-2 rounded-2xl border border-transparent hover:border-blue-100">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex justify-center items-center shrink-0 border border-blue-100 text-blue-500">
                        <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-[11px] font-black text-gray-900 mb-0.5 uppercase tracking-wide">Backup completo</h4>
                        <p class="text-[10px] font-medium text-gray-500 mb-1 leading-tight">Datos del servidor exportados a la nube SENA.</p>
                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest">HACE 1 HORA</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-auto border-t border-gray-50 pt-5 text-center">
                <a href="#" class="text-[10px] font-black text-sena-500 hover:text-sena-600 hover:underline uppercase tracking-widest">Ver Todas las Notificaciones</a>
            </div>
        </div>

        <!-- Footer version info -->
        <div class="flex flex-col items-end pt-2 opacity-50 pr-4 mt-auto">
            <div class="flex items-center space-x-2 mb-1">
                <div class="w-5 h-4 bg-gray-400 rounded-sm"></div>
                <span class="text-[9px] font-black text-gray-700 tracking-wider">SENA APE 2026</span>
            </div>
            <span class="text-[8px] font-bold text-gray-500 text-right">Sistema de Gestión de Turnos<br>v4.9.0-estable</span>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js Default styling
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#9ca3af';

    // FLOW PER HOUR (Bar Chart)
    const flowCtx = document.getElementById('flowChart').getContext('2d');
    new Chart(flowCtx, {
        type: 'bar',
        data: {
            labels: ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'],
            datasets: [{
                data: [35, 55, 45, 60, 40, 25], 
                backgroundColor: '#39A900',
                borderRadius: 4,
                borderSkipped: false,
                barPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { enabled: true } },
            scales: {
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { font: { size: 9 }, maxRotation: 0, padding: 5, autoSkip: false }
                },
                y: { display: false, beginAtZero: true }
            }
        }
    });

    // DOCUMENT TYPES (Doughnut Chart)
    const docCtx = document.getElementById('docChart').getContext('2d');
    new Chart(docCtx, {
        type: 'doughnut',
        data: {
            labels: ['CC', 'NIT', 'Otros'],
            datasets: [{
                data: [834, 320, 130],
                backgroundColor: ['#39A900', '#3b82f6', '#f3f4f6'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '82%', 
            plugins: { legend: { display: false }, tooltip: { enabled: true } },
            layout: { padding: 5 }
        }
    });
</script>
@endsection
