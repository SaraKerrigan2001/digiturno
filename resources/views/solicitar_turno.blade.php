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
                        sena: { 50: '#f1f8e9', 100: '#dcedc8', 500: '#39A900', 600: '#2d8700' }
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
            background-color: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.4);
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
        ::-webkit-scrollbar-thumb { background: #39A900; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-8">

    <div class="w-full max-w-5xl min-h-[650px] main-card rounded-[3.5rem] flex flex-col items-center relative overflow-hidden shadow-2xl">
        
        <!-- Header Universal -->
        <header class="w-full px-8 md:px-12 py-6 flex justify-between items-center border-b border-gray-100/50">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logoSena.png') }}" class="h-8 w-auto mix-blend-multiply" alt="Logo">
                <div class="h-6 w-px bg-gray-200"></div>
                <div>
                    <h1 class="text-[11px] font-black text-gray-900 uppercase tracking-widest leading-none">Agencia Pública de Empleo</h1>
                    <p class="text-[8px] font-bold text-sena-500 uppercase tracking-[0.3em] mt-1">Kiosco de Turnos Digital</p>
                </div>
            </div>
            <div id="stepIndicator" class="hidden md:flex items-center space-x-2">
                @for($i=1; $i<=6; $i++)
                <div class="progress-dot {{ $i == 1 ? 'active' : '' }}" data-step="{{ $i }}"></div>
                @endfor
            </div>
        </header>

        <!-- Formulario -->
        <form id="kioskForm" action="{{ route('turnos.store') }}" method="POST" class="flex-1 w-full flex">
            @csrf
            
            <!-- CAMPOS OCULTOS -->
            <input type="hidden" name="pers_tipodoc" id="hidden_pers_tipodoc" value="CC">
            <input type="hidden" name="pers_doc" id="hidden_pers_doc">
            <input type="hidden" name="pers_nombres" value="Usuario">
            <input type="hidden" name="pers_apellidos" value="Kiosco">
            <input type="hidden" name="pers_telefono" id="hidden_pers_telefono">
            <input type="hidden" name="sol_tipo" value="Externo">
            <input type="hidden" name="tur_tipo" id="hidden_tur_tipo" value="General">
            <input type="hidden" name="receive_method" id="hidden_receive_method" value="SMS">

            <!-- STEP 1: BIENVENIDA -->
            <div id="step1" class="step-content active flex-col items-center justify-center text-center p-8 md:p-12 lg:p-14 space-y-8 lg:space-y-10">
                <div class="relative group">
                    <div class="absolute -inset-10 bg-sena-500/5 blur-[80px] rounded-full"></div>
                    <img src="{{ asset('images/logoSena.png') }}" class="w-48 lg:w-56 h-auto relative z-10 animate-bounce-slow mix-blend-multiply" style="animation: bounce 3s infinite ease-in-out;">
                </div>

                <div class="space-y-3 lg:space-y-4 max-w-3xl">
                    <h2 class="text-4xl md:text-5xl lg:text-7xl font-poppins font-extrabold leading-[1.1] text-gray-900 tracking-tight">
                        Solicitud de <br>
                        <span class="text-sena-500 bg-gradient-to-r from-sena-500 to-sena-600 bg-clip-text text-transparent">Turno Digital</span>
                    </h2>
                    <p class="text-sm md:text-base lg:text-lg font-medium text-gray-600 uppercase tracking-widest opacity-80 mt-2">Toque el botón inferior para comenzar su trámite</p>
                </div>

                <button type="button" onclick="nextStep(2)" class="w-full max-w-sm text-lg lg:text-xl py-5 lg:py-6 mt-4 lg:mt-8 mx-auto bg-gradient-to-r from-sena-500 to-sena-600 text-white font-bold rounded-2xl shadow-[0_15px_30px_-10px_rgba(57,169,0,0.3)] hover:shadow-[0_20px_40px_-10px_rgba(57,169,0,0.4)] hover:-translate-y-1 active:scale-95 transition-all duration-300 flex items-center justify-center space-x-4 uppercase tracking-[0.1em] border border-white/10">
                    <span>EMPEZAR AQUÍ</span>
                    <i class="fa-solid fa-chevron-right text-base text-white/80"></i>
                </button>
            </div>

            <!-- STEP 2: TÉRMINOS -->
            <div id="step2" class="step-content flex-col items-center justify-center p-20 space-y-12">
                <div class="text-center space-y-4">
                    <h3 class="text-6xl font-black text-gray-900 tracking-tighter">Tratamiento de Datos</h3>
                    <p class="text-lg text-gray-400 font-bold uppercase tracking-widest">Aceptación de Términos Institucionales</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-5xl">
                    @php 
                    $terms = [
                        ['icon' => 'fa-shield-halved', 'title' => 'Privacidad', 'desc' => 'Uso exclusivo para la gestión de empleo.'],
                        ['icon' => 'fa-lock', 'title' => 'Seguridad', 'desc' => 'Información cifrada bajo protocolos SENA.'],
                        ['icon' => 'fa-user-check', 'title' => 'Personal', 'desc' => 'El turno es personal e intransferible.'],
                        ['icon' => 'fa-leaf', 'title' => 'Digital', 'desc' => 'Proceso 100% ecológico sin recibos físicos.']
                    ];
                    @endphp
                    @foreach($terms as $t)
                    <div class="flex items-start space-x-6 bg-gray-50/50 p-8 rounded-[3rem] border border-gray-100 hover:bg-white transition-all hover:shadow-xl group">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-sena-500 text-2xl shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fa-solid {{ $t['icon'] }}"></i>
                        </div>
                        <div class="space-y-1">
                            <h4 class="text-xl font-black text-gray-900">{{ $t['title'] }}</h4>
                            <p class="text-sm text-gray-400 font-medium leading-relaxed">{{ $t['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="w-full max-w-5xl space-y-8">
                    <label class="flex items-center space-x-6 cursor-pointer group bg-white p-8 rounded-[3rem] border border-gray-100/50 shadow-sm hover:border-sena-500 transition-all">
                        <div class="relative w-10 h-10">
                            <input type="checkbox" id="termsCheck" onchange="toggleBtn(this)" class="peer appearance-none w-10 h-10 rounded-xl bg-gray-100 border-2 border-gray-100 checked:bg-sena-500 checked:border-sena-500 transition-all">
                            <i class="fa-solid fa-check absolute inset-0 flex items-center justify-center text-white scale-0 peer-checked:scale-100 transition-transform"></i>
                        </div>
                        <span class="text-lg font-bold text-gray-600">Autorizo el tratamiento de mis datos personales según las políticas del SENA.</span>
                    </label>

                    <div class="flex space-x-6">
                        <button type="button" id="nextBtn" onclick="nextStep(3)" disabled class="flex-1 py-8 rounded-[2.5rem] bg-gray-100 text-gray-400 font-black flex items-center justify-center space-x-4 cursor-not-allowed opacity-50 grayscale transition-all text-xl uppercase tracking-widest">
                            <span>ACEPTAR Y CONTINUAR</span><i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                        <button type="button" onclick="nextStep(1)" class="px-12 py-8 bg-white border border-gray-100 rounded-[2.5rem] text-gray-400 font-black uppercase tracking-widest text-xs hover:bg-gray-50 active:scale-95 transition-all">Volver</button>
                    </div>
                </div>
            </div>

            <!-- STEP 3: TIPO ATENCIÓN -->
            <div id="step3" class="step-content flex-col items-center justify-center p-10 space-y-10">
                <div class="text-center space-y-4">
                    <h3 class="text-7xl font-black text-gray-900 tracking-tighter italic leading-none">Perfil de Atención</h3>
                    <p class="text-base text-gray-400 font-bold uppercase tracking-[0.5em] mt-4">¿Cuál es su categoría de usuario?</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 w-full max-w-7xl">
                    @php 
                    $types = [
                        ['id' => 'General', 'icon' => 'fa-users', 'title' => 'General', 'desc' => 'Atención Normal'],
                        ['id' => 'Prioritario', 'icon' => 'fa-person-cane', 'title' => 'Prioritario', 'desc' => 'Adulto Mayor / Discapacidad'],
                        ['id' => 'Victimas', 'icon' => 'fa-certificate', 'title' => 'Víctima', 'desc' => 'Prioridad Máxima']
                    ];
                    @endphp
                    @foreach($types as $t)
                    <button type="button" onclick="selectType('{{ $t['id'] }}')" class="flex flex-col items-center justify-center bg-white p-14 rounded-[5rem] border border-gray-100 shadow-2xl hover:shadow-sena-500/10 hover:border-sena-500 transition-all duration-500 group">
                        <div class="w-32 h-32 bg-gray-50 group-hover:bg-sena-500 group-hover:text-white rounded-full flex items-center justify-center text-gray-300 transition-all duration-700 shadow-inner group-hover:scale-110">
                            <i class="fa-solid {{ $t['icon'] }} text-6xl"></i>
                        </div>
                        <div class="mt-10 text-center">
                            <h4 class="text-3xl font-black text-gray-900 tracking-tight">{{ $t['title'] }}</h4>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-2">{{ $t['desc'] }}</p>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- STEP 4: IDENTIDAD -->
            <div id="step4" class="step-content flex-col items-center justify-center p-10 space-y-8">
                <div class="text-center space-y-4">
                    <h3 class="text-7xl font-black text-gray-900 tracking-tighter italic">Identificación</h3>
                    <p class="text-base text-gray-400 font-bold uppercase tracking-[0.5em]">Ingreso de número de documento</p>
                </div>

                <div class="w-full max-w-3xl space-y-12">
                    <div class="flex p-3 bg-gray-100/50 rounded-[3rem] border border-white shadow-inner">
                        @foreach(['CC' => 'Cédula', 'TI' => 'Tarjeta', 'NIT' => 'NIT'] as $val => $label)
                        <button type="button" onclick="setDocType('{{ $val }}', this)" class="doc-tab-btn flex-1 py-6 text-base font-black {{ $val == 'CC' ? 'bg-white text-sena-500 shadow-xl' : 'text-gray-400' }} rounded-[2.2rem] uppercase tracking-widest transition-all">
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>

                    <div class="bg-white border-4 border-gray-50 rounded-[4rem] px-16 h-32 flex items-center justify-center shadow-3xl">
                        <span id="docDisplay" class="text-[5rem] font-black text-gray-900 tracking-wider">0000000000</span>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        @for($i=1;$i<=9;$i++)
                        <button type="button" onclick="pressNum('{{ $i }}')" class="numpad-key">{{ $i }}</button>
                        @endfor
                        <button type="button" onclick="clearNum()" class="numpad-key text-rose-500 hover:bg-rose-50 border-rose-100 hover:border-rose-200"><i class="fa-solid fa-trash-can"></i></button>
                        <button type="button" onclick="pressNum('0')" class="numpad-key">0</button>
                        <button type="button" onclick="backspace()" class="numpad-key text-amber-500 hover:bg-amber-50 border-amber-100 hover:border-amber-200"><i class="fa-solid fa-delete-left"></i></button>
                    </div>

                    <button type="button" onclick="validateDoc()" class="w-full text-2xl py-10 rounded-[3.5rem] bg-gradient-to-r from-sena-500 to-sena-600 text-white font-bold shadow-[0_15px_30px_-10px_rgba(57,169,0,0.3)] hover:shadow-2xl hover:-translate-y-1 active:scale-95 transition-all duration-300 flex items-center justify-center space-x-4 uppercase tracking-[0.1em] border border-white/10">
                        <span>CONFIRMAR IDENTIDAD</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 5: CONTACTO -->
            <div id="step5" class="step-content flex-col items-center justify-center p-10 space-y-8">
                <div class="text-center space-y-4">
                    <h3 class="text-7xl font-black text-gray-900 tracking-tighter italic leading-none">Datos de Contacto</h3>
                    <p class="text-base text-gray-400 font-bold uppercase tracking-[0.5em] mt-4">Ingrese su número celular para el turno</p>
                </div>

                <div class="w-full max-w-3xl space-y-8">
                    <div class="bg-white border-4 border-gray-50 rounded-[4rem] px-16 h-32 flex flex-col items-center justify-center shadow-3xl">
                        <span id="phoneDisplay" class="text-[5rem] font-black text-gray-900 tracking-wider">300 000 0000</span>
                        <div class="flex items-center space-x-3 mt-2">
                             <div class="w-2 h-2 rounded-full bg-sena-500 animate-pulse"></div>
                             <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Enlace de notificación Móvil</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        @for($i=1;$i<=9;$i++)
                        <button type="button" onclick="pressPhone('{{ $i }}')" class="numpad-key">{{ $i }}</button>
                        @endfor
                        <button type="button" onclick="phoneNumber=''" class="numpad-key text-gray-300"><i class="fa-solid fa-rotate-right"></i></button>
                        <button type="button" onclick="pressPhone('0')" class="numpad-key">0</button>
                        <button type="button" onclick="backspacePhone()" class="numpad-key text-gray-300"><i class="fa-solid fa-delete-left"></i></button>
                    </div>

                    <button type="button" onclick="nextStep(6)" class="w-full text-2xl py-10 rounded-[3.5rem] bg-gradient-to-r from-sena-500 to-sena-600 text-white font-bold shadow-[0_15px_30px_-10px_rgba(57,169,0,0.3)] hover:shadow-2xl hover:-translate-y-1 active:scale-95 transition-all duration-300 flex items-center justify-center space-x-4 uppercase tracking-[0.1em] border border-white/10">
                        <span>CONTINUAR</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 6: RECEPCIÓN -->
            <div id="step6" class="step-content flex-col items-center justify-center p-20 space-y-16">
                <div class="text-center space-y-4">
                    <h3 class="text-7xl font-black text-gray-900 tracking-tighter italic leading-none">Canal de Entrega</h3>
                    <p class="text-base text-gray-400 font-bold uppercase tracking-[0.5em] mt-4">¿Por qué medio desea recibir su turno?</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 w-full max-w-7xl">
                    @php 
                    $methods = [
                        ['id' => 'SMS', 'icon' => 'fa-comment-sms', 'title' => 'SMS'],
                        ['id' => 'WhatsApp', 'icon' => 'fa-whatsapp', 'title' => 'WhatsApp'],
                        ['id' => 'Email', 'icon' => 'fa-envelope', 'title' => 'Email'],
                        ['id' => 'QR', 'icon' => 'fa-qrcode', 'title' => 'Código QR']
                    ];
                    @endphp
                    @foreach($methods as $m)
                    <button type="button" onclick="setReceiveMethod('{{ $m['id'] }}', this)" class="receive-card flex flex-col items-center justify-center bg-white p-12 rounded-[4.5rem] border-2 {{ $m['id'] == 'SMS' ? 'border-sena-500 shadow-2xl' : 'border-gray-50 opacity-60' }} transition-all group">
                        <div class="w-24 h-24 {{ $m['id'] == 'SMS' ? 'bg-sena-500 text-white' : 'bg-gray-50 text-gray-300' }} rounded-3xl flex items-center justify-center text-4xl shadow-inner transition-colors group-hover:scale-110">
                            <i class="fa-solid {{ $m['icon'] }}"></i>
                        </div>
                        <h4 class="mt-8 text-2xl font-black text-gray-900 uppercase tracking-tighter">{{ $m['title'] }}</h4>
                    </button>
                    @endforeach
                </div>

                <div class="flex space-x-8 w-full max-w-4xl mt-12">
                    <button type="button" onclick="nextStep(5)" class="px-14 py-8 bg-white border border-gray-100 rounded-[3rem] text-gray-400 font-black uppercase tracking-widest text-xs hover:bg-gray-50 active:scale-95 transition-all flex items-center space-x-6">
                        <i class="fa-solid fa-arrow-left"></i><span>Volver</span>
                    </button>
                    <button type="submit" class="flex-1 text-2xl py-10 rounded-[3.5rem] bg-gradient-to-r from-sena-500 to-sena-600 text-white font-bold shadow-[0_15px_30px_-10px_rgba(57,169,0,0.3)] hover:shadow-2xl hover:-translate-y-1 active:scale-95 transition-all duration-300 flex items-center justify-center space-x-4 uppercase tracking-[0.1em] border border-white/10">
                        <span>GENERAR TURNO FINAL</span>
                        <i class="fa-solid fa-ticket"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>

    <!-- MODAL DE ÉXITO -->
    @if(session('success'))
    <div id="successModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-2xl rounded-[4rem] p-16 shadow-2xl flex flex-col items-center text-center space-y-10 border border-gray-100 transition-transform">
            
            <!-- Icono Animado -->
            <div class="w-32 h-32 bg-sena-50 rounded-full flex items-center justify-center relative">
                <div class="absolute inset-0 bg-sena-500/20 rounded-full animate-ping"></div>
                <i class="fa-solid fa-check text-6xl text-sena-500 relative z-10"></i>
            </div>

            <div class="space-y-4">
                <h3 class="text-5xl font-poppins font-black text-gray-900 tracking-tight leading-none italic">¡Turno Generado!</h3>
                <p class="text-xl font-medium text-gray-400 uppercase tracking-[0.3em]">Su proceso ha finalizado con éxito</p>
            </div>

            <!-- Número del Turno -->
            <div class="bg-gray-50/50 border-2 border-dashed border-sena-500/30 rounded-[3rem] px-16 py-10 w-full group overflow-hidden relative">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-sena-500/5 rounded-full blur-2xl group-hover:bg-sena-500/10 transition-colors"></div>
                <p class="text-sm font-bold text-sena-500 uppercase tracking-widest mb-1">SU NÚMERO DE TURNO ES:</p>
                <div class="text-9xl font-poppins font-black text-gray-900 tracking-tighter">
                    {{ str_replace('Turno solicitado con éxito: ', '', session('success')) }}
                </div>
            </div>

            <div class="space-y-6 w-full">
                <div class="flex items-center justify-center space-x-3 text-gray-400">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span class="text-xs font-bold uppercase tracking-widest">Esta ventana se cerrará automáticamente</span>
                </div>
                
                <button onclick="closeModal()" class="w-full py-8 rounded-[2.5rem] bg-gray-900 text-white font-black text-xl uppercase tracking-widest hover:bg-black transition-all shadow-xl active:scale-95">
                    FINALIZAR AHORA
                </button>
            </div>
        </div>
    </div>
    <script>
        function closeModal() {
            const modal = document.getElementById('successModal');
            modal.style.opacity = '0';
            setTimeout(() => modal.style.display = 'none', 300);
        }
        // Auto-cierre tras 8 segundos
        setTimeout(closeModal, 8000);
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

    <script>
        let docNumber = "";
        let phoneNumber = "";

        function nextStep(step) {
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
                b.classList.remove('bg-white', 'text-sena-500', 'shadow-xl');
                b.classList.add('text-gray-400');
            });
            btn.classList.add('bg-white', 'text-sena-500', 'shadow-xl');
            btn.classList.remove('text-gray-400');
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
            d.style.color = phoneNumber ? "#111827" : "#f1f8e9";
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

        window.onload = () => { updateDocDisplay(); updatePhoneDisplay(); };
    </script>
</body>
</html>
