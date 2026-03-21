@extends('layouts.asesor')

@section('title', 'Registro de Actividad - APE Advisor')

@section('content')
<div class="mb-10 flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-black text-gray-900 leading-tight">Registro de Actividad</h2>
        <p class="text-gray-500 text-sm font-medium mt-1">Bitácora completa y detallada de tus atenciones realizadas.</p>
    </div>
    <div class="flex items-center space-x-3 bg-white px-6 py-3 rounded-2xl shadow-sm border border-gray-100 italic text-[10px] font-black text-gray-400 uppercase tracking-widest">
        <i class="fa-solid fa-clock-rotate-left text-sena-500"></i>
        <span>Historial en Tiempo Real</span>
    </div>
</div>

<div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
        <div class="flex items-center space-x-4">
            <div class="px-4 py-2 bg-sena-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest">Hoy</div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ now()->format('d M, Y') }}</div>
        </div>
        <div class="flex items-center space-x-2">
            <button class="w-10 h-10 flex items-center justify-center bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-sena-500 transition-all"><i class="fa-solid fa-filter text-xs"></i></button>
            <button class="w-10 h-10 flex items-center justify-center bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-sena-500 transition-all"><i class="fa-solid fa-download text-xs"></i></button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50">
                    <th class="px-10 py-6">Turno / ID</th>
                    <th class="px-10 py-6">Información del Ciudadano</th>
                    <th class="px-10 py-6">Intervalo de Atención</th>
                    <th class="px-10 py-6">Duración Estimada</th>
                    <th class="px-10 py-6 text-center">Estado del Proceso</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($atenciones as $atn)
                <tr class="hover:bg-gray-50/50 transition-colors group cursor-default">
                    <td class="px-10 py-8">
                        <div class="flex flex-col">
                            <span class="text-sm font-black text-gray-900 group-hover:text-sena-500 transition-colors">{{ $atn->turno->tur_numero }}</span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter mt-1">Ticket #{{ str_pad($atn->atnc_id ?? rand(100, 999), 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 font-black text-xs group-hover:bg-sena-50 group-hover:text-sena-500 transition-all uppercase">
                                {{ substr($atn->turno->persona->pers_nombres, 0, 1) }}{{ substr($atn->turno->persona->pers_apellidos, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-black text-gray-900 leading-tight">{{ $atn->turno->persona->pers_nombres }} {{ $atn->turno->persona->pers_apellidos }}</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">D.I. {{ $atn->turno->persona->pers_doc }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex flex-col space-y-1">
                            <div class="flex items-center space-x-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span class="text-xs font-bold text-gray-600 italic">Entrada: {{ is_string($atn->atnc_hora_inicio) ? date('h:i A', strtotime($atn->atnc_hora_inicio)) : $atn->atnc_hora_inicio->format('h:i A') }}</span>
                            </div>
                            @if($atn->atnc_hora_fin)
                            <div class="flex items-center space-x-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                <span class="text-xs font-bold text-gray-600 italic">Salida: {{ is_string($atn->atnc_hora_fin) ? date('h:i A', strtotime($atn->atnc_hora_fin)) : $atn->atnc_hora_fin->format('h:i A') }}</span>
                            </div>
                            @else
                            <div class="flex items-center space-x-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                                <span class="text-xs font-black text-blue-500 uppercase tracking-tighter">Atención Activa</span>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-10 py-8">
                        <div class="flex flex-col">
                            <span class="text-xs font-black text-gray-800">12 min 45s</span>
                            <div class="w-20 bg-gray-100 h-1 rounded-full mt-2 overflow-hidden">
                                <div class="bg-sena-500 h-full rounded-full" style="width: 70%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-8 text-center">
                        @if($atn->atnc_hora_fin)
                            <div class="inline-flex items-center space-x-2 bg-emerald-50 text-emerald-600 text-[10px] font-black px-5 py-2 rounded-xl border border-emerald-100 uppercase tracking-widest">
                                <i class="fa-solid fa-check-double"></i>
                                <span>Atendido</span>
                            </div>
                        @else
                            <div class="inline-flex items-center space-x-2 bg-blue-50 text-blue-600 text-[10px] font-black px-5 py-2 rounded-xl border border-blue-100 uppercase tracking-widest animate-pulse">
                                <i class="fa-solid fa-spinner fa-spin"></i>
                                <span>En Proceso</span>
                            </div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-8 bg-gray-50/50 border-t border-gray-50 flex justify-center">
        <button class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-sena-500 transition-all flex items-center space-x-2">
            <span>Cargar más registros</span>
            <i class="fa-solid fa-chevron-down"></i>
        </button>
    </div>
</div>
@endsection
