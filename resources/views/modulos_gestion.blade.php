@extends('layouts.coordinador')

@section('title', 'Gestión de Módulos - SENA APE')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-black text-gray-900 leading-tight">Gestión de Personal</h1>
        <p class="text-gray-500 text-sm font-medium mt-1">Administra los puntos de atención y asesores disponibles.</p>
    </div>
    <button class="bg-sena-500 text-white px-6 py-3 rounded-2xl text-[11px] font-black shadow-lg hover:bg-sena-600 transition flex items-center space-x-2 uppercase tracking-widest">
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Nuevo Asesor</span>
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
    @foreach($asesores as $ase)
    <div class="bg-white p-8 rounded-[2rem] shadow-[0_2px_10px_-3px_rgba(0,0,0,0.02)] border border-gray-100 hover:shadow-xl transition-all duration-300 group">
        <div class="flex items-start justify-between mb-8">
            <div class="w-14 h-14 bg-sena-50 text-sena-500 rounded-2xl flex items-center justify-center font-black text-xl border border-sena-100/50 group-hover:scale-110 transition-transform">
                {{ sprintf('%02d', $ase->ase_id) }}
            </div>
            <span class="px-3 py-1 rounded-full text-[9px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 tracking-widest">ACTIVO</span>
        </div>
        
        <div class="mb-8">
            <h3 class="text-lg font-black text-gray-900">{{ $ase->persona->pers_nombres }} {{ $ase->persona->pers_apellidos }}</h3>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-wide mt-1">{{ $ase->ase_correo }}</p>
        </div>

        <div class="space-y-3 mb-8">
            <div class="flex items-center space-x-3 text-xs text-gray-500 font-medium bg-gray-50 p-3 rounded-xl">
                <i class="fa-solid fa-file-contract text-gray-400"></i>
                <span class="text-[10px] font-bold">Contrato: {{ $ase->ase_nrocontrato }}</span>
            </div>
        </div>

        <div class="flex space-x-3">
            <button class="flex-1 bg-white border border-gray-100 text-gray-600 py-3 rounded-xl text-[10px] font-black hover:bg-gray-50 transition uppercase tracking-widest shadow-sm">
                Ver Perfil
            </button>
            <button class="flex-1 bg-gray-900 text-white py-3 rounded-xl text-[10px] font-black hover:bg-black transition uppercase tracking-widest shadow-lg">
                Reasignar
            </button>
        </div>
    </div>
    @endforeach
</div>
@endsection
