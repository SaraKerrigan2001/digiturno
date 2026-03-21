@extends('layouts.coordinador')

@section('title', 'Historial de Turnos - SENA APE')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-gray-900 leading-tight">Historial de Turnos</h1>
    <p class="text-gray-500 text-sm font-medium mt-1">Listado detallado de todas las atenciones generadas hoy.</p>
</div>

<div class="bg-white rounded-[2rem] shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50/50 text-gray-400 text-[10px] uppercase tracking-[0.15em] font-black border-b border-gray-100">
                <tr>
                    <th class="px-8 py-5">Turno</th>
                    <th class="px-8 py-5">Solicitante</th>
                    <th class="px-8 py-5">Tipo</th>
                    <th class="px-8 py-5">Fecha / Hora</th>
                    <th class="px-8 py-5 text-center">Estado</th>
                    <th class="px-8 py-5">Asesor Asignado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($turnos as $t)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-8 py-5">
                        <span class="text-sm font-black text-sena-500 bg-sena-50 px-3 py-1 rounded-lg">#{{ $t->tur_numero }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="text-sm font-bold text-gray-900">{{ $t->solicitante->persona->pers_nombres }} {{ $t->solicitante->persona->pers_apellidos }}</div>
                        <div class="text-[10px] text-gray-400 font-bold mt-0.5">ID: {{ $t->solicitante->persona->pers_doc }}</div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-[10px] font-black text-gray-600 bg-gray-100 px-2 py-0.5 rounded uppercase tracking-wider">{{ $t->tur_tipo }}</span>
                    </td>
                    <td class="px-8 py-5 text-[11px] text-gray-500 font-bold">{{ $t->tur_hora_fecha }}</td>
                    <td class="px-8 py-5 text-center">
                        @if($t->atencion)
                            <span class="px-3 py-1 rounded-full text-[9px] font-black bg-green-50 text-green-600 border border-green-100 uppercase tracking-widest">ATENDIDO</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-[9px] font-black bg-amber-50 text-amber-600 border border-amber-100 uppercase tracking-widest">EN ESPERA</span>
                        @endif
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-user-tie text-gray-200 text-xs"></i>
                            <span class="text-sm font-bold text-gray-700">
                                {{ $t->atencion && $t->atencion->asesor ? ($t->atencion->asesor->persona->pers_nombres ?? 'Módulo '.$t->atencion->ASESOR_ase_id) : 'Pendiente' }}
                            </span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
        {{ $turnos->links() }}
    </div>
</div>
@endsection
