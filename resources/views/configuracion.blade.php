@extends('layouts.coordinador')

@section('title', 'Configuración - SENA APE')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 leading-tight">Configuración Global</h1>
    <p class="text-gray-500 text-sm font-medium mt-1">Personaliza los parámetros de operación del sistema DigiTurno.</p>
</div>

<div class="max-w-3xl bg-white rounded-[2rem] shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 p-10">
    <form class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="col-span-2">
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Nombre de la Sede</label>
                <input type="text" value="Sede Central - SENA Regional Antioquia" class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-sena-500 outline-none border transition-all">
            </div>

            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Tiempos de Alerta (minutos)</label>
                <div class="relative">
                    <i class="fa-solid fa-clock absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    <input type="number" value="20" class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-sena-500 outline-none border transition-all">
                </div>
            </div>
            
            <div>
                <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Capacidad de Turnos / Bloque</label>
                <div class="relative">
                    <i class="fa-solid fa-ticket absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                    <input type="number" value="50" class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-sena-500 outline-none border transition-all">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Modo de Operación de Asignación</label>
            <div class="relative">
                <i class="fa-solid fa-sliders absolute left-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                <select class="w-full bg-gray-50 border-gray-100 rounded-2xl pl-12 pr-5 py-3.5 text-sm font-medium text-gray-700 focus:ring-2 focus:ring-sena-500 outline-none border appearance-none transition-all">
                    <option>Automático (Basado en Horario y Prioridad)</option>
                    <option>Manual (Selección Directa del Asesor)</option>
                </select>
                <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-50 flex items-center justify-between">
            <p class="text-[10px] text-gray-400 font-bold italic">* Los cambios afectarán a todos los módulos en tiempo real.</p>
            <button type="submit" class="bg-sena-500 text-white px-10 py-4 rounded-2xl text-[11px] font-black shadow-xl hover:bg-sena-600 transition-all hover:scale-105 active:scale-95 uppercase tracking-[0.2em]">
                Actualizar Sistema
            </button>
        </div>
    </form>
</div>
@endsection
