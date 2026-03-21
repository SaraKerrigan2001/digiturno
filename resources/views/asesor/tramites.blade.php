@extends('layouts.asesor')

@section('title', 'Trámites y Servicios - APE Advisor')

@section('content')
<div class="mb-10">
    <h2 class="text-3xl font-black text-gray-900 leading-tight">Catálogo de Servicios</h2>
    <p class="text-gray-500 text-sm font-medium mt-1">Gestión de trámites disponibles para la atención ciudadana.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
    @foreach([
        ['title' => 'Inscripción Hoja de Vida', 'desc' => 'Registro y actualización de perfiles en la plataforma APE.', 'icon' => 'fa-file-signature', 'color' => 'emerald'],
        ['title' => 'Orientación Laboral', 'desc' => 'Asesoria personalizada para la búsqueda efectiva de empleo.', 'icon' => 'fa-user-tie', 'color' => 'blue'],
        ['title' => 'Postulación a Vacantes', 'desc' => 'Apoyo en el proceso de aplicación a ofertas de trabajo.', 'icon' => 'fa-briefcase', 'color' => 'indigo'],
        ['title' => 'Certificaciones', 'desc' => 'Generación de certificados de inscripción y participación.', 'icon' => 'fa-certificate', 'color' => 'amber'],
        ['title' => 'Talleres APE', 'desc' => 'Inscripción a talleres de habilidades blandas y técnicas.', 'icon' => 'fa-users-gear', 'color' => 'rose'],
    ] as $serv)
    <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-500 group">
        <div class="w-16 h-16 bg-{{ $serv['color'] ?? 'green' }}-50 text-{{ $serv['color'] ?? 'green' }}-500 rounded-2xl flex items-center justify-center text-2xl mb-8 group-hover:scale-110 transition-transform">
            <i class="fa-solid {{ $serv['icon'] }}"></i>
        </div>
        <h3 class="text-xl font-black text-gray-900 mb-3">{{ $serv['title'] }}</h3>
        <p class="text-sm font-medium text-gray-400 leading-relaxed mb-8">{{ $serv['desc'] }}</p>
        
        <div class="flex items-center justify-between pt-6 border-t border-gray-50">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Activo</span>
            <button class="text-sena-500 font-black text-[10px] uppercase tracking-widest hover:translate-x-1 transition-transform">Configurar <i class="fa-solid fa-arrow-right ml-1"></i></button>
        </div>
    </div>
    @endforeach
</div>
@endsection
