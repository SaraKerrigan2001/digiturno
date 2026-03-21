@extends('layouts.asesor')

@section('title', 'Dashboard - 
SENA APE')

@section('content')
@php
    $status = request()->get('status', isset($atencion) ? 'active' : 'idle');
    $isPause = $status == 'pause';
@endphp

@if(!$isPause)
    <!-- Attendance Dashboard (Active) -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
        
        <!-- Main Attendance Card -->
        <div class="xl:col-span-2 space-y-10">
            <div class="bg-sena-500 rounded-[3rem] p-10 shadow-2xl shadow-sena-500/30 relative overflow-hidden group">
                <i class="fa-solid fa-id-card absolute -bottom-10 -right-10 text-[200px] text-white/5 transform rotate-12 transition-transform group-hover:rotate-0 duration-700"></i>

                <div class="flex justify-between items-start relative z-10">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-white/80 uppercase tracking-[0.3em]">Atendiendo Ahora</p>
                        <h2 class="text-7xl font-black text-white tracking-tighter">{{ $atencion->turno->tur_numero ?? 'NIT-045' }}</h2>
                    </div>
                    <div class="bg-white/20 backdrop-blur-md px-5 py-2 rounded-full border border-white/30">
                        <p class="text-xs font-black text-white tracking-widest" id="atencion-timer">00:12:45</p>
                    </div>
                </div>

                <div class="mt-16 relative z-10">
                    <p class="text-[10px] font-black text-white/80 uppercase tracking-[0.2em] mb-2">Ciudadano</p>
                    <h3 class="text-3xl font-black text-white leading-tight">{{ $atencion->turno->persona->pers_nombres ?? 'Juan Pérez Rodríguez' }}</h3>
                    <p class="text-sm font-bold text-white/70 mt-1">{{ $atencion->turno->persona->pers_tipodoc ?? 'CC' }} {{ $atencion->turno->persona->pers_doc ?? '1.023.456.789' }}</p>
                </div>

                <div class="grid grid-cols-2 gap-6 mt-16 relative z-10">
                    <button class="bg-white text-sena-500 font-extrabold py-5 rounded-3xl hover:bg-gray-50 transition-all flex items-center justify-center space-x-3 shadow-xl active:scale-95 group">
                        <i class="fa-solid fa-arrow-right-long group-hover:translate-x-1 transition-transform"></i>
                        <span class="uppercase tracking-widest text-xs">Llamar Siguiente</span>
                    </button>
                    <button class="bg-[#FF4D4D] text-white font-extrabold py-5 rounded-3xl hover:bg-red-600 transition-all flex items-center justify-center space-x-3 shadow-xl active:scale-95">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <span class="uppercase tracking-widest text-xs">Finalizar Atención</span>
                    </button>
                </div>
            </div>

            <!-- Secondary Stats Row -->
            <div class="grid grid-cols-3 gap-8 text-center px-4">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50 flex flex-col items-center group hover:shadow-xl transition-all duration-500">
                    <div class="w-14 h-14 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Atendidos hoy</p>
                    <h4 class="text-4xl font-black text-gray-900">24</h4>
                    <span class="text-[10px] font-black text-emerald-500 mt-2 tracking-widest">+12%</span>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50 flex flex-col items-center group hover:shadow-xl transition-all duration-500">
                    <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-stopwatch"></i>
                    </div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Tiempo atención</p>
                    <h4 class="text-4xl font-black text-gray-900">14 <span class="text-sm">min</span></h4>
                    <span class="text-[10px] font-black text-gray-400 mt-2 tracking-widest uppercase">Promedio</span>
                </div>

                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-50 flex flex-col justify-between group hover:shadow-xl transition-all duration-500 relative overflow-hidden">
                    <h5 class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-left px-2">Estado del Puesto</h5>
                    <div class="w-full mt-4 bg-gray-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-sena-500 h-full rounded-full w-[75%] transition-all duration-1000 group-hover:w-[85%]"></div>
                    </div>
                    <div class="flex justify-between items-end mt-4">
                        <span class="text-[10px] font-black text-gray-600 uppercase tracking-widest">Capacidad</span>
                        <span class="text-lg font-black text-gray-900">75%</span>
                    </div>
                    <div class="mt-4 bg-[#ECFDF5] text-emerald-600 px-4 py-2 rounded-xl text-center">
                        <p class="text-[8px] font-black uppercase tracking-[0.2em] mb-0.5">Rendimiento</p>
                        <p class="text-xs font-black uppercase">Excelente</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (Service Details) -->
        <div class="space-y-10">
            <div class="bg-white h-full rounded-[3rem] p-10 shadow-sm border border-gray-100">
                <div class="flex items-center space-x-3 mb-10 pb-6 border-b border-gray-50">
                    <i class="fa-solid fa-user-tag text-sena-500 text-lg"></i>
                    <h4 class="text-sm font-black text-gray-900 tracking-wide uppercase">Detalles del Servicio</h4>
                </div>

                <div class="space-y-10">
                    <div class="space-y-4 bg-gray-50 p-6 rounded-3xl border border-gray-100/50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Trámite solicitado</p>
                        <h5 class="text-sm font-black text-gray-800 leading-snug">Inscripción de Hoja de Vida y Orientación Laboral</h5>
                    </div>

                    <div class="space-y-4 bg-gray-50 p-6 rounded-3xl border border-gray-100/50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Prioridad</p>
                        <div class="flex items-center space-x-2 text-sena-500">
                            <i class="fa-solid fa-circle-check"></i>
                            <span class="text-xs font-black uppercase tracking-widest">Normal</span>
                        </div>
                    </div>

                    <div class="space-y-4 bg-gray-50 p-6 rounded-3xl border border-gray-100/50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Hora de llegada</p>
                        <h5 class="text-lg font-black text-gray-800">08:45 AM</h5>
                    </div>

                    <button class="w-full mt-10 border-2 border-sena-500 text-sena-500 font-black py-5 rounded-3xl hover:bg-sena-50 transition-all text-xs uppercase tracking-[0.2em]">
                        Ver historial del ciudadano
                    </button>
                </div>
            </div>
        </div>

        <!-- Bottom Lists -->
        <div class="xl:col-span-1">
            <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 h-full">
                <div class="flex justify-between items-center mb-10 pb-6 border-b border-gray-50">
                    <div class="flex items-center space-x-3">
                        <i class="fa-solid fa-clock-rotate-left text-gray-400"></i>
                        <h4 class="text-sm font-black text-gray-900 tracking-wide uppercase">Últimos Turnos</h4>
                    </div>
                </div>
                
                <div class="space-y-6">
                    @foreach([['num'=>'NIT-044', 'name'=>'Ana María Restrepo', 'time'=>'9:15 AM'],['num'=>'NIT-043', 'name'=>'Carlos Mario Úsuga', 'time'=>'8:58 AM'],['num'=>'NIT-042', 'name'=>'Elena Beltrán', 'time'=>'8:30 AM'],['num'=>'NIT-041', 'name'=>'Pedro Duarte', 'time'=>'8:12 AM']] as $t)
                    <div class="flex items-center justify-between group cursor-pointer hover:bg-gray-50 p-2 -m-2 rounded-2xl transition-all">
                        <div class="flex items-center space-x-4">
                            <div class="w-2 h-2 rounded-full bg-gray-200 group-hover:bg-sena-500 transition-colors"></div>
                            <div>
                                <p class="text-xs font-black text-gray-900">{{ $t['num'] }}</p>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5">{{ $t['name'] }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $t['time'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="xl:col-span-2">
            <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 h-full">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-sm font-black text-gray-900 tracking-wide uppercase">Atendidos por Hora</h4>
                </div>
                <div class="h-64">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@else
    
    <!-- Pause Mode Design (Image 2) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-10">
            <!-- Top Pause Banner -->
            <div class="bg-amber-50 border border-amber-100 rounded-[2.5rem] p-8 flex items-center justify-between shadow-lg shadow-amber-500/5">
                <div class="flex items-center space-x-6">
                    <div class="w-16 h-16 bg-amber-500 rounded-3xl flex items-center justify-center text-white text-3xl shadow-xl shadow-amber-500/20">
                        <i class="fa-solid fa-mug-hot"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-gray-900">Atención en Pausa</h2>
                        <p class="text-sm font-medium text-gray-500 mt-1">Actualmente te encuentras en tiempo de descanso programado.</p>
                    </div>
                </div>
                <a href="{{ url('/asesor') }}" class="bg-amber-500 hover:bg-amber-600 text-white font-black py-4 px-10 rounded-3xl transition-all shadow-xl shadow-amber-500/20 transform hover:-translate-y-1 active:scale-95 flex items-center space-x-3 text-xs uppercase tracking-widest">
                    <i class="fa-solid fa-play"></i>
                    <span>Reanudar Atención</span>
                </a>
            </div>

            <!-- Timer Section -->
            <div class="bg-white rounded-[3rem] p-16 shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center">
                <p class="text-[10px] font-black text-amber-500 uppercase tracking-[0.4em] mb-12">Tiempo Transcurrido</p>
                
                <div class="flex items-center space-x-8">
                    <div class="flex flex-col items-center">
                        <div class="w-36 h-44 bg-gray-50 rounded-[2rem] border border-gray-100 flex items-center justify-center shadow-inner">
                            <span class="text-7xl font-black text-gray-900 tracking-tighter">00</span>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4">Horas</span>
                    </div>
                    <span class="text-5xl font-black text-amber-500 mt-[-40px] animate-pulse">:</span>
                    <div class="flex flex-col items-center">
                        <div class="w-36 h-44 bg-gray-50 rounded-[2rem] border border-gray-100 flex items-center justify-center shadow-inner">
                            <span class="text-7xl font-black text-gray-900 tracking-tighter">15</span>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4">Minutos</span>
                    </div>
                    <span class="text-5xl font-black text-amber-500 mt-[-40px] animate-pulse">:</span>
                    <div class="flex flex-col items-center">
                        <div class="w-36 h-44 bg-gray-50 rounded-[2rem] border border-gray-100 flex items-center justify-center shadow-inner">
                            <span class="text-7xl font-black text-gray-900 tracking-tighter">42</span>
                        </div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-4">Segundos</span>
                    </div>
                </div>

                <p class="mt-20 text-sm italic text-gray-400 max-w-lg font-medium">"El descanso es parte fundamental de un servicio de calidad. Aprovecha para estirar y recargar energías."</p>
            </div>
        </div>

        <!-- Right Column (Pause Mode Info) -->
        <div class="space-y-10">
            <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 opacity-50 relative overflow-hidden group">
               <div class="absolute inset-0 bg-white/40 flex items-center justify-center z-10 backdrop-blur-[2px]">
                   <i class="fa-solid fa-lock text-gray-300 text-3xl"></i>
               </div>
               <div class="flex justify-between items-center mb-8">
                   <h4 class="text-sm font-black text-gray-900 tracking-wide uppercase">Siguiente en Fila</h4>
               </div>
               <p class="text-xs font-medium text-gray-400 text-center leading-relaxed">La información del ciudadano está oculta durante la pausa.</p>
            </div>

            <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 h-1/2">
                <div class="flex items-center space-x-3 mb-10 pb-6 border-b border-gray-50">
                    <i class="fa-solid fa-chart-line text-amber-500 text-lg"></i>
                    <h4 class="text-sm font-black text-gray-900 tracking-wide uppercase">Resumen del Turno</h4>
                </div>

                <div class="space-y-8">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-500">Ciudadanos Atendidos</span>
                        <span class="text-lg font-black text-gray-900">12</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-amber-500 h-full rounded-full w-[60%]"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<script>
    if (document.getElementById('mainChart')) {
        const ctx = document.getElementById('mainChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00'],
                datasets: [{
                    label: 'Atenciones',
                    data: [2, 5, 4, 8, 3, 5],
                    borderColor: '#39A900',
                    backgroundColor: 'rgba(57, 169, 0, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false } },
                    y: { display: false }
                }
            }
        });
    }
</script>
@endsection
