@extends('layouts.coordinador')

@section('title', 'Manual del Coordinador - SENA APE')

@section('content')
<div id="manual-content" class="bg-gray-50/50">
    <div class="mb-12 px-6 pt-6 print:hidden">
        <h1 class="text-3xl font-black text-gray-900 leading-tight">Manual de Gestión (Coordinador)</h1>
        <p class="text-gray-500 text-lg font-medium mt-2">Instrucciones para la administración y monitoreo de la sede.</p>
    </div>

    <!-- Contenido Principal -->
    <div class="space-y-10 px-6 pb-6">
        <!-- Section 1: Dashboard -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 print:shadow-none print:border-sena-500 print:border-2">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">1. Dashboard y Control de KPIs</h3>
            </div>
            <p class="text-gray-600 font-medium leading-relaxed mb-6">
                El dashboard principal permite supervisar la operación en tiempo real. Los indicadores clave incluyen turnos atendidos y afluencia por hora.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                    <h4 class="font-black text-sena-600 text-sm mb-2">Monitor de Módulos</h4>
                    <p class="text-xs text-gray-500">Visualice en vivo qué asesores están activos, su tiempo de atención y el estado del módulo.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                    <h4 class="font-black text-blue-600 text-sm mb-2">Analítica de Flujo</h4>
                    <p class="text-xs text-gray-500">Observe la distribución de trámites y los picos de atención para optimizar el recurso humano.</p>
                </div>
            </div>
        </div>

        <!-- Section 2: Reportes -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 print:shadow-none print:border-sena-500 print:border-2">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-file-csv"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">2. Reportes y Exportación</h3>
            </div>
            <ul class="space-y-4 text-gray-600 font-medium list-disc pl-6">
                <li>Acceda al historial completo de turnos en la sección de "Reportes".</li>
                <li>Utilice el botón **"Exportar Datos"** en el header para descargar un archivo CSV compatible con Excel.</li>
                <li>Filtre la actividad por fecha o tipo de trámite según sea necesario.</li>
            </ul>
        </div>
    </div>
</div>

<div class="mt-12 bg-sena-500 rounded-[3rem] p-10 text-white flex items-center justify-between shadow-xl shadow-sena-500/20 print:hidden mx-6">
    <div class="space-y-2">
        <h4 class="text-2xl font-black italic">Documentación Oficial</h4>
        <p class="text-sm font-bold opacity-80 uppercase tracking-widest">Descargue este manual en alta resolución para su consulta física.</p>
    </div>
    <div class="flex space-x-4">
        <button id="download-pdf" class="bg-white text-sena-500 px-8 py-4 rounded-2xl text-xs font-black uppercase tracking-widest hover:scale-105 transition active:scale-95 flex items-center space-x-3 shadow-lg">
            <i class="fa-solid fa-file-pdf text-lg"></i>
            <span>Descargar PDF Pro</span>
        </button>
    </div>
</div>

<style>
    @media print {
        #manual-content { background: white !important; }
        .rounded-\[3rem\] { border-radius: 1rem !important; }
    }
</style>

<style>
    /* Estilos específicos para la generación del PDF */
    .pdf-mode {
        width: 800px !important;
        padding: 40px !important;
        background: white !important;
        color: #1a202c !important;
    }
    .pdf-mode .rounded-\[3rem\] {
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
    document.getElementById('download-pdf').addEventListener('click', function() {
        const element = document.getElementById('manual-content');
        const btn = this;
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="fa-solid fa-circle-notch animate-spin text-lg"></i><span>Generando...</span>';
        btn.disabled = true;

        const mainEl = document.querySelector('main');
        if(mainEl) {
            mainEl.style.overflow = 'visible';
            mainEl.style.height = 'auto';
        }

        const opt = {
            margin:       [10, 5, 10, 5],
            filename:     'Manual_Coordinador_APE.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true, scrollY: 0 },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(element).save().then(() => {
            if(mainEl) {
                mainEl.style.overflow = '';
                mainEl.style.height = '';
            }
            btn.innerHTML = originalText;
            btn.disabled = false;
        }).catch(err => {
            console.error('Error generating PDF:', err);
            if(mainEl) {
                mainEl.style.overflow = '';
                mainEl.style.height = '';
            }
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    });
</script>
@endsection
@endsection
