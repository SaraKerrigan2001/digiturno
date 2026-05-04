@extends('layouts.asesor')

@section('title', 'Manual del Asesor - SENA APE')

@section('content')
<div id="manual-content" class="bg-gray-50/30">
    <div class="mb-8 print:hidden italic">
        <h1 class="text-2xl font-black text-gray-900 leading-tight">Guía Operativa del Asesor</h1>
        <p class="text-gray-400 text-sm font-bold mt-1 uppercase tracking-widest">Agencia Pública de Empleo - SENA</p>
    </div>

    <!-- Contenido -->
    <div class="space-y-6">
        <!-- Section 1: Atención -->
        <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100 print:shadow-none print:border-sena-500 print:border-2">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-10 h-10 bg-sena-50 text-sena-500 rounded-xl flex items-center justify-center text-lg">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter">1. Gestión de la Atención</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="space-y-3">
                    <div class="text-[9px] font-black text-emerald-500 bg-emerald-50 py-1.5 rounded-full uppercase tracking-widest">Llamar</div>
                    <p class="text-[11px] text-gray-600 leading-relaxed font-medium">Use **"Llamar Siguiente"** para asignar el turno en espera.</p>
                </div>
                <div class="space-y-3">
                    <div class="text-[9px] font-black text-blue-500 bg-blue-50 py-1.5 rounded-full uppercase tracking-widest">Atender</div>
                    <p class="text-[11px] text-gray-600 leading-relaxed font-medium">Visualice los datos del ciudadano y controle el tiempo.</p>
                </div>
                <div class="space-y-3">
                    <div class="text-[9px] font-black text-red-500 bg-red-50 py-1.5 rounded-full uppercase tracking-widest">Cerrar</div>
                    <p class="text-[11px] text-gray-600 leading-relaxed font-medium">Presione **"Finalizar"** al terminar para quedar disponible.</p>
                </div>
            </div>
        </div>

        <!-- Section 2: Estados -->
        <div class="bg-white p-6 rounded-[1.5rem] shadow-sm border border-gray-100 print:shadow-none print:border-sena-500 print:border-2">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-lg">
                    <i class="fa-solid fa-pause"></i>
                </div>
                <h3 class="text-lg font-black text-gray-900 uppercase tracking-tighter">2. Pausas y Recesos</h3>
            </div>
            <p class="text-[11px] text-gray-600 font-bold mb-4 italic leading-relaxed">
                Es fundamental marcar sus pausas para que el sistema no le asigne ciudadanos mientras no está en su puesto.
            </p>
            <div class="bg-amber-50 p-5 rounded-2xl border border-amber-100 flex items-start space-x-3">
                <i class="fa-solid fa-circle-exclamation text-amber-500 text-xs mt-0.5"></i>
                <p class="text-[10px] text-amber-800 font-bold leading-relaxed uppercase tracking-wide">
                    Al activar el modo pausa, su estado en el monitor del coordinador cambiará a "Receso" y el tiempo de sesión se detendrá.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 flex justify-end print:hidden">
    <button id="download-pdf-asesor" class="bg-gray-900 text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest flex items-center space-x-3 hover:bg-black transition-all shadow-xl active:scale-95 text-[10px]">
        <i class="fa-solid fa-download"></i>
        <span>Guardar Manual PDF</span>
    </button>
</div>

<style>
    /* Estilos específicos para la generación del PDF */
    .pdf-mode {
        width: 800px !important;
        padding: 40px !important;
        background: white !important;
        color: #1a202c !important;
    }
    .pdf-mode .rounded-\[3\.5rem\] {
        border-radius: 1.5rem !important;
        border: 2px solid #f3f4f6 !important;
    }
    .pdf-mode h1 { font-size: 32px !important; }
    .pdf-mode h3 { font-size: 20px !important; }
    .pdf-mode p { font-size: 14px !important; }
</style>

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById('download-pdf-asesor').addEventListener('click', function() {
        const reportArea = document.getElementById('manual-content');
        const btn = this;
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin"></i><span>PROCESANDO...</span>';
        btn.disabled = true;

        const mainEl = document.querySelector('main');
        if(mainEl) {
            mainEl.style.overflow = 'visible';
            mainEl.style.height = 'auto';
        }

        const opt = {
            margin:       [15, 10, 15, 10],
            filename:     'Manual_Asesor_APE.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true, scrollY: 0 },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(reportArea).save().then(() => {
            if(mainEl) {
                mainEl.style.overflow = '';
                mainEl.style.height = '';
            }
            btn.innerHTML = originalText || '<i class="fa-solid fa-download"></i><span>Guardar Manual PDF</span>';
            btn.disabled = false;
        }).catch(err => {
            console.error('Error generating PDF:', err);
            if(mainEl) {
                mainEl.style.overflow = '';
                mainEl.style.height = '';
            }
            btn.innerHTML = originalText || '<i class="fa-solid fa-download"></i><span>Guardar Manual PDF</span>';
            btn.disabled = false;
        });
    });
</script>
@endsection
@endsection
