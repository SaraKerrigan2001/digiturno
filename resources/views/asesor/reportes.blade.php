@extends('layouts.asesor')

@section('title', 'Reportes de Desempeño - APE Advisor')

@section('content')
<div class="mb-10 flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-black text-gray-900 leading-tight">Analítica de Atención</h2>
        <p class="text-gray-500 text-sm font-medium mt-1">Resumen estadístico de tu productividad y calidad de servicio.</p>
    </div>
    <div class="flex items-center space-x-4">
        <button onclick="downloadPDF()" class="bg-sena-500 text-white font-black px-8 py-3 rounded-2xl text-[10px] uppercase tracking-widest shadow-xl shadow-sena-500/20 hover:scale-105 active:scale-95 transition-all flex items-center space-x-2">
            <i class="fa-solid fa-file-pdf"></i>
            <span>Descargar PDF Pro</span>
        </button>
        <select class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-gray-100 text-xs font-black text-gray-700 uppercase tracking-widest outline-none">
            <option>Últimos 7 días</option>
            <option>Este Mes</option>
            <option>Año Actual</option>
        </select>
    </div>
</div>

<div id="report-content" class="space-y-8">
    <!-- Fila 1: KPIs Principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Atendidos</p>
            <h4 class="text-4xl font-black text-gray-900">{{ $metas['diaria_actual'] }}</h4>
            <div class="mt-4 flex items-center text-emerald-500 space-x-1">
                <i class="fa-solid fa-caret-up text-xs"></i>
                <span class="text-[10px] font-black tracking-widest">+8.2% vs ayer</span>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">T. Promedio</p>
            <h4 class="text-4xl font-black text-gray-900">{{ $metas['atencion_actual'] }} <span class="text-sm">min</span></h4>
            <div class="mt-4 flex items-center text-amber-500 space-x-1">
                <i class="fa-solid fa-caret-down text-xs"></i>
                <span class="text-[10px] font-black tracking-widest">-1.1% mejora</span>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Calificación</p>
            <h4 class="text-4xl font-black text-gray-900">{{ $metas['calificacion'] }}</h4>
            <div class="mt-4 flex items-center text-emerald-500 space-x-1">
                <i class="fa-solid fa-star text-xs"></i>
                <span class="text-[10px] font-black tracking-widest">Nivel Excelente</span>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Meta Diaria</p>
            <h4 class="text-4xl font-black text-gray-900">{{ round(($metas['diaria_actual']/$metas['diaria_meta'])*100) }}%</h4>
            <div class="mt-4 flex items-center text-blue-500 space-x-1">
                <span class="text-[10px] font-black tracking-widest">{{ $metas['diaria_actual'] }} / {{ $metas['diaria_meta'] }} tickets</span>
            </div>
        </div>
    </div>

    <!-- Fila 2: Gráficos de Distribución y Flujo -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-1 bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100 text-center">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-8">Distribución por Tipo</h4>
            <div class="h-64 flex items-center justify-center">
                <canvas id="typeDistributionChart"></canvas>
            </div>
        </div>
        <div class="xl:col-span-2 bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-8">Flujo Semanal de Ciudadanos</h4>
            <div class="h-64">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Fila 3: Objetivos vs Real y Top Trámites -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Comparativa de Metas (Tiempo)</h4>
            <div class="space-y-8">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-bold text-gray-700">Tiempo de Atención (Meta: 12 min)</span>
                        <span class="text-sm font-black text-emerald-500">{{ $metas['atencion_actual'] }} min</span>
                    </div>
                    <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, (12/max(1, $metas['atencion_actual']))*100) }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-bold text-gray-700">Capacidad Diaria (Meta: 50 turns)</span>
                        <span class="text-sm font-black text-blue-500">{{ $metas['diaria_actual'] }} turns</span>
                    </div>
                    <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                        <div class="bg-blue-500 h-full rounded-full" style="width: {{ ($metas['diaria_actual']/$metas['diaria_meta'])*100 }}%"></div>
                    </div>
                </div>
                <div class="p-5 bg-sena-50 rounded-2xl border border-sena-100">
                    <p class="text-xs font-bold text-sena-700 leading-relaxed italic">"Estás superando tu meta de tiempo en un 15%. Mantén este ritmo para mejorar tu KPI de volumen."</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Top Trámites Realizados</h4>
            <div class="space-y-4">
                @foreach($topTramites as $tramite)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 rounded-full {{ $tramite['color'] }}"></div>
                        <span class="text-sm font-bold text-gray-700 group-hover:text-gray-900 transition-colors">{{ $tramite['nombre'] }}</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-xs font-black text-gray-400">{{ $tramite['count'] }} tickets</span>
                        <div class="w-24 bg-gray-50 h-1.5 rounded-full overflow-hidden">
                            <div class="h-full {{ $tramite['color'] }}" style="width: {{ ($tramite['count']/85)*100 }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Fila 4: Mapa de Calor y Feedback -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-8">Mapa de Calor de Productividad</h4>
            <div class="grid grid-cols-12 gap-2 text-center text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-2">
                <div>8am</div><div>9am</div><div>10am</div><div>11am</div><div>12pm</div><div>1pm</div><div>2pm</div><div>3pm</div><div>4pm</div><div>5pm</div><div>6pm</div><div>7pm</div>
            </div>
            <div class="grid grid-rows-6 gap-2">
                @for($l=0; $l<6; $l++)
                <div class="flex items-center space-x-2">
                    <span class="w-8 text-[9px] text-gray-400 font-black uppercase">{{ ['L','M','Mi','J','V','S'][$l] }}</span>
                    <div class="flex-1 grid grid-cols-12 gap-1.5 h-6">
                        @for($h=0; $h<12; $h++)
                            @php $rand = rand(10, 90); @endphp
                            <div class="group relative rounded-md transition-all hover:scale-110 cursor-pointer" 
                                 style="background-color: rgba(57, 169, 0, {{ $rand/100 }});"
                                 title="Prod: {{ $rand }}%">
                            </div>
                        @endfor
                    </div>
                </div>
                @endfor
            </div>
            <div class="mt-6 flex items-center justify-end space-x-4">
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Baja</span>
                <div class="flex space-x-1">
                    <div class="w-4 h-4 rounded bg-sena-50"></div>
                    <div class="w-4 h-4 rounded bg-sena-200"></div>
                    <div class="w-4 h-4 rounded bg-sena-500"></div>
                    <div class="w-4 h-4 rounded bg-sena-700"></div>
                </div>
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Alta Especialización</span>
            </div>
        </div>
        <div class="xl:col-span-1 bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100 flex flex-col">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6 text-center">Calificaciones Recientes</h4>
            <div class="flex-1 space-y-5">
                @foreach($feedback as $fb)
                <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100 hover:border-sena-200 transition-all cursor-default group">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 rounded-full bg-sena-500 flex items-center justify-center text-white text-[10px] font-black">{{ substr($fb['user'], 0, 1) }}</div>
                            <span class="text-xs font-black text-gray-900">{{ $fb['user'] }}</span>
                        </div>
                        <div class="flex text-amber-400 text-[10px]">
                            @for($i=0; $i<$fb['stars']; $i++) <i class="fa-solid fa-star"></i> @endfor
                        </div>
                    </div>
                    <p class="text-[11px] text-gray-500 leading-relaxed font-medium">"{{ $fb['comentario'] }}"</p>
                    <p class="text-[9px] text-gray-300 font-black uppercase tracking-widest mt-2">{{ $fb['time'] }}</p>
                </div>
                @endforeach
            </div>
            <button class="mt-6 w-full py-3 bg-gray-900 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest hover:bg-black transition-all">Ver todos los comentarios</button>
        </div>
    </div>

    <!-- Fila 5: Registro Detallado (Tabla) -->
    <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 mt-8">
        <div class="flex items-center justify-between mb-8">
            <h4 class="text-sm font-black text-gray-900 tracking-wide uppercase">Registro Detallado de Actividad</h4>
            <span class="px-4 py-1.5 bg-gray-50 text-[10px] font-black text-gray-400 rounded-full border border-gray-100">Mostrando últimos 5 registros</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Turno ID</th>
                        <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Hora Inicio</th>
                        <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Categoría</th>
                        <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Duración</th>
                        <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($registros as $reg)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="py-5">
                            <span class="text-xs font-black text-gray-900 py-1.5 px-3 bg-gray-100 rounded-lg">{{ $reg['id'] }}</span>
                        </td>
                        <td class="py-5 text-xs font-bold text-gray-600">{{ $reg['hora'] }}</td>
                        <td class="py-5">
                            <span class="text-[10px] font-black uppercase tracking-widest py-1 px-3 rounded-full {{ $reg['tipo'] == 'General' ? 'text-emerald-600 bg-emerald-50' : ($reg['tipo'] == 'Prioritario' ? 'text-amber-600 bg-amber-50' : 'text-blue-600 bg-blue-50') }}">
                                {{ $reg['tipo'] }}
                            </span>
                        </td>
                        <td class="py-5 text-xs font-black text-gray-900">{{ $reg['duracion'] }}</td>
                        <td class="py-5">
                            <div class="flex items-center space-x-2 text-emerald-500 text-left">
                                <i class="fa-solid fa-circle-check text-[10px]"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ $reg['status'] }}</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function downloadPDF() {
        const reportArea = document.getElementById('report-content');
        
        // Crear un contenedor temporal oculto para la exportación
        const tempContainer = document.createElement('div');
        tempContainer.style.position = 'fixed';
        tempContainer.style.left = '-10000px';
        tempContainer.style.top = '0';
        tempContainer.style.width = '1200px'; 
        tempContainer.style.background = '#F0F2F5';
        tempContainer.style.padding = '40px';
        tempContainer.style.fontFamily = 'Inter, sans-serif';
        tempContainer.id = 'pdf-export-container';
        
        // Añadir cabecera al PDF
        const header = `
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; border-bottom:3px solid #39A900; padding-bottom:15px;">
                <div>
                    <h1 style="font-size:28px; font-weight:900; color:#1a202c; margin:0; letter-spacing:-1px;">INFORME INTEGRAL DE DESEMPEÑO</h1>
                    <p style="font-size:12px; color:#718096; margin:3px 0 0; font-weight:700; text-transform:uppercase; letter-spacing:1px;">APE SENA - Gestión de Turnos Digital</p>
                </div>
                <div style="text-align:right;">
                    <p style="font-size:11px; font-weight:800; color:#39A900; text-transform:uppercase; margin:0;">Corte: ${new Date().toLocaleDateString()}</p>
                    <p style="font-size:11px; color:#a0aec0; margin:3px 0 0;">ID Asesor: {{ $asesor->ase_id ?? '1' }}</p>
                </div>
            </div>
        `;
        
        tempContainer.innerHTML = header;
        
        // Clonar el contenido del reporte
        const clone = reportArea.cloneNode(true);
        
        // Copiar el contenido de los canvas
        const originalCanvases = reportArea.querySelectorAll('canvas');
        const clonedCanvases = clone.querySelectorAll('canvas');
        originalCanvases.forEach((canv, index) => {
            const context = clonedCanvases[index].getContext('2d');
            clonedCanvases[index].width = canv.width;
            clonedCanvases[index].height = canv.height;
            context.drawImage(canv, 0, 0);
        });

        // Ajustar estilos del clon para el PDF (Asegurar que no se corten las secciones)
        const grids = clone.querySelectorAll('.grid');
        grids.forEach(g => {
            if (g.classList.contains('xl:grid-cols-4')) g.style.gridTemplateColumns = 'repeat(4, 1fr)';
            if (g.classList.contains('xl:grid-cols-3')) g.style.gridTemplateColumns = 'repeat(3, 1fr)';
            if (g.classList.contains('xl:grid-cols-2')) g.style.gridTemplateColumns = 'repeat(2, 1fr)';
            g.style.gap = '20px';
            g.style.display = 'grid';
        });

        const chartContainers = clone.querySelectorAll('.h-64, .h-96');
        chartContainers.forEach(c => {
            c.style.height = '240px';
        });

        tempContainer.appendChild(clone);
        document.body.appendChild(tempContainer);

        const opt = {
            margin:       [5, 5, 5, 5],
            filename:     'Reporte_Pro_APE_{{ $asesor->ase_id ?? '1' }}.pdf',
            image:        { type: 'jpeg', quality: 1.0 },
            html2canvas:  { 
                scale: 2, 
                useCORS: true,
                logging: false,
                windowWidth: 1200
            },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(tempContainer).save().then(() => {
            document.body.removeChild(tempContainer);
        });
    }

    // Gráfico de Distribución (Pie)
    const ctxType = document.getElementById('typeDistributionChart').getContext('2d');
    new Chart(ctxType, {
        type: 'doughnut',
        data: {
            labels: ['General', 'Prioritario', 'Víctimas'],
            datasets: [{
                data: [{{ $distribucionTipos['General'] }}, {{ $distribucionTipos['Prioritario'] }}, {{ $distribucionTipos['Víctimas'] }}],
                backgroundColor: ['#39A900', '#F6AD55', '#3182CE'],
                borderWidth: 0,
                cutout: '70%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 9, weight: 'bold' } } } }
        }
    });

    // Gráfico de Flujo Semanal
    const ctxFlow = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctxFlow, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            datasets: [{
                label: 'Atenciones',
                data: [32, 45, 38, 52, 48, 30],
                borderColor: '#39A900',
                backgroundColor: 'rgba(57, 169, 0, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderWidth: 2,
                pointBorderColor: '#39A900'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { 
                y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: { size: 10 } } },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });
</script>
@endsection
