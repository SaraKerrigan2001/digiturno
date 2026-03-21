@extends('layouts.asesor')

@section('title', 'Configuración de Módulo - APE Advisor')

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-black text-gray-900 leading-tight">Ajustes del Módulo</h2>
    <p class="text-gray-500 text-sm font-medium mt-1">Personaliza tu entorno de trabajo y notificaciones.</p>
</div>

<div class="max-w-4xl grid grid-cols-1 md:grid-cols-3 gap-10">
    <!-- Profile Card -->
    <div class="md:col-span-1">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 text-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($asesor->persona->pers_nombres ?? 'Carlos Ruiz') }}&background=39A900&color=fff&size=128&bold=true" class="w-32 h-32 rounded-full border-4 border-gray-50 mx-auto mb-6 shadow-md" alt="Profile">
            <h3 class="text-xl font-black text-gray-900 leading-tight">{{ $asesor->persona->pers_nombres ?? 'Carlos Ruiz' }}</h3>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-2">Módulo {{ $asesor->modulo ?? '04' }}</p>
            <div class="mt-8 pt-8 border-t border-gray-50">
                <button class="w-full bg-gray-50 text-gray-600 font-black py-3 rounded-2xl text-[10px] uppercase tracking-widest hover:bg-gray-100 transition-colors">Cambiar Foto</button>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="md:col-span-2">
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 space-y-10">
            <div class="space-y-6">
                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest px-2">Información del Sistema</h4>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Número de Módulo</label>
                        <input type="text" value="{{ $asesor->modulo ?? '04' }}" class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-4 text-sm font-black text-gray-700 outline-none border focus:ring-2 focus:ring-sena-500 transition-all" readonly>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Sede Asignada</label>
                        <input type="text" value="Sede Central Antioquia" class="w-full bg-gray-50 border-gray-100 rounded-2xl px-5 py-4 text-sm font-black text-gray-700 outline-none border transition-all" readonly>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest px-2">Preferencias</h4>
                <div class="space-y-4">
                    <label class="flex items-center justify-between p-5 bg-gray-50 rounded-3xl border border-gray-100/50 cursor-pointer hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-4">
                            <i class="fa-solid fa-volume-high text-gray-400"></i>
                            <span class="text-xs font-black text-gray-700 uppercase tracking-widest">Alertas Sonoras</span>
                        </div>
                        <input type="checkbox" checked class="w-10 h-5 bg-gray-200 rounded-full appearance-none checked:bg-sena-500 transition-all relative after:content-[''] after:absolute after:w-4 after:h-4 after:bg-white after:rounded-full after:top-0.5 after:left-0.5 checked:after:left-5.5 after:transition-all">
                    </label>

                    <label class="flex items-center justify-between p-5 bg-gray-50 rounded-3xl border border-gray-100/50 cursor-pointer hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-4">
                            <i class="fa-solid fa-message text-gray-400"></i>
                            <span class="text-xs font-black text-gray-700 uppercase tracking-widest">Notificaciones de Escritorio</span>
                        </div>
                        <input type="checkbox" class="w-10 h-5 bg-gray-200 rounded-full appearance-none checked:bg-sena-500 transition-all relative after:content-[''] after:absolute after:w-4 after:h-4 after:bg-white after:rounded-full after:top-0.5 after:left-0.5 checked:after:left-5.5 after:transition-all">
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50 text-right">
                <button class="bg-sena-500 text-white font-black px-10 py-5 rounded-3xl text-xs uppercase tracking-[0.2em] shadow-xl shadow-sena-500/20 hover:scale-105 active:scale-95 transition-all">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
@endsection
