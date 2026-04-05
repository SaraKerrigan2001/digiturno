<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA APE - Kiosco Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Inter', 'sans-serif'],
                        poppins: ['Poppins', 'sans-serif']
                    },
                    colors: {
                        sena: { 
                            50: '#F0F5FF', 
                            100: '#C6D4FF', 
                            500: '#10069F', 
                            600: '#000080',
                            orange: '#FF671F',
                            yellow: '#FFB500'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url("{{ asset('images/fondo.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        /* Clean Container */
        .main-card {
            background-color: rgba(255, 255, 255, 0.85); /* Más transparente para el glassmorphism */
            backdrop-filter: blur(25px);
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Fluid Animations */
        .step-content { display: none; width: 100%; height: 100%; }
        .step-content.active { 
            display: flex; 
            animation: fadeInScale 0.7s cubic-bezier(0.23, 1, 0.32, 1) forwards; 
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(1.02); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Minimal Numpad */
        .numpad-key {
            @apply flex items-center justify-center p-6 text-3xl font-extrabold text-gray-800 bg-gray-50/50 rounded-[2rem] border border-gray-100 hover:bg-white hover:shadow-xl active:scale-90 transition-all;
        }

        /* Progress Bar */
        .progress-dot { @apply w-2.5 h-2.5 rounded-full bg-gray-200 transition-all duration-500; }
        .progress-dot.active { @apply bg-sena-500 w-8; }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #10069F; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-8">

    <div class="w-full max-w-5xl min-h-[650px] main-card rounded-[3.5rem] flex flex-col items-center relative overflow-hidden shadow-2xl">
        
        <!-- Header Centrado -->
        <header class="w-full px-12 py-10 flex flex-col items-center justify-center space-y-6 z-10">
            <div class="flex flex-col items-center space-y-4">
                <div class="w-14 h-14 bg-sena-500 rounded-2xl flex items-center justify-center shadow-2xl shadow-sena-500/20">
                    <i class="fa-solid fa-landmark text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-poppins font-black text-sena-500 tracking-tight leading-none">SENA Digital Turnos</h1>
            </div>
            
            <div class="flex items-center space-x-10 text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">
                <div onclick="toggleLanguage(); playKey();" class="flex items-center space-x-3 group cursor-pointer hover:text-sena-500 transition-colors">
                    <i class="fa-solid fa-globe text-xs group-hover:rotate-12 transition-transform"></i>
                    <span id="langLabel">ES / EN</span>
                </div>
                <div class="w-px h-4 bg-gray-200"></div>
                <div onclick="showHelp(); playKey();" class="flex items-center space-x-3 group cursor-pointer hover:text-sena-500 transition-colors">
                    <i class="fa-solid fa-circle-question text-xs group-hover:scale-110 transition-transform"></i>
                    <span id="helpLabel">AYUDA</span>
                </div>
            </div>
        </header>

        <!-- Formulario -->
        <form id="kioskForm" action="{{ route('turnos.store') }}" method="POST" onsubmit="return validateForm();" class="flex-1 w-full flex flex-col items-center justify-center">
            @csrf
            

            <!-- STEP 1: BIENVENIDA (ESTILO ORIGINAL RESTAURADO) -->
            <div id="step1" class="step-content active w-full flex-col items-center justify-center text-center p-6 md:p-10 space-y-10">
                
                <!-- Logo Box Center (Restaurado) -->
                <div class="w-32 h-32 bg-white rounded-[2rem] shadow-2xl flex items-center justify-center p-6 mb-4 relative">
                    <div class="absolute -inset-4 bg-white/20 blur-xl rounded-[2.5rem] -z-10"></div>
                    <img src="{{ asset('images/logoSena.png') }}" class="w-full h-auto mix-blend-normal" alt="Logo SENA">
                </div>

                <div class="space-y-4">
                    <h1 id="welcomeTitle" class="text-7xl font-black text-slate-800 tracking-tighter leading-[0.8] uppercase">Bienvenido al <br><span class="text-sena-500">Centro de Atención</span></h1>
                    <p id="welcomeDescription" class="text-base font-bold text-slate-400 uppercase tracking-[0.4em]">Por favor toca el botón para iniciar tu proceso</p>
                </div>

                <button type="button" onclick="nextStep(2); playKey();" class="group relative px-20 py-10 bg-gray-900 rounded-[3rem] overflow-hidden hover:scale-105 active:scale-95 transition-all duration-500 shadow-2xl shadow-gray-900/40">
                    <div class="absolute inset-0 bg-gradient-to-r from-sena-500 to-sena-orange opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <span id="startButton" class="relative text-white font-black text-2xl uppercase tracking-[0.3em] group-hover:tracking-[0.4em] transition-all">Empezar Aquí</span>
                </button>

                <!-- Status Badges -->
                <div class="flex flex-wrap items-center justify-center gap-6 mt-4 w-full">
                    <div class="flex items-center space-x-3 bg-white/60 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/50 shadow-sm">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse shadow-[0_0_8px_#22c55e]"></span>
                        <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Sistema Activo</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/60 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/50 shadow-sm">
                        <i class="fa-solid fa-clock text-sena-500 text-xs"></i>
                        <span id="kiosco-clock" class="text-[10px] font-black text-slate-600 uppercase tracking-widest">00:00 AM</span>
                    </div>
                </div>
            </div>

            <!-- STEP 2: TRATAMIENTO DE DATOS (ESTILO CAPTURA 2) -->
            <div id="step2" class="step-content w-full flex-col lg:flex-row items-center lg:items-start justify-center p-8 md:p-14 lg:p-16 gap-12">
                
                <!-- Left Content: Titles and Info Cards -->
                <div class="flex-1 lg:w-2/3 space-y-10 text-left">
                    <div class="space-y-4">
                        <h3 class="text-6xl font-poppins font-black text-[#1e293b] tracking-tighter leading-none">Tratamiento de Datos</h3>
                        <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-xl">Para brindarte un servicio personalizado y eficiente, requerimos procesar tu información institucional.</p>
                    </div>

                    <div class="inline-block bg-sena-50 px-6 py-2 rounded-xl border border-sena-100">
                        <span class="text-xs font-black text-sena-500 uppercase tracking-[0.2em]">Aceptación de Términos Institucionales</span>
                    </div>

                    <!-- Info Cards Grid 2x2 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @php 
                        $newTerms = [
                            ['icon' => 'fa-shield-heart', 'title' => 'Privacidad', 'desc' => 'Tus datos están protegidos bajo estándares internacionales de encriptación.', 'color' => 'bg-sena-50 text-sena-500'],
                            ['icon' => 'fa-user-check', 'title' => 'Seguridad', 'desc' => 'Implementamos protocolos robustos para prevenir el acceso no autorizado.', 'color' => 'bg-sena-50 text-sena-500'],
                            ['icon' => 'fa-users-viewfinder', 'title' => 'Uso Personal', 'desc' => 'La información recopilada se utiliza exclusivamente para trámites SENA.', 'color' => 'bg-sena-orange/10 text-sena-orange'],
                            ['icon' => 'fa-fingerprint', 'title' => 'Identidad Digital', 'desc' => 'Vinculamos tu perfil digital para agilizar futuros accesos institucionales.', 'color' => 'bg-sena-50 text-sena-500']
                        ];
                        @endphp
                        @foreach($newTerms as $t)
                        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                            <div class="w-14 h-14 {{ $t['color'] }} rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                                <i class="fa-solid {{ $t['icon'] }}"></i>
                            </div>
                            <h4 class="text-xl font-black text-slate-800 mb-2">{{ $t['title'] }}</h4>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed">{{ $t['desc'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Sidebar: Interactive Card -->
                <div class="w-full lg:w-1/3 flex flex-col space-y-8">
                    <div class="bg-slate-50 rounded-[3rem] overflow-hidden border border-gray-100 shadow-xl">
                        <!-- Top Image/Decorative Panel -->
                        <div class="h-64 bg-[#0a0a0a] relative flex items-center justify-center p-8 overflow-hidden">
                            <!-- Background Network Pattern Effect -->
                            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_center,_#10069F_0%,_transparent_70%)]"></div>
                            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0); background-size: 24px 24px;"></div>
                            
                            <div class="relative z-10 text-center space-y-4">
                                <i class="fa-solid fa-microchip text-sena-500 text-4xl animate-pulse"></i>
                                <p class="text-xs font-bold text-white/80 leading-relaxed uppercase tracking-widest px-4">
                                    Comprometidos con la transparencia y el desarrollo digital de nuestros aprendices.
                                </p>
                            </div>
                        </div>

                        <!-- Bottom Control Panel -->
                        <div class="p-8 space-y-8">
                            <label class="flex items-start space-x-4 cursor-pointer group">
                                <div class="relative mt-1">
                                    <input type="checkbox" id="termsCheck" onchange="toggleBtn(this)" class="peer appearance-none w-8 h-8 rounded-lg bg-gray-200 border-2 border-gray-200 checked:bg-sena-500 checked:border-sena-500 transition-all">
                                    <i class="fa-solid fa-check absolute inset-0 flex items-center justify-center text-white scale-0 peer-checked:scale-100 transition-transform"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-500 leading-relaxed uppercase tracking-wider">
                                    Autorizo el tratamiento de mis datos personales según las políticas del SENA.
                                </span>
                            </label>

                            <div class="space-y-4">
                                <button type="button" id="nextBtn" onclick="nextStep(3)" disabled class="w-full py-6 rounded-2xl bg-gray-200 text-gray-400 font-black flex items-center justify-center space-x-4 cursor-not-allowed opacity-50 transition-all text-sm uppercase tracking-widest">
                                    <span>ACEPTAR Y CONTINUAR</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                                <button type="button" onclick="nextStep(1)" class="w-full py-6 bg-white border border-gray-100 rounded-2xl text-gray-400 font-black uppercase tracking-widest text-xs hover:bg-gray-50 active:scale-95 transition-all">
                                    Volver al Inicio
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 3: PERFIL DE ATENCIÓN (ESTILO CAPTURA 3) -->
            <div id="step3" class="step-content w-full flex-col items-center justify-center p-8 md:p-14 lg:p-16 space-y-12">
                
                <div class="text-center space-y-4 max-w-4xl mx-auto">
                    <h2 class="text-6xl md:text-7xl font-poppins font-black text-[#1e293b] tracking-tighter leading-none">
                        ¿CUÁL ES SU <span class="text-sena-500">CATEGORÍA</span> DE USUARIO?
                    </h2>
                    <p class="text-lg md:text-xl font-medium text-slate-500 leading-relaxed max-w-2xl mx-auto px-4">
                        Seleccione la opción que mejor describa su condición para brindarle una atención adecuada.
                    </p>
                </div>

                <!-- Three Column Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-7xl mx-auto">
                    @php 
                    $profiles = [
                        [
                            'id' => 'General',
                            'icon' => 'fa-user',
                            'title' => 'General',
                            'badge' => 'ATENCIÓN NORMAL',
                            'desc' => 'Usuarios que no requieren condiciones especiales de movilidad o prioridad.',
                            'color' => 'bg-slate-100 text-slate-500',
                            'border' => 'border-gray-100',
                            'btn_color' => 'bg-gray-400'
                        ],
                        [
                            'id' => 'Prioritario',
                            'icon' => 'fa-wheelchair',
                            'title' => 'Prioritario',
                            'badge' => 'ADULTO MAYOR / DISCAPACIDAD',
                            'desc' => 'Atención preferencial para personas con movilidad reducida o adultos mayores.',
                            'color' => 'bg-sena-50 text-sena-500',
                            'border' => 'border-sena-200',
                            'btn_color' => 'bg-sena-500'
                        ],
                        [
                            'id' => 'Victimas',
                            'icon' => 'fa-award',
                            'title' => 'Víctima',
                            'badge' => 'PRIORIDAD MÁXIMA',
                            'desc' => 'Atención inmediata bajo el marco de la ley de víctimas y restitución de tierras.',
                            'color' => 'bg-sena-orange/10 text-sena-orange',
                            'border' => 'border-sena-orange/20',
                            'btn_color' => 'bg-sena-orange'
                        ]
                    ];
                    @endphp
                    @foreach($profiles as $p)
                    <div onclick="selectType('{{ $p['id'] }}')" class="main-card bg-white p-10 rounded-[3.5rem] border {{ $p['border'] }} shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 cursor-pointer group flex flex-col items-center text-center space-y-8 relative overflow-hidden">
                        
                        <div class="w-24 h-24 {{ $p['color'] }} rounded-[2rem] flex items-center justify-center text-4xl group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid {{ $p['icon'] }}"></i>
                        </div>

                        <div class="space-y-4">
                            <h4 class="text-3xl font-black text-slate-800">{{ $p['title'] }}</h4>
                            <div class="px-6 py-2 rounded-full {{ $p['color'] }}">
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ $p['badge'] }}</span>
                            </div>
                        </div>

                        <p class="text-sm font-medium text-slate-500 leading-relaxed px-2">
                            {{ $p['desc'] }}
                        </p>

                        <div class="w-12 h-12 {{ $p['btn_color'] }} text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity translate-y-4 group-hover:translate-y-0 duration-300">
                            <i class="fa-solid fa-arrow-right"></i>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Bottom Footer Note -->
                <div class="w-full max-w-4xl mx-auto bg-slate-50/80 backdrop-blur-sm p-8 rounded-[2.5rem] border border-gray-100 text-center">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-relaxed max-w-2xl mx-auto">
                        Al seleccionar su categoría, el sistema le asignará un turno y lo guiará al módulo correspondiente. Si necesita asistencia, presione el botón de <span class="text-sena-500">Ayuda</span> en la parte superior.
                    </p>
                </div>
            </div>

            <!-- STEP 4: IDENTIDAD (ESTILO CAPTURA 4) -->
            <div id="step4" class="step-content w-full flex-col lg:flex-row items-center lg:items-start justify-center p-8 md:p-14 lg:p-16 gap-16">
                
                <!-- Left Column: Doc Type Selector -->
                <div class="flex-1 lg:w-1/2 space-y-10 text-left">
                    <div class="space-y-4">
                        <h3 class="text-6xl font-poppins font-black text-[#1e293b] tracking-tighter leading-none">Ingrese sus <span class="text-sena-500">datos</span></h3>
                        <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-md">Por favor, seleccione su tipo de documento e ingrese el número de identificación para continuar.</p>
                    </div>

                    <div class="space-y-6">
                        <span class="text-[10px] font-black text-sena-500 uppercase tracking-[0.3em]">Tipo de Documento</span>
                        <div class="flex flex-col space-y-4">
                            @foreach(['CC' => 'Cédula de Ciudadanía', 'CE' => 'Cédula de Extranjería', 'TI' => 'Tarjeta de Identidad'] as $val => $label)
                            <button type="button" onclick="setDocType('{{ $val }}', this); playKey();" class="doc-tab-btn w-full p-6 text-left rounded-2xl border-2 transition-all flex items-center justify-between group {{ $val == 'CC' ? 'border-sena-500 bg-sena-50 text-sena-500 shadow-lg' : 'border-gray-50 text-slate-500' }}">
                                <span class="text-sm font-black uppercase tracking-widest">{{ $label }}</span>
                                <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center {{ $val == 'CC' ? 'border-sena-500 bg-sena-500 text-white' : 'border-gray-200 group-hover:border-sena-300' }}">
                                    <i class="fa-solid fa-check text-xs {{ $val == 'CC' ? 'scale-100' : 'scale-0' }} transition-transform"></i>
                                </div>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Bottom Image/Icon Placeholder -->
                    <div class="pt-8 opacity-40">
                        <div class="w-full h-48 bg-slate-100 rounded-[3rem] flex items-center justify-center border-4 border-dashed border-slate-200">
                             <i class="fa-solid fa-fingerprint text-6xl text-slate-300"></i>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Keypad Card -->
                <div class="w-full lg:w-1/2">
                    <div class="bg-white rounded-[4rem] p-12 shadow-2xl border border-gray-50 flex flex-col items-center">
                        <span class="w-full text-left text-[10px] font-black text-sena-500 uppercase tracking-widest mb-6 px-4">Número de Identificación</span>
                        
                        <!-- Large Display Box -->
                        <div class="w-full bg-slate-100 rounded-[2.5rem] p-10 mb-10 flex items-center justify-center relative overflow-hidden">
                            <span id="docDisplay" class="text-7xl font-black text-[#1e293b] tracking-wider leading-none">0000000000</span>
                            <div class="w-1 h-14 bg-sena-500 ml-3 animate-pulse rounded-full"></div>
                        </div>

                        <!-- Numeric Keypad Grid -->
                        <div class="grid grid-cols-3 gap-4 w-full">
                            @for($i=1;$i<=9;$i++)
                            <button type="button" onclick="pressNum('{{ $i }}'); playKey();" class="h-24 bg-slate-50 hover:bg-white border-2 border-transparent hover:border-gray-100 rounded-2xl flex items-center justify-center text-4xl font-black text-slate-700 shadow-sm hover:shadow-lg transition-all active:scale-95">{{ $i }}</button>
                            @endfor
                            <button type="button" onclick="clearNum(); playKey();" class="h-24 bg-rose-50 hover:bg-rose-100 rounded-2xl flex items-center justify-center text-3xl text-rose-500 shadow-sm transition-all active:scale-95">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                            <button type="button" onclick="pressNum('0'); playKey();" class="h-24 bg-slate-50 hover:bg-white border-2 border-transparent hover:border-gray-100 rounded-2xl flex items-center justify-center text-4xl font-black text-slate-700 shadow-sm hover:shadow-lg transition-all active:scale-95">0</button>
                            <button type="button" onclick="backspace(); playKey();" class="h-24 bg-slate-50 hover:bg-white rounded-2xl flex items-center justify-center text-3xl text-slate-400 shadow-sm transition-all active:scale-95">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Continue Button -->
                        <button type="button" onclick="validateDoc(); playKey();" class="w-full mt-10 py-8 bg-sena-orange text-white font-black text-xl rounded-[2rem] shadow-2xl shadow-sena-orange/30 hover:shadow-sena-orange/50 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-6 uppercase tracking-widest">
                            <span>CONTINUAR</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 5: CONTACTO (ESTILO CAPTURA 5) -->
            <div id="step5" class="step-content w-full flex-col lg:flex-row items-center lg:items-start justify-center p-8 md:p-14 lg:p-16 gap-16">
                
                <!-- Left Column: Info and Display -->
                <div class="flex-1 lg:w-1/2 space-y-10 text-left">
                    <div class="space-y-4">
                        <div class="inline-block bg-sena-50 px-4 py-1.5 rounded-lg border border-sena-100">
                            <span class="text-[10px] font-black text-sena-500 uppercase tracking-widest">Paso 5 de 6</span>
                        </div>
                        <h3 class="text-6xl font-poppins font-black text-[#1e293b] tracking-tighter leading-none">Datos de <span class="text-sena-500">Contacto</span></h3>
                        <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-md uppercase tracking-wider">Ingrese su número celular para el turno</p>
                    </div>

                    <!-- Phone Display Card -->
                    <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-xl relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-2 h-full bg-sena-500 opacity-20"></div>
                        <span class="text-[10px] font-black text-sena-500 uppercase tracking-widest mb-6 block px-2">Número de Celular</span>
                        
                        <div class="flex items-center justify-start space-x-6">
                            <span class="text-5xl font-black text-sena-500 opacity-40">+57</span>
                            <span id="phoneDisplay" class="text-6xl font-black text-[#1e293b] tracking-wider leading-none">300 000 0000</span>
                        </div>
                    </div>

                    <!-- Notification Box Blue -->
                    <div class="bg-blue-50/80 backdrop-blur-sm p-8 rounded-[2.5rem] border border-blue-100 flex items-start space-x-6">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-sena-500 shadow-sm flex-shrink-0">
                            <i class="fa-solid fa-bell-concierge"></i>
                        </div>
                        <p class="text-[11px] font-bold text-slate-500 leading-relaxed uppercase tracking-wider">
                            Le enviaremos un link de seguimiento a este número para que pueda monitorear su turno desde su celular mientras espera.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Keypad Card -->
                <div class="w-full lg:w-1/2">
                    <div class="bg-slate-50/50 backdrop-blur-md rounded-[4rem] p-12 border border-white/50 shadow-2xl flex flex-col items-center">
                        <!-- Numeric Keypad Grid (Contact) -->
                        <div class="grid grid-cols-3 gap-4 w-full">
                            @for($i=1;$i<=9;$i++)
                            <button type="button" onclick="pressPhone('{{ $i }}'); playKey();" class="h-24 bg-white hover:bg-slate-50 border-b-4 border-gray-100 hover:border-gray-200 rounded-2xl flex items-center justify-center text-4xl font-black text-slate-700 shadow-sm hover:shadow-lg transition-all active:scale-95 active:border-b-0 translate-y-0 active:translate-y-1">{{ $i }}</button>
                            @endfor
                            <button type="button" onclick="phoneNumber=''; updatePhoneDisplay(); playKey();" class="h-24 bg-white rounded-2xl flex items-center justify-center text-3xl text-slate-300 shadow-sm hover:text-rose-500 transition-colors">
                                <i class="fa-solid fa-rotate-right"></i>
                            </button>
                            <button type="button" onclick="pressPhone('0'); playKey();" class="h-24 bg-white hover:bg-slate-50 border-b-4 border-gray-100 rounded-2xl flex items-center justify-center text-4xl font-black text-slate-700 shadow-sm hover:shadow-lg transition-all active:scale-95">0</button>
                            <button type="button" onclick="backspacePhone(); playKey();" class="h-24 bg-white rounded-2xl flex items-center justify-center text-3xl text-slate-300 shadow-sm hover:text-amber-500 transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Continue Button -->
                        <button type="button" onclick="nextStep(6); playKey();" class="w-full mt-10 py-8 bg-sena-orange text-white font-black text-xl rounded-[2.5rem] shadow-2xl shadow-sena-orange/30 hover:shadow-sena-orange/50 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-6 uppercase tracking-widest">
                            <span>CONTINUAR</span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 6: RECEPCIÓN (ESTILO CAPTURA 6) -->
            <div id="step6" class="step-content flex-col items-center justify-center p-8 md:p-14 lg:p-16 space-y-12">
                <div class="text-center space-y-4 max-w-4xl mx-auto">
                    <h3 class="text-6xl md:text-7xl font-poppins font-black text-[#1e293b] tracking-tighter leading-none uppercase">Canal de <span class="text-sena-500">Entrega</span></h3>
                    <p class="text-lg md:text-xl font-medium text-slate-500 leading-relaxed max-w-2xl mx-auto uppercase tracking-widest">¿Por qué medio desea recibir su turno?</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 w-full max-w-7xl mx-auto">
                    @php 
                    $methods = [
                        ['id' => 'SMS', 'icon' => 'fa-comment-sms', 'title' => 'SMS'],
                        ['id' => 'WhatsApp', 'icon' => 'fa-whatsapp', 'title' => 'WhatsApp'],
                        ['id' => 'Email', 'icon' => 'fa-envelope', 'title' => 'Email'],
                        ['id' => 'QR', 'icon' => 'fa-qrcode', 'title' => 'Código QR']
                    ];
                    @endphp
                    @foreach($methods as $m)
                    <button type="button" onclick="setReceiveMethod('{{ $m['id'] }}', this); playKey();" class="receive-card bg-white p-10 rounded-[3rem] border-2 {{ $m['id'] == 'SMS' ? 'border-sena-500 shadow-2xl scale-105' : 'border-gray-50 opacity-60' }} transition-all duration-500 group flex flex-col items-center space-y-8">
                        <div class="w-24 h-24 {{ $m['id'] == 'SMS' ? 'bg-sena-500 text-white' : 'bg-gray-50 text-gray-300' }} rounded-[2rem] flex items-center justify-center text-4xl shadow-inner transition-colors group-hover:scale-110">
                            <i class="fa-solid {{ $m['icon'] }}"></i>
                        </div>
                        <h4 class="text-2xl font-black text-slate-800 uppercase tracking-tighter group-hover:text-sena-500 transition-colors">{{ $m['title'] }}</h4>
                    </button>
                    @endforeach
                </div>

                <div class="flex flex-col md:flex-row items-center justify-center gap-8 w-full max-w-4xl mt-8">
                    <button type="button" onclick="nextStep(5); playKey();" class="px-12 py-6 bg-white border border-gray-100 rounded-full text-slate-400 font-black uppercase tracking-widest text-xs hover:bg-gray-50 active:scale-95 transition-all flex items-center space-x-4">
                        <i class="fa-solid fa-arrow-left"></i><span>VOLVER</span>
                    </button>
                    <button type="submit" onclick="playKey();" class="w-full max-w-md py-8 bg-gradient-to-r from-sena-500 to-sena-orange text-white font-black text-xl rounded-[2.5rem] shadow-2xl shadow-sena-orange/30 hover:shadow-sena-orange/50 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center space-x-6 uppercase tracking-widest border border-white/10">
                        <span>GENERAR TURNO FINAL</span>
                        <i class="fa-solid fa-ticket"></i>
                    </button>
                </div>
            </div>

            <!-- CAMPOS OCULTOS (Trasladados al final para mejor soporte en el navegador) -->
            <input type="hidden" name="pers_tipodoc" id="hidden_pers_tipodoc" value="{{ old('pers_tipodoc', 'CC') }}">
            <input type="hidden" name="pers_doc" id="hidden_pers_doc" value="{{ old('pers_doc') }}">
            <input type="hidden" name="pers_nombres" value="Usuario">
            <input type="hidden" name="pers_apellidos" value="Kiosco">
            <input type="hidden" name="pers_telefono" id="hidden_pers_telefono" value="{{ old('pers_telefono') }}">
            <input type="hidden" name="sol_tipo" value="Externo">
            <input type="hidden" name="tur_tipo" id="hidden_tur_tipo" value="{{ old('tur_tipo', 'General') }}">
            <input type="hidden" name="receive_method" id="hidden_receive_method" value="{{ old('receive_method', 'SMS') }}">
        </form>

        <!-- Footer Institucional Centrado -->
        <footer class="w-full px-12 py-8 flex flex-col items-center justify-center text-center space-y-4 border-t border-gray-100/50 mt-auto">
            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.25em]">© 2026 Servicio Nacional de Aprendizaje SENA. Todos los derechos reservados.</div>
            <div class="flex items-center justify-center space-x-10 text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">
                <button type="button" onclick="showPortalInfo('Portal SENA'); playKey();" class="hover:text-sena-500 transition-colors">Portal SENA</button>
                <button type="button" onclick="showPortalInfo('Transparencia'); playKey();" class="hover:text-sena-500 transition-colors">Transparencia</button>
                <button type="button" onclick="showPortalInfo('Contacto'); playKey();" class="hover:text-sena-500 transition-colors">Contacto</button>
                <button type="button" onclick="showPortalInfo('PQRS'); playKey();" class="hover:text-sena-500 transition-colors">PQRS</button>
            </div>
        </footer>
    </div>

    <!-- MODAL DE ÉXITO (ESTILO CAPTURA 7) -->
    @if(session('success'))
    <div id="successModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-5xl rounded-[4rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-[550px] border border-white/20 animate-fade-in-up">
            
            <!-- Left Side: Decorative Blue Panel -->
            <div class="lg:w-1/2 bg-sena-500 p-16 flex flex-col items-center justify-center text-center space-y-8 relative overflow-hidden">
                <!-- Abstract Background Shapes -->
                <div class="absolute -top-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-sena-orange/20 rounded-full blur-3xl"></div>
                
                <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center shadow-2xl animate-bounce-slow">
                    <i class="fa-solid fa-check text-6xl text-sena-500"></i>
                </div>
                
                <div class="space-y-4 relative z-10">
                    <h3 class="text-6xl font-poppins font-black text-white tracking-tighter leading-none italic">¡Completado!</h3>
                    <p class="text-xl font-bold text-white/60 uppercase tracking-[0.3em]">Transacción Exitosa</p>
                </div>
            </div>

            <!-- Right Side: Turn Info -->
            <div class="lg:w-1/2 p-16 flex flex-col items-center justify-center space-y-10">
                <div class="text-center space-y-2">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Su turno asignado es</p>
                </div>

                <div class="bg-slate-50 border-4 border-slate-100 rounded-[3rem] px-16 py-10 w-full text-center shadow-inner group">
                    <div class="text-[9rem] font-poppins font-black text-sena-500 tracking-tighter leading-none group-hover:scale-105 transition-transform duration-500">
                        {{ str_replace('Turno solicitado con éxito: ', '', session('success')) }}
                    </div>
                </div>

                <div class="space-y-6 text-center max-w-sm">
                    <p class="text-sm font-bold text-slate-500 leading-relaxed uppercase">
                        Su turno ha sido asignado con éxito. Por favor retire su tiquete e ingrese a la sala de espera.
                    </p>
                    <div class="flex items-center justify-center space-x-3 text-sena-500">
                        <i class="fa-solid fa-clock-rotate-left animate-spin-slow"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Será llamado pronto - Cierre en 8s</span>
                    </div>
                </div>

                <button onclick="closeModal()" class="w-full py-8 rounded-[2rem] bg-sena-orange text-white font-black text-xl uppercase tracking-widest shadow-2xl shadow-sena-orange/30 hover:shadow-sena-orange/50 active:scale-95 transition-all">
                    FINALIZAR <i class="fa-solid fa-chevron-right ml-4"></i>
                </button>
            </div>
        </div>
    </div>
    <script>
        function playSuccessNotification() {
            initKioscoAudio();
            if (audioCtxKiosco.state === 'suspended') audioCtxKiosco.resume();
            
            const now = audioCtxKiosco.currentTime;
            const osc = audioCtxKiosco.createOscillator();
            const gain = audioCtxKiosco.createGain();
            
            osc.frequency.setValueAtTime(523.25, now); // C5
            osc.frequency.exponentialRampToValueAtTime(659.25, now + 0.5); // E5
            
            gain.gain.setValueAtTime(0.1, now);
            gain.gain.exponentialRampToValueAtTime(0.01, now + 1);
            
            osc.connect(gain);
            gain.connect(audioCtxKiosco.destination);
            
            osc.start();
            osc.stop(now + 1);
        }

        function closeModal() {
            const modal = document.getElementById('successModal');
            if (modal) {
                modal.style.opacity = '0';
                modal.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => modal.remove(), 500);
            }
        }
        
        // Ejecutar sonido y auto-cierre
        setTimeout(() => {
            playSuccessNotification();
            setTimeout(closeModal, 10000); // 10 segundos de visualización
        }, 300);
    </script>
    @endif

    <!-- MODAL DE ERROR -->
    @if($errors->any() || session('error'))
    <div id="errorModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-2xl rounded-[4rem] p-12 shadow-2xl flex flex-col items-center text-center space-y-8 border border-gray-100 relative">
            
            <button type="button" onclick="document.getElementById('errorModal').style.display='none'" class="absolute top-8 right-8 text-gray-400 hover:text-gray-900 text-3xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Icono Animado Error -->
            <div class="w-28 h-28 bg-rose-50 rounded-full flex items-center justify-center relative">
                <div class="absolute inset-0 bg-rose-500/20 rounded-full animate-ping"></div>
                <i class="fa-solid fa-triangle-exclamation text-5xl text-rose-500 relative z-10"></i>
            </div>

            <div class="space-y-3">
                <h3 class="text-4xl font-poppins font-black text-gray-900 tracking-tight leading-none italic">¡Algo salió mal!</h3>
                <p class="text-base font-bold text-gray-500 uppercase tracking-widest">
                    @if(session('error')) {{ session('error') }} @else Por favor verifica los datos ingresados: @endif
                </p>
            </div>

            @if($errors->any())
            <div class="bg-rose-50/50 border border-rose-100 rounded-3xl p-6 w-full text-left overflow-y-auto max-h-40">
                <ul class="list-disc list-inside text-rose-600 font-medium space-y-2 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <button type="button" onclick="document.getElementById('errorModal').style.display='none'" class="w-full py-6 rounded-[2rem] bg-gray-900 text-white font-black text-lg uppercase tracking-widest hover:bg-black transition-all shadow-xl active:scale-95">
                INTENTAR DE NUEVO
            </button>
        </div>
    </div>
    @endif

    <!-- MODAL INFORMATIVO (GENÉRICO) -->
    <div id="kioscoInfoModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 bg-slate-900/80 backdrop-blur-md transition-all duration-300 opacity-0">
        <div class="bg-white w-full max-w-2xl rounded-[4rem] p-12 shadow-2xl flex flex-col items-center text-center space-y-8 border border-white/20 relative scale-90 transition-transform duration-300" id="infoModalContent">
            
            <button type="button" onclick="closeKioscoModal()" class="absolute top-10 right-10 text-slate-300 hover:text-slate-900 text-3xl transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div id="infoIconContainer" class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center shadow-inner">
                <i id="infoIcon" class="fa-solid fa-circle-info text-5xl text-slate-400"></i>
            </div>

            <div class="space-y-4">
                <h3 id="infoTitle" class="text-5xl font-poppins font-black text-slate-900 tracking-tighter leading-none italic uppercase">TITULO DEL MODAL</h3>
                <p id="infoSubtitle" class="text-sm font-black text-sena-500 uppercase tracking-[0.2em] mb-4">SUBTÍTULO INFORMATIVO</p>
                <div id="infoBody" class="text-slate-500 font-medium leading-relaxed px-6">
                    <!-- Contenido dinámico -->
                </div>
            </div>

            <button type="button" onclick="closeKioscoModal()" class="w-full py-8 rounded-[2.5rem] bg-slate-900 text-white font-black text-xl uppercase tracking-widest hover:bg-black transition-all shadow-2xl active:scale-95">
                ENTENDIDO
            </button>
        </div>
    </div>

    <script>
        let docNumber = "{{ old('pers_doc', '') }}";
        let phoneNumber = "{{ old('pers_telefono', '') }}";
        let audioCtxKiosco = null;

        function initKioscoAudio() {
            if (!audioCtxKiosco) {
                audioCtxKiosco = new (window.AudioContext || window.webkitAudioContext)();
            }
        }

        function playKey() {
            initKioscoAudio();
            if (audioCtxKiosco.state === 'suspended') audioCtxKiosco.resume();
            
            const osc = audioCtxKiosco.createOscillator();
            const gain = audioCtxKiosco.createGain();
            
            osc.type = 'sine';
            osc.frequency.setValueAtTime(600, audioCtxKiosco.currentTime);
            osc.frequency.exponentialRampToValueAtTime(100, audioCtxKiosco.currentTime + 0.1);
            
            gain.gain.setValueAtTime(0.1, audioCtxKiosco.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtxKiosco.currentTime + 0.1);
            
            osc.connect(gain);
            gain.connect(audioCtxKiosco.destination);
            
            osc.start();
            osc.stop(audioCtxKiosco.currentTime + 0.1);
        }

        function nextStep(step) {
            initKioscoAudio();
            document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.progress-dot').forEach(el => {
                el.classList.remove('active');
                if (el.dataset.step == step) el.classList.add('active');
            });
            setTimeout(() => {
                document.getElementById('step' + step).classList.add('active');
            }, 10);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function toggleBtn(checkbox) {
            const btn = document.getElementById('nextBtn');
            if (checkbox.checked) {
                btn.disabled = false;
                btn.classList.remove('bg-gray-100', 'text-gray-400', 'cursor-not-allowed', 'opacity-50', 'grayscale');
                btn.classList.add('bg-sena-500', 'text-white', 'cursor-pointer', 'opacity-100');
            } else {
                btn.disabled = true;
                btn.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed', 'opacity-50', 'grayscale');
                btn.classList.remove('bg-sena-50', 'text-sena-500', 'cursor-pointer', 'opacity-100');
            }
        }

        function selectType(type) { document.getElementById('hidden_tur_tipo').value = type; nextStep(4); }

        function setDocType(type, btn) {
            document.getElementById('hidden_pers_tipodoc').value = type;
            document.querySelectorAll('.doc-tab-btn').forEach(b => {
                b.classList.remove('border-sena-500', 'bg-sena-50', 'text-sena-500', 'shadow-lg');
                b.classList.add('border-gray-50', 'text-slate-500');
                b.querySelector('div').classList.remove('border-sena-500', 'bg-sena-500', 'text-white');
                b.querySelector('div').classList.add('border-gray-200');
                b.querySelector('i').classList.replace('scale-100', 'scale-0');
            });
            btn.classList.add('border-sena-500', 'bg-sena-50', 'text-sena-500', 'shadow-lg');
            btn.classList.remove('border-gray-50', 'text-slate-500');
            btn.querySelector('div').classList.add('border-sena-500', 'bg-sena-500', 'text-white');
            btn.querySelector('div').classList.remove('border-gray-200');
            btn.querySelector('i').classList.replace('scale-0', 'scale-100');
        }

        function pressNum(n) { if (docNumber.length < 12) docNumber += n; updateDocDisplay(); }
        function backspace() { docNumber = docNumber.slice(0, -1); updateDocDisplay(); }
        function clearNum() { docNumber = ""; updateDocDisplay(); }
        function updateDocDisplay() { 
            const d = document.getElementById('docDisplay'); d.innerText = docNumber || "0000000000";
            d.style.color = docNumber ? "#111827" : "#f3f4f6";
            document.getElementById('hidden_pers_doc').value = docNumber;
        }
        function validateDoc() { if (docNumber.length > 5) nextStep(5); else alert("Documento muy corto"); }

        function pressPhone(n) { if (phoneNumber.length < 10) phoneNumber += n; updatePhoneDisplay(); }
        function backspacePhone() { phoneNumber = phoneNumber.slice(0, -1); updatePhoneDisplay(); }
        function updatePhoneDisplay() {
            const d = document.getElementById('phoneDisplay');
            d.innerText = phoneNumber.replace(/(\d{3})(\d{3})(\d{4})/, "$1 $2 $3") || "300 000 0000";
            d.style.color = phoneNumber ? "#1e293b" : "#cbd5e1";
            document.getElementById('hidden_pers_telefono').value = phoneNumber;
        }

        function setReceiveMethod(method, btn) {
            document.getElementById('hidden_receive_method').value = method;
            document.querySelectorAll('.receive-card').forEach(c => {
                c.classList.remove('border-sena-500', 'shadow-2xl', 'opacity-100');
                c.classList.add('border-gray-50', 'opacity-60');
                c.querySelector('div').classList.remove('bg-sena-500', 'text-white');
                c.querySelector('div').classList.add('bg-gray-50', 'text-gray-300');
            });
            btn.classList.add('border-sena-500', 'shadow-2xl', 'opacity-100');
            btn.classList.remove('border-gray-50', 'opacity-60');
            btn.querySelector('div').classList.replace('bg-gray-50', 'bg-sena-500');
            btn.querySelector('div').classList.replace('text-gray-300', 'text-white');
        }

        // --- NUEVA FUNCIONALIDAD HEADER / FOOTER ---
        let currentLang = 'ES';
        const translations = {
            ES: {
                welcomeTitle: 'Bienvenido al <br><span class="text-sena-500">Centro de Atención</span>',
                welcomeDescription: 'Por favor toca el botón para iniciar tu proceso',
                startButton: 'Empezar Aquí',
                helpTitle: 'GUÍA DE USO',
                helpSubtitle: '¿CÓMO SOLICITAR TU TURNO?',
                helpBody: `
                    <div class="space-y-4 text-left">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-sena-500 text-white rounded-full flex items-center justify-center font-bold">1</div>
                            <p>Toca <b>Empezar</b> y acepta los términos.</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-sena-500 text-white rounded-full flex items-center justify-center font-bold">2</div>
                            <p>Selecciona tu <b>Categoría</b> de atención.</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-sena-500 text-white rounded-full flex items-center justify-center font-bold">3</div>
                            <p>Ingresa tu <b>Documento</b> y <b>Teléfono</b>.</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-sena-500 text-white rounded-full flex items-center justify-center font-bold">4</div>
                            <p>¡Retira tu <b>Ticket</b> y espera el llamado!</p>
                        </div>
                    </div>
                `
            },
            EN: {
                welcomeTitle: 'Welcome to the <br><span class="text-sena-500">Service Center</span>',
                welcomeDescription: 'Please touch the button to start your process',
                startButton: 'Start Here',
                helpTitle: 'USER GUIDE',
                helpSubtitle: 'HOW TO REQUEST YOUR TURN?',
                helpBody: `
                    <div class="space-y-4 text-left">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-sena-500 text-white rounded-full flex items-center justify-center font-bold">1</div>
                            <p>Tap <b>Start</b> and accept the terms.</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-sena-500 text-white rounded-full flex items-center justify-center font-bold">2</div>
                            <p>Select your service <b>Category</b>.</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-sena-500 text-white rounded-full flex items-center justify-center font-bold">3</div>
                            <p>Enter your <b>ID</b> and <b>Phone</b>.</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 bg-sena-500 text-white rounded-full flex items-center justify-center font-bold">4</div>
                            <p>Collect your <b>Ticket</b> and wait for your call!</p>
                        </div>
                    </div>
                `
            }
        };

        function toggleLanguage() {
            currentLang = currentLang === 'ES' ? 'EN' : 'ES';
            document.getElementById('langLabel').innerText = currentLang === 'ES' ? 'ES / EN' : 'EN / ES';
            document.getElementById('welcomeTitle').innerHTML = translations[currentLang].welcomeTitle;
            document.getElementById('welcomeDescription').innerText = translations[currentLang].welcomeDescription;
            document.getElementById('startButton').innerText = translations[currentLang].startButton;
            // Opcional: Traducir botón ayuda
            document.getElementById('helpLabel').innerText = currentLang === 'ES' ? 'AYUDA' : 'HELP';
        }

        function showKioscoModal(title, subtitle, body, icon = 'fa-circle-info') {
            const modal = document.getElementById('kioscoInfoModal');
            const content = document.getElementById('infoModalContent');
            
            document.getElementById('infoTitle').innerText = title;
            document.getElementById('infoSubtitle').innerText = subtitle;
            document.getElementById('infoBody').innerHTML = body;
            document.getElementById('infoIcon').className = `fa-solid ${icon} text-5xl text-slate-400`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                content.classList.remove('scale-90');
                content.classList.add('scale-100');
            }, 10);
        }

        function closeKioscoModal() {
            const modal = document.getElementById('kioscoInfoModal');
            const content = document.getElementById('infoModalContent');
            
            modal.classList.remove('opacity-100');
            content.classList.add('scale-90');
            content.classList.remove('scale-100');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function showHelp() {
            const data = translations[currentLang];
            showKioscoModal(data.helpTitle, data.helpSubtitle, data.helpBody, 'fa-hand-pointer');
        }

        function showPortalInfo(name) {
            const body = `
                <div class="flex flex-col items-center space-y-6">
                    <p class="text-slate-500">Puedes acceder al ${name} escaneando este código QR con tu dispositivo móvil para continuar tu gestión de manera personal.</p>
                    <div class="w-48 h-48 bg-slate-100 rounded-3xl flex items-center justify-center border-4 border-slate-50 shadow-inner">
                        <i class="fa-solid fa-qrcode text-8xl text-slate-300"></i>
                    </div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">SENA DIGITAL • CONECTIVIDAD</div>
                </div>
            `;
            showKioscoModal('ACCESO MÓVIL', name, body, 'fa-mobile-screen-button');
        }

        window.onload = () => { updateDocDisplay(); updatePhoneDisplay(); };
        // Reloj en tiempo real para Kiosco
        function updateClock() {
            const clockEl = document.getElementById('kiosco-clock');
            if (!clockEl) return;
            const now = new Date();
            clockEl.textContent = now.toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit', 
                hour12: true 
            });
        }
        setInterval(updateClock, 1000);
        updateClock();

        function validateForm() {
            // Sincronización final antes del envío
            document.getElementById('hidden_pers_doc').value = docNumber;
            document.getElementById('hidden_pers_telefono').value = phoneNumber;

            if (!docNumber || docNumber.length < 5) {
                alert("Por favor ingrese un número de documento válido.");
                nextStep(4);
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
