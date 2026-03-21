<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENA APE - Kiosco Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
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
            overflow: hidden;
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
            @apply flex items-center justify-center p-8 text-4xl font-extrabold text-gray-800 bg-gray-50/50 rounded-[2rem] border border-gray-100 hover:bg-white hover:shadow-xl active:scale-90 transition-all;
        }

        /* Progress Bar */
        .progress-dot { @apply w-2.5 h-2.5 rounded-full bg-gray-200 transition-all duration-500; }
        .progress-dot.active { @apply bg-sena-500 w-8; }

        .btn-sena {
            @apply bg-sena-500 text-white font-black py-7 rounded-[2rem] shadow-xl hover:bg-sena-600 active:scale-95 transition-all flex items-center justify-center space-x-4 uppercase tracking-[0.2em];
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #39A900; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-8">

    <div class="w-full max-w-7xl min-h-[850px] main-card rounded-[4.5rem] flex flex-col items-center relative overflow-hidden">
        
        <!-- Header Universal -->
        <header class="w-full px-16 py-10 flex justify-between items-center border-b border-gray-100/50">
            <div class="flex items-center space-x-5">
                <img src="{{ asset('images/Logo.png') }}" class="h-10 w-auto" alt="Logo">
                <div class="h-8 w-px bg-gray-200"></div>
                <div>
                    <h1 class="text-xs font-black text-gray-900 uppercase tracking-widest leading-none">Agencia Pública de Empleo</h1>
                    <p class="text-[9px] font-bold text-sena-500 uppercase tracking-[0.3em] mt-1">Kiosco de Turnos Digital</p>
                </div>
            </div>
            <div id="stepIndicator" class="flex items-center space-x-2">
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
            <div id="step1" class="step-content active flex-col items-center justify-center text-center p-20 space-y-16">
                <div class="relative group">
                    <div class="absolute -inset-16 bg-sena-500/5 blur-[120px] rounded-full"></div>
                    <img src="{{ asset('images/Logo.png') }}" class="w-64 h-auto relative z-10 drop-shadow-2xl animate-bounce-slow" style="animation: bounce 3s infinite ease-in-out;">
                </div>

                <div class="space-y-8 max-w-4xl">
                    <h2 class="text-[5.5rem] font-black leading-[0.9] text-gray-900 tracking-tighter italic">Solicitud de <br><span class="text-sena-500">Turno Digital</span></h2>
                    <p class="text-xl font-medium text-gray-400 uppercase tracking-[0.4em]">Toque el botón inferior para comenzar su trámite</p>
                </div>

                <button type="button" onclick="nextStep(2)" class="btn-sena w-full max-w-sm text-2xl py-8 mt-10">
                    <span>EMPEZAR AQUÍ</span>
                    <i class="fa-solid fa-chevron-right text-base"></i>
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
            <div id="step3" class="step-content flex-col items-center justify-center p-20 space-y-16">
                <div class="text-center space-y-4">
                    <h3 class="text-7xl font-black text-gray-900 tracking-tighter italic leading-none">Perfil de Atención</h3>
                    <p class="text-base text-gray-400 font-bold uppercase tracking-[0.5em] mt-4">¿Cuál es su categoría de usuario?</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 w-full max-w-7xl">
                    @php 
                    $types = [
                        ['id' => 'General', 'icon' => 'fa-users', 'title' => 'General', 'desc' => 'Público Externo'],
                        ['id' => 'Prioritario', 'icon' => 'fa-person-cane', 'title' => 'Prioritario', 'desc' => 'Adulto Mayor / Discapacidad'],
                        ['id' => 'Victimas', 'icon' => 'fa-certificate', 'title' => 'Especial', 'desc' => 'Población Vulnerable']
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
            <div id="step4" class="step-content flex-col items-center justify-center p-20 space-y-16">
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

                    <div class="bg-white border-4 border-gray-50 rounded-[4rem] px-16 h-48 flex items-center justify-center shadow-3xl">
                        <span id="docDisplay" class="text-[7.5rem] font-black text-gray-900 tracking-wider">0000000000</span>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        @for($i=1;$i<=9;$i++)
                        <button type="button" onclick="pressNum('{{ $i }}')" class="numpad-key">{{ $i }}</button>
                        @endfor
                        <button type="button" onclick="clearNum()" class="numpad-key text-rose-500 hover:bg-rose-50 border-rose-100 hover:border-rose-200"><i class="fa-solid fa-trash-can"></i></button>
                        <button type="button" onclick="pressNum('0')" class="numpad-key">0</button>
                        <button type="button" onclick="backspace()" class="numpad-key text-amber-500 hover:bg-amber-50 border-amber-100 hover:border-amber-200"><i class="fa-solid fa-delete-left"></i></button>
                    </div>

                    <button type="button" onclick="validateDoc()" class="btn-sena w-full text-2xl py-10 rounded-[3.5rem] shadow-2xl">
                        <span>CONFIRMAR IDENTIDAD</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 5: CONTACTO -->
            <div id="step5" class="step-content flex-col items-center justify-center p-20 space-y-16">
                <div class="text-center space-y-4">
                    <h3 class="text-7xl font-black text-gray-900 tracking-tighter italic leading-none">Datos de Contacto</h3>
                    <p class="text-base text-gray-400 font-bold uppercase tracking-[0.5em] mt-4">Ingrese su número celular para el turno</p>
                </div>

                <div class="w-full max-w-3xl space-y-12">
                    <div class="bg-white border-4 border-gray-50 rounded-[4rem] px-16 h-48 flex flex-col items-center justify-center shadow-3xl">
                        <span id="phoneDisplay" class="text-[7.5rem] font-black text-gray-900 tracking-wider">300 000 0000</span>
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

                    <button type="button" onclick="nextStep(6)" class="btn-sena w-full text-2xl py-10 rounded-[3.5rem] shadow-2xl">
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
                    <button type="submit" class="btn-sena flex-1 text-2xl py-10 rounded-[3.5rem] shadow-2xl">
                        <span>GENERAR TURNO FINAL</span>
                        <i class="fa-solid fa-ticket"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>

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
