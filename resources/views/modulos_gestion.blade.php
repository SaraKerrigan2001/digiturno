@extends('layouts.coordinador')

@section('title', 'Gestión de Módulos - SENA APE')

@section('content')

{{-- Toasts --}}
@if(session('success'))
<div id="toast-success" class="fixed top-6 right-6 z-[9999] bg-white border border-emerald-100 rounded-2xl px-5 py-4 shadow-2xl flex items-center space-x-3 min-w-[280px]">
    <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500"><i class="fa-solid fa-circle-check"></i></div>
    <p class="text-sm font-bold text-gray-800">{{ session('success') }}</p>
    <button onclick="document.getElementById('toast-success').remove()" class="ml-auto text-gray-300 hover:text-gray-500"><i class="fa-solid fa-xmark"></i></button>
</div>
@endif
@if(session('error'))
<div id="toast-error" class="fixed top-6 right-6 z-[9999] bg-white border border-red-100 rounded-2xl px-5 py-4 shadow-2xl flex items-center space-x-3 min-w-[280px]">
    <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center text-red-500"><i class="fa-solid fa-circle-xmark"></i></div>
    <p class="text-sm font-bold text-gray-800">{{ session('error') }}</p>
    <button onclick="document.getElementById('toast-error').remove()" class="ml-auto text-gray-300 hover:text-gray-500"><i class="fa-solid fa-xmark"></i></button>
</div>
@endif

{{-- Header --}}
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-black text-gray-900 leading-tight">Gestión de Personal</h1>
        <p class="text-gray-500 text-sm font-medium mt-1">Administra los asesores y sus accesos al sistema.</p>
    </div>
    <button onclick="openModal('modal-create')" class="bg-sena-500 text-white px-6 py-3 rounded-2xl text-[11px] font-black shadow-lg hover:bg-sena-600 transition flex items-center space-x-2 uppercase tracking-widest">
        <i class="fa-solid fa-plus text-xs"></i>
        <span>Nuevo Asesor</span>
    </button>
</div>

{{-- Stats bar --}}
<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center space-x-3">
        <div class="w-10 h-10 bg-sena-50 rounded-xl flex items-center justify-center text-sena-500"><i class="fa-solid fa-users"></i></div>
        <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Asesores</p><p class="text-xl font-black text-gray-900">{{ count($asesores) }}</p></div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center space-x-3">
        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500"><i class="fa-solid fa-circle-dot"></i></div>
        <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Activos</p><p class="text-xl font-black text-gray-900">{{ count($asesores) }}</p></div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-4 flex items-center space-x-3">
        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500"><i class="fa-solid fa-grid-2"></i></div>
        <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Módulos</p><p class="text-xl font-black text-gray-900">{{ count($asesores) }}/10</p></div>
    </div>
</div>

{{-- Advisors Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($asesores as $ase)
    <div data-search="{{ $ase->persona->pers_nombres ?? '' }} {{ $ase->persona->pers_apellidos ?? '' }} modulo {{ sprintf('%02d', $ase->ase_id) }} {{ $ase->ase_correo }} {{ $ase->persona->pers_doc ?? '' }}" class="searchable-item bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col">
        
        {{-- Header --}}
        <div class="flex items-start justify-between mb-5">
            <div class="flex items-center space-x-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($ase->persona->pers_nombres ?? 'Asesor') }}&background=39A900&color=fff&bold=true&size=80" 
                     class="w-12 h-12 rounded-2xl border-2 border-sena-100 object-cover group-hover:border-sena-300 transition">
                <div>
                    <h3 class="text-sm font-black text-gray-900 leading-snug">{{ $ase->persona->pers_nombres ?? 'N/A' }} {{ $ase->persona->pers_apellidos ?? '' }}</h3>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Módulo {{ sprintf('%02d', $ase->ase_id) }}</p>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-full text-[9px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 tracking-widest uppercase">Activo</span>
        </div>

        {{-- Info --}}
        <div class="space-y-2 flex-1 mb-5">
            <div class="flex items-center space-x-2 text-xs text-gray-500 bg-gray-50 px-3 py-2.5 rounded-xl">
                <i class="fa-solid fa-envelope text-gray-300 w-4 text-center"></i>
                <span class="font-medium truncate">{{ $ase->ase_correo }}</span>
            </div>
            <div class="flex items-center space-x-2 text-xs text-gray-500 bg-gray-50 px-3 py-2.5 rounded-xl">
                <i class="fa-solid fa-id-card text-gray-300 w-4 text-center"></i>
                <span class="font-medium">Doc: {{ $ase->persona->pers_doc ?? 'N/A' }}</span>
            </div>
            @if($ase->ase_nrocontrato)
            <div class="flex items-center space-x-2 text-xs text-gray-500 bg-gray-50 px-3 py-2.5 rounded-xl">
                <i class="fa-solid fa-file-contract text-gray-300 w-4 text-center"></i>
                <span class="font-medium">Contrato: {{ $ase->ase_nrocontrato }}</span>
            </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex space-x-2 pt-4 border-t border-gray-50">
            <button onclick="openEditModal({{ json_encode($ase) }}, {{ json_encode($ase->persona) }})" 
                    class="flex-1 bg-gray-50 hover:bg-sena-50 border border-gray-100 hover:border-sena-100 text-gray-600 hover:text-sena-600 py-2.5 rounded-xl text-[10px] font-black transition uppercase tracking-widest">
                <i class="fa-solid fa-pen-to-square mr-1.5"></i> Editar
            </button>
            <button onclick="openDeleteModal({{ $ase->ase_id }}, '{{ $ase->persona->pers_nombres ?? 'Asesor' }} {{ $ase->persona->pers_apellidos ?? '' }}')"
                    class="flex-1 bg-red-50 hover:bg-red-100 border border-red-100 text-red-500 py-2.5 rounded-xl text-[10px] font-black transition uppercase tracking-widest">
                <i class="fa-solid fa-trash-can mr-1.5"></i> Eliminar
            </button>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-24">
        <i class="fa-solid fa-users-slash text-gray-200 text-5xl mb-4"></i>
        <p class="font-black text-gray-400 uppercase tracking-widest text-sm">Sin Asesores Registrados</p>
        <p class="text-xs text-gray-400 mt-1">Haga clic en "Nuevo Asesor" para comenzar.</p>
    </div>
    @endforelse
</div>

{{-- ==================== MODAL: CREAR ASESOR ==================== --}}
<div id="modal-create" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-create')"></div>
    <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-sena-500 to-sena-400 p-7 rounded-t-[2.5rem] flex items-center justify-between sticky top-0 z-10">
            <div>
                <h2 class="text-lg font-black text-white">Registrar Nuevo Asesor</h2>
                <p class="text-sena-100 text-xs font-medium mt-0.5">Completa todos los campos requeridos</p>
            </div>
            <button onclick="closeModal('modal-create')" class="w-9 h-9 bg-white/20 hover:bg-white/30 rounded-xl flex items-center justify-center text-white transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form action="{{ route('coordinador.asesores.store') }}" method="POST" class="p-7 space-y-5">
            @csrf
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-3">Datos Personales</p>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-1">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Tipo Documento *</label>
                    <select name="pers_tipodoc" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-sena-400">
                        <option value="CC">Cédula de Ciudadanía (CC)</option>
                        <option value="CE">Cédula de Extranjería (CE)</option>
                        <option value="TI">Tarjeta de Identidad (TI)</option>
                        <option value="PAS">Pasaporte (PAS)</option>
                    </select>
                </div>
                <div class="col-span-1">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Número de Documento *</label>
                    <input type="text" name="pers_doc" required placeholder="Ej: 1012345678" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Nombres *</label>
                    <input type="text" name="pers_nombres" required placeholder="Nombre(s) completo(s)" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Apellidos *</label>
                    <input type="text" name="pers_apellidos" required placeholder="Apellido(s) completo(s)" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Teléfono</label>
                    <input type="text" name="pers_telefono" placeholder="Ej: 3001234567" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
            </div>

            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 pb-3 pt-2">Credenciales del Sistema</p>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Correo Electrónico *</label>
                    <input type="email" name="ase_correo" required placeholder="correo@sena.edu.co" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Contraseña *</label>
                    <input type="password" name="ase_password" required placeholder="Mín. 6 caracteres" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">N° Contrato</label>
                    <input type="text" name="ase_nrocontrato" placeholder="Ej: CONT-20260101" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
            </div>

            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeModal('modal-create')" class="flex-1 bg-gray-50 border border-gray-200 text-gray-500 font-black py-3.5 rounded-2xl text-[11px] uppercase tracking-widest hover:bg-gray-100 transition">Cancelar</button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-sena-500 to-sena-400 text-white font-black py-3.5 rounded-2xl text-[11px] uppercase tracking-widest hover:from-sena-600 hover:to-sena-500 transition shadow-lg shadow-sena-500/20">
                    <i class="fa-solid fa-plus mr-2"></i> Registrar Asesor
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL: EDITAR ASESOR ==================== --}}
<div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-edit')"></div>
    <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-gray-800 to-gray-700 p-7 rounded-t-[2.5rem] flex items-center justify-between sticky top-0 z-10">
            <div>
                <h2 class="text-lg font-black text-white">Editar Asesor</h2>
                <p class="text-gray-400 text-xs font-medium mt-0.5" id="edit-modal-subtitle">Modifica los datos del asesor</p>
            </div>
            <button onclick="closeModal('modal-edit')" class="w-9 h-9 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center text-white transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="form-edit" method="POST" class="p-7 space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Nombres</label>
                    <input type="text" name="pers_nombres" id="edit-pers_nombres" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Apellidos</label>
                    <input type="text" name="pers_apellidos" id="edit-pers_apellidos" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Teléfono</label>
                    <input type="text" name="pers_telefono" id="edit-pers_telefono" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Correo</label>
                    <input type="email" name="ase_correo" id="edit-ase_correo" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">Nueva Contraseña (opcional)</label>
                    <input type="password" name="ase_password" placeholder="Dejar en blanco para no cambiar" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1.5">N° Contrato</label>
                    <input type="text" name="ase_nrocontrato" id="edit-ase_nrocontrato" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-sena-400">
                </div>
            </div>
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeModal('modal-edit')" class="flex-1 bg-gray-50 border border-gray-200 text-gray-500 font-black py-3.5 rounded-2xl text-[11px] uppercase tracking-widest hover:bg-gray-100 transition">Cancelar</button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-gray-800 to-gray-900 text-white font-black py-3.5 rounded-2xl text-[11px] uppercase tracking-widest hover:from-gray-700 hover:to-gray-800 transition shadow-lg">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL: ELIMINAR ==================== --}}
<div id="modal-delete" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-delete')"></div>
    <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-sm p-8 text-center">
        <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 text-2xl mx-auto mb-5">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h2 class="text-lg font-black text-gray-900 mb-2">¿Eliminar Asesor?</h2>
        <p class="text-sm text-gray-500 font-medium mb-6">Estás por eliminar a <strong id="delete-asesor-name" class="text-gray-900"></strong>. Esta acción no se puede deshacer.</p>
        <form id="form-delete" method="POST">
            @csrf
            <div class="flex space-x-3">
                <button type="button" onclick="closeModal('modal-delete')" class="flex-1 bg-gray-50 border border-gray-200 text-gray-600 font-black py-3.5 rounded-2xl text-[11px] uppercase tracking-widest hover:bg-gray-100 transition">Cancelar</button>
                <button type="submit" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-black py-3.5 rounded-2xl text-[11px] uppercase tracking-widest transition shadow-lg shadow-red-500/20">
                    Sí, Eliminar
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function openEditModal(asesor, persona) {
        document.getElementById('edit-pers_nombres').value = persona?.pers_nombres ?? '';
        document.getElementById('edit-pers_apellidos').value = persona?.pers_apellidos ?? '';
        document.getElementById('edit-pers_telefono').value = persona?.pers_telefono ?? '';
        document.getElementById('edit-ase_correo').value = asesor.ase_correo ?? '';
        document.getElementById('edit-ase_nrocontrato').value = asesor.ase_nrocontrato ?? '';
        document.getElementById('edit-modal-subtitle').textContent = 'Editando: ' + (persona?.pers_nombres ?? 'Asesor') + ' ' + (persona?.pers_apellidos ?? '');
        document.getElementById('form-edit').action = `/coordinador/modulos/update/${asesor.ase_id}`;
        openModal('modal-edit');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-asesor-name').textContent = name;
        document.getElementById('form-delete').action = `/coordinador/modulos/delete/${id}`;
        openModal('modal-delete');
    }

    // Auto-dismiss toasts after 4s
    setTimeout(() => {
        const ts = document.getElementById('toast-success');
        const te = document.getElementById('toast-error');
        if (ts) ts.remove();
        if (te) te.remove();
    }, 4000);
</script>
@endsection
