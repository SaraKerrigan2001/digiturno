@extends('layouts.coordinador')

@section('title', 'Configuración - SENA APE')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 leading-tight">Configuración Global</h1>
    <p class="text-gray-500 text-sm font-medium mt-1">Personaliza los parámetros de operación del sistema DigiTurno.</p>
</div>

{{-- Toast --}}
<div id="cfg-toast" class="fixed top-6 right-6 z-[9999] bg-white border border-sena-blue/20 rounded-2xl px-5 py-4 shadow-2xl flex items-center space-x-3 min-w-[280px] hidden">
    <div class="w-9 h-9 bg-sena-blue/10 rounded-xl flex items-center justify-center text-sena-blue"><i class="fa-solid fa-circle-check"></i></div>
    <p class="text-sm font-bold text-gray-800">Configuración guardada correctamente.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">

    {{-- Left: Main Settings --}}
    <div class="lg:col-span-2 space-y-6">

    {{-- Card: Ciclo de Reinicio de Turnos --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 px-7 py-5 flex items-center space-x-3">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center text-white"><i class="fa-solid fa-rotate"></i></div>
                <div>
                    <h2 class="text-sm font-black text-white uppercase tracking-widest">Ciclo de Turnos</h2>
                    <p class="text-white/70 text-[10px] font-medium mt-0.5">Controla cada cuánto se reinicia la numeración y la validación de duplicados</p>
                </div>
            </div>
            <div class="p-7">
                @php $cicloActual = \App\Models\ConfiguracionSistema::cicloDeTurno(); @endphp

                @if(session('success'))
                <div class="mb-5 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-3 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <p class="text-sm font-bold text-emerald-700">{{ session('success') }}</p>
                </div>
                @endif

                <form action="{{ route('coordinador.ciclo.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        @foreach(['dia' => ['Diario', 'fa-sun', 'Los turnos se reinician cada día a medianoche. Un ciudadano no puede tener dos turnos activos el mismo día.'], 'semana' => ['Semanal', 'fa-calendar-week', 'Los turnos se reinician cada lunes. Un ciudadano no puede tener dos turnos activos en la misma semana.'], 'mes' => ['Mensual', 'fa-calendar-days', 'Los turnos se reinician el primer día de cada mes. Un ciudadano no puede tener dos turnos activos en el mismo mes.']] as $valor => [$etiqueta, $icono, $descripcion])
                        <label class="cursor-pointer group">
                            <input type="radio" name="ciclo_turno" value="{{ $valor }}" class="sr-only peer" {{ $cicloActual === $valor ? 'checked' : '' }}>
                            <div class="border-2 rounded-2xl p-4 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50 h-full">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center peer-checked:bg-emerald-500 peer-checked:text-white transition-all group-has-[:checked]:bg-emerald-500 group-has-[:checked]:text-white">
                                        <i class="fa-solid {{ $icono }}"></i>
                                    </div>
                                    <span class="font-black text-gray-800 text-sm">{{ $etiqueta }}</span>
                                    @if($cicloActual === $valor)
                                    <span class="ml-auto text-[9px] font-black bg-emerald-500 text-white px-2 py-0.5 rounded-full uppercase tracking-wider">Activo</span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-gray-500 leading-relaxed">{{ $descripcion }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-2xl px-5 py-3 flex items-start gap-3 mb-5">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5 shrink-0"></i>
                        <p class="text-xs text-amber-700 font-medium leading-relaxed">
                            Cambiar el ciclo afecta inmediatamente la validación de turnos duplicados y la numeración correlativa en el kiosco. Los turnos ya generados no se modifican.
                        </p>
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-2xl transition-all active:scale-95 flex items-center justify-center gap-2 text-sm uppercase tracking-widest">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Ciclo de Turnos
                    </button>
                </form>
            </div>
        </div>

        {{-- Card: Operación General --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-sena-500 to-sena-400 px-7 py-5 flex items-center space-x-3">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center text-white"><i class="fa-solid fa-sliders"></i></div>
                <h2 class="text-sm font-black text-white uppercase tracking-widest">Operación General</h2>
            </div>
            <div class="p-7 space-y-5">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nombre de la Sede</label>
                    <input id="cfg-nombre-sede" type="text" value="Sede Central - SENA Regional Antioquia"
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-sena-500 outline-none transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tiempo de Alerta (min)</label>
                        <div class="relative">
                            <i class="fa-solid fa-clock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input id="cfg-alerta-min" type="number" value="20" min="1" max="60"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-11 pr-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-sena-500 outline-none border transition-all">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Capacidad / Bloque</label>
                        <div class="relative">
                            <i class="fa-solid fa-ticket absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                            <input id="cfg-capacidad" type="number" value="50" min="1"
                                class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-11 pr-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-sena-500 outline-none border transition-all">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Modo de Asignación</label>
                    <div class="relative">
                        <i class="fa-solid fa-gear absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <select id="cfg-modo-asignacion" class="w-full bg-gray-50 border border-gray-100 rounded-2xl pl-11 pr-10 py-3.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-sena-500 outline-none border appearance-none transition-all">
                            <option>Automático (Basado en Horario y Prioridad)</option>
                            <option>Manual (Selección Directa del Asesor)</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Alertas y Notificaciones --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-sena-orange to-sena-orange/80 px-7 py-5 flex items-center space-x-3">
                <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center text-white"><i class="fa-solid fa-bell"></i></div>
                <h2 class="text-sm font-black text-white uppercase tracking-widest">Alertas y Notificaciones</h2>
            </div>
            <div class="p-7 space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div>
                        <p class="text-sm font-black text-gray-900">Alertas Sonoras</p>
                        <p class="text-[11px] text-gray-400 font-medium mt-0.5">Reproducir audio cuando el tiempo de espera exceda el umbral</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                        <input type="checkbox" id="cfg-alertas-sonoras" class="sr-only peer" checked>
                        <div class="w-12 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-sena-orange/30 rounded-full peer peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sena-orange after:shadow-sm"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div>
                        <p class="text-sm font-black text-gray-900">Notificaciones Push</p>
                        <p class="text-[11px] text-gray-400 font-medium mt-0.5">Enviar notificaciones a los asesores activos</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                        <input type="checkbox" id="cfg-push-notif" class="sr-only peer">
                        <div class="w-12 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-sena-orange/30 rounded-full peer peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sena-orange after:shadow-sm"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <div>
                        <p class="text-sm font-black text-gray-900">Modo Mantenimiento</p>
                        <p class="text-[11px] text-gray-400 font-medium mt-0.5">Pausar la generación de turnos en el kiosco</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                        <input type="checkbox" id="cfg-mantenimiento" class="sr-only peer">
                        <div class="w-12 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500 after:shadow-sm"></div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end">
            <button onclick="saveCfg()" class="bg-gradient-to-r from-sena-500 to-sena-400 text-white px-10 py-4 rounded-2xl text-[11px] font-black shadow-xl shadow-sena-500/20 hover:from-sena-600 hover:to-sena-500 transition-all hover:-translate-y-0.5 active:scale-95 uppercase tracking-[0.2em] flex items-center space-x-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Guardar Configuración</span>
            </button>
        </div>
    </div>

    {{-- Right: Info Cards --}}
    <div class="space-y-6">

        {{-- System Info --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <div class="flex items-center space-x-2 mb-5 pb-4 border-b border-gray-50">
                <i class="fa-solid fa-circle-info text-sena-500"></i>
                <h3 class="text-xs font-black text-gray-700 uppercase tracking-widest">Info del Sistema</h3>
            </div>
            <div class="space-y-3 text-xs">
                <div class="flex justify-between"><span class="font-bold text-gray-400">Versión</span><span class="font-black text-gray-900">v4.9.0</span></div>
                <div class="flex justify-between"><span class="font-bold text-gray-400">PHP</span><span class="font-black text-gray-900">{{ phpversion() }}</span></div>
                <div class="flex justify-between"><span class="font-bold text-gray-400">Entorno</span><span class="font-black text-sena-500">Producción</span></div>
                <div class="flex justify-between"><span class="font-bold text-gray-400">Base de Datos</span><span class="font-black text-gray-900">MySQL</span></div>
                <div class="flex justify-between"><span class="font-bold text-gray-400">Uptime</span><span class="font-black text-emerald-500">99.9%</span></div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <div class="flex items-center space-x-2 mb-5 pb-4 border-b border-gray-50">
                <i class="fa-solid fa-bolt text-sena-yellow"></i>
                <h3 class="text-xs font-black text-gray-700 uppercase tracking-widest">Acciones Rápidas</h3>
            </div>
            <div class="space-y-2.5">
                <a href="{{ route('coordinador.export') }}" class="flex items-center space-x-3 p-3 bg-gray-50 hover:bg-sena-50 rounded-xl border border-gray-100 hover:border-sena-100 transition group">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-sena-500 text-sm shadow-sm"><i class="fa-solid fa-download"></i></div>
                    <span class="text-[11px] font-black text-gray-600 group-hover:text-sena-600 uppercase tracking-wide">Exportar Datos</span>
                </a>
                <a href="{{ route('manual.coordinador') }}" class="flex items-center space-x-3 p-3 bg-gray-50 hover:bg-blue-50 rounded-xl border border-gray-100 hover:border-blue-100 transition group">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-blue-500 text-sm shadow-sm"><i class="fa-solid fa-book-open"></i></div>
                    <span class="text-[11px] font-black text-gray-600 group-hover:text-blue-600 uppercase tracking-wide">Manual de Usuario</span>
                </a>
                <a href="{{ route('coordinador.modulos') }}" class="flex items-center space-x-3 p-3 bg-gray-50 hover:bg-sena-orange/10 rounded-xl border border-gray-100 hover:border-sena-orange/20 transition group">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-sena-orange text-sm shadow-sm"><i class="fa-solid fa-users-gear"></i></div>
                    <span class="text-[11px] font-black text-gray-600 group-hover:text-sena-orange uppercase tracking-wide">Gestión de Asesores</span>
                </a>
                <form action="{{ route('coordinador.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 p-3 bg-gray-50 hover:bg-red-50 rounded-xl border border-gray-100 hover:border-red-100 transition group text-left">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-red-400 text-sm shadow-sm"><i class="fa-solid fa-right-from-bracket"></i></div>
                        <span class="text-[11px] font-black text-gray-600 group-hover:text-red-500 uppercase tracking-wide">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Load saved config from localStorage
    const inputs = {
        'cfg-nombre-sede': localStorage.getItem('coord_cfg_nombre_sede'),
        'cfg-alerta-min': localStorage.getItem('coord_cfg_alerta_min'),
        'cfg-capacidad': localStorage.getItem('coord_cfg_capacidad'),
        'cfg-modo-asignacion': localStorage.getItem('coord_cfg_modo_asignacion'),
    };
    Object.entries(inputs).forEach(([id, val]) => {
        if (val !== null) {
            const el = document.getElementById(id);
            if (el) el.value = val;
        }
    });

    const toggles = {
        'cfg-alertas-sonoras': 'coord_cfg_alertas_sonoras',
        'cfg-push-notif': 'coord_cfg_push_notif',
        'cfg-mantenimiento': 'coord_cfg_mantenimiento',
    };
    Object.entries(toggles).forEach(([id, key]) => {
        const el = document.getElementById(id);
        if (el && localStorage.getItem(key) !== null) {
            el.checked = localStorage.getItem(key) === 'true';
        }
    });

    function saveCfg() {
        // Save inputs
        Object.keys(inputs).forEach(id => {
            const el = document.getElementById(id);
            if (el) localStorage.setItem(`coord_cfg_${id.replace('cfg-', '')}`, el.value);
        });
        // Save toggles
        Object.entries(toggles).forEach(([id, key]) => {
            const el = document.getElementById(id);
            if (el) localStorage.setItem(key, el.checked);
        });
        // Show toast
        const toast = document.getElementById('cfg-toast');
        toast.classList.remove('hidden');
        toast.classList.add('flex');
        setTimeout(() => {
            toast.classList.add('hidden');
            toast.classList.remove('flex');
        }, 3500);
    }
</script>
@endsection
