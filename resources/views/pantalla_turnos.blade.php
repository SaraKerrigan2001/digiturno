<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Turnos - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                        sena: { 500: '#39A900', 600: '#2d8700', 50: '#e8f5e9' }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#f0f2f5] text-gray-800 font-sans h-screen flex flex-col overflow-hidden">

    <!-- Header -->
    <header
        class="bg-white px-8 py-4 flex justify-between items-center shrink-0 border-b border-gray-200 shadow-sm relative z-20">
        <div class="flex items-center space-x-6">
            <img src="{{ asset('images/logoSena.png') }}" class="h-16 w-auto object-contain" alt="SENA Logo">
            <div class="h-10 w-px bg-gray-200"></div>
            <div>
                <h1 class="text-3xl font-poppins font-black text-gray-900 tracking-tight leading-none mb-1">SENA</h1>
                <p class="text-xs font-bold text-gray-500 tracking-widest uppercase">Sistema de Gestión de Turnos</p>
            </div>
        </div>
        <div class="flex items-center space-x-10 text-right">
            <div>
                <p class="text-3xl font-black text-gray-800 tracking-tight" id="current-time">10:45 AM</p>
                <p class="text-sm font-medium text-gray-500 mt-1" id="current-date">Actualizando...</p>
            </div>
            <div
                class="flex items-center space-x-3 text-gray-700 bg-gray-50 px-4 py-2 flex-col rounded-xl border border-gray-100 shadow-inner">
                <div class="flex space-x-2 items-center">
                    <i class="fa-regular fa-sun text-sena-500 text-2xl"></i>
                    <span class="text-xl font-black text-gray-800">24°C</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex p-6 gap-6 overflow-hidden min-h-0 relative z-10 w-full">

        <!-- Left Column: Turnos (Approx 38% width for better fit) -->
        <div
            class="w-[38%] bg-white rounded-[2rem] shadow-sm border border-gray-200 flex flex-col overflow-hidden relative">

            <!-- Header Left -->
            <div class="p-6 md:p-8 flex justify-between items-center shrink-0">
                <div class="flex items-center space-x-4">
                    <i class="fa-solid fa-list-check text-sena-500 text-2xl"></i>
                    <h2 class="text-2xl font-black text-gray-800 tracking-tight">Turnos en Atención</h2>
                </div>
                <span
                    class="bg-[#e8f5e9] text-[#2d8700] text-sm font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">En
                    vivo</span>
            </div>

            <!-- Table Header -->
            <div
                class="grid grid-cols-5 bg-[#f8fafc] px-6 py-4 border-y border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider shrink-0">
                <div class="col-span-2 text-left ml-6">TURNO</div>
                <div class="col-span-3">MÓDULO / PROFESIONAL</div>
            </div>

            <!-- List -->
            <div class="flex-1 overflow-auto pb-32">
                @forelse($turnosEnEspera as $turno)
                    <div class="grid grid-cols-5 px-6 py-6 border-b border-gray-100 items-center hover:bg-gray-50 transition relative">
                        <!-- Indicador de prioridad lateral -->
                        <div class="absolute left-0 top-2 bottom-2 w-1.5 {{ $turno->tur_tipo == 'Victimas' ? 'bg-rose-500' : ($turno->tur_tipo == 'Prioritario' ? 'bg-amber-500' : 'bg-sena-500') }} rounded-r-full"></div>

                        <div class="col-span-2 text-[2.75rem] font-black text-[#2e384d] tracking-tight ml-4">
                            {{ $turno->tur_numero }}</div>
                        <div class="col-span-3 text-lg font-semibold text-[#4a5568] leading-tight">
                            <span class="text-xs font-black uppercase tracking-widest px-2 py-1 rounded {{ $turno->tur_tipo == 'Victimas' ? 'bg-rose-500 text-white' : ($turno->tur_tipo == 'Prioritario' ? 'bg-amber-500 text-white' : 'bg-sena-50 text-sena-600') }} mb-2 inline-block">
                                {{ $turno->tur_tipo == 'Victimas' ? 'Urgente' : ($turno->tur_tipo == 'Prioritario' ? 'Prioridad' : 'General') }}
                            </span><br>
                            <span class="text-base font-medium text-gray-400">En espera</span>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-500 text-lg font-medium">No hay turnos en espera</div>
                @endforelse

                @if($turnoActual)
                    <div class="grid grid-cols-5 px-6 py-6 border-b border-gray-100 items-center bg-[#f0fdf4] relative animate-pulse">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-sena-500"></div>
                        <div class="col-span-2 text-[3rem] font-black text-[#15803d] tracking-tight ml-4">
                            {{ $turnoActual->tur_numero ?? '---' }}</div>
                        <div class="col-span-3 text-lg font-semibold text-[#4a5568] leading-tight">
                            <p class="text-xs font-black text-sena-600 uppercase tracking-[0.2em] mb-1">Pasar a:</p>
                            <span class="text-2xl font-black text-gray-900">Módulo {{ sprintf('%02d', $turnoActual->modulo ?? '01') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Bottom Fixed Box (Próximo en llamado) -->
            <!-- In the array we might pick the last one or just the current if available to simulate the design. -->
            <div
                class="absolute bottom-6 left-6 right-6 bg-[#0f172a] rounded-2xl p-6 flex justify-between items-center text-white shadow-2xl overflow-hidden">
                <!-- Background Subtle Glow -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#0f172a] to-[#1e293b] z-0"></div>

                <div class="relative z-10 flex flex-col justify-center">
                    <p class="text-gray-400 text-sm font-semibold tracking-wider uppercase mb-1">Próximo en llamado:</p>
                    <div class="flex items-baseline space-x-4">
                        <span
                            class="text-4xl font-black text-white tracking-tight">{{ $turnoActual->tur_numero ?? ($turnosEnEspera->first()->tur_numero ?? '---') }}</span>
                        <span class="text-gray-400 text-xl font-medium">Sala de espera 2</span>
                    </div>
                </div>
                <!-- Icon -->
                <div class="relative z-10 w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center">
                    <i class="fa-regular fa-calendar-check text-sena-500 text-4xl"></i>
                </div>
            </div>
        </div>

        <!-- Right Column: Media and Cards (Approx 62% width) -->
        <div class="w-[62%] flex flex-col gap-6 h-full">

            <!-- Video/Image Box -->
            <div
                class="flex-1 relative rounded-[2rem] overflow-hidden shadow-sm border border-gray-200 bg-black flex flex-col group">
                <!-- Video Player Component (YouTube API) -->
                <div class="relative flex-1 bg-gray-900 overflow-hidden pointer-events-none">
                    <!-- Scale transform helps the iframe mimic object-cover by bleeding edges out of view -->
                    <div class="absolute inset-0 w-full h-full transform scale-[1.35] transition-opacity duration-700" id="video-container">
                        <div id="youtube-player" class="w-full h-full"></div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/20 to-transparent"></div>
                </div>

                <!-- Text Overlay Layer (Inside video, bottom) -->
                <div class="absolute bottom-[5.5rem] left-10 right-10 z-10">
                    <h2 id="video-title" class="text-[2.2rem] font-bold text-white leading-tight drop-shadow-md transition-all duration-500">
                        SENA: Transformando el futuro de Colombia
                    </h2>
                </div>

                <!-- Bottom Solid Text Bar -->
                <div class="bg-[#111] px-10 py-5 min-h-[5.5rem] flex items-center z-10 border-t border-white/5">
                    <h3 id="video-subtitle" class="text-xl font-medium text-gray-400 tracking-wide m-0 leading-none transition-all duration-500">
                        Conoce nuestras nuevas convocatorias de formación titulada 2026
                    </h3>
                </div>
            </div>

            <!-- Bottom Cards Row (Fixed Height) -->
            <div class="flex gap-6 h-36 shrink-0">
                <!-- Card 1 -->
                <div
                    class="flex-1 bg-white rounded-[2rem] p-6 flex items-center gap-6 shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="w-16 h-16 rounded-[1.2rem] bg-[#e8f5e9] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-qrcode text-sena-500 text-3xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-1 leading-none tracking-tight">Descarga nuestra
                            App</h3>
                        <p class="text-sm text-gray-500 font-medium leading-[1.25]">Gestiona tus turnos
                            y<br>certificados desde tu celular.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="flex-1 bg-white rounded-[2rem] p-6 flex items-center gap-6 shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="w-16 h-16 rounded-[1.2rem] bg-[#e8f5e9] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-headset text-sena-500 text-3xl"></i>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h3 class="text-lg font-bold text-gray-900 mb-1 leading-none tracking-tight">¿Necesitas ayuda?
                        </h3>
                        <p class="text-sm text-gray-500 font-medium leading-[1.25]">Escanea el código QR en
                            los<br>módulos para asistencia.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer Marquee Fixed Height -->
    <footer
        class="h-[4.5rem] flex shrink-0 relative z-20 text-white overflow-hidden shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <!-- Left Banner (Matches Left Column Width exactly + gaps) -->
        <!-- We use roughly the width of the left column + padding approx w-[38%] -->
        <div class="bg-[#39A900] w-[40%] flex items-center pl-10 space-x-4 border-r border-[#2d8700]">
            <i class="fa-solid fa-bullhorn text-2xl"></i>
            <span class="text-lg font-bold tracking-widest uppercase">Agencia pública de empleo</span>
        </div>

        <!-- Right Banner Marquee -->
        <div class="bg-[#39A900] flex-1 flex items-center relative overflow-hidden">
            <div
                class="absolute flex items-center space-x-12 whitespace-nowrap animate-[marquee_25s_linear_infinite] pl-10 text-xl font-bold tracking-wide">
                <span>Noticias SENA: Abiertas las inscripciones para cursos cortos.</span>
                <span class="opacity-50">•</span>
                <span>Conoce el nuevo centro de innovación tecnológica.</span>
                <span class="opacity-50">•</span>
                <span>SENA: de clase mundial.</span>
            </div>
        </div>
    </footer>

    <style>
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* Hide scrollbar for the turns list to make it cleaner */
        .overflow-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: transparent;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
    </style>

    <!-- Script overlay fix y reloj -->
    <script>
        // Lógica de Playlist de YouTube
        const playlistIds = [
            { id: 'LT42fRHkxEc', title: 'Somos SENA', subtitle: 'Transformando el futuro de Colombia con educación' },
            { id: 'SqBeOiTOhE4', title: 'Formación para el Trabajo', subtitle: 'Capacitación integral para conectar con nuevas oportunidades' },
            { id: '7fQpAnZpEbk', title: 'Orgullo SENA', subtitle: 'Miles de talentos construyendo un mejor país' },
            { id: 'fmneZiWgtEU', title: 'Innovación y Futuro', subtitle: 'Apostando por la tecnología y el desarrollo regional' },
            { id: '2TVT-v56W9M', title: 'Crecemos Contigo', subtitle: 'Nuevas opciones de aprendizaje técnico y tecnológico' },
            { id: 'J5tfdua9zLo', title: 'Apoyo al Emprendimiento', subtitle: 'Tus ideas hechas realidad con Fondo Emprender' },
            { id: 'f2LA_i2MsPk', title: 'SENA es Empleo', subtitle: 'La Agencia Pública de Empleo más grande del país' }
        ];

        let currentVideoIndex = 0;
        const titleEl = document.getElementById('video-title');
        const subtitleEl = document.getElementById('video-subtitle');
        const videoContainer = document.getElementById('video-container');
        var player;

        // Cargar el script de YouTube IFrame API asíncronamente
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('youtube-player', {
                height: '100%',
                width: '100%',
                videoId: playlistIds[currentVideoIndex].id,
                playerVars: {
                    'autoplay': 1,
                    'controls': 0,
                    'disablekb': 1,
                    'fs': 0,
                    'modestbranding': 1,
                    'playsinline': 1,
                    'rel': 0,
                    'showinfo': 0,
                    'mute': 1,     // Requerido para autoplay en pantallas modernas
                    'loop': 0,
                    'iv_load_policy': 3
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        function onPlayerReady(event) {
            updateTextOverlay();
            event.target.playVideo();
        }

        function onPlayerStateChange(event) {
            // Cuando finaliza un video, pasar al siguiente
            if (event.data === YT.PlayerState.ENDED) {
                // Fade out text and container slightly
                videoContainer.style.opacity = '0.5';
                
                currentVideoIndex = (currentVideoIndex + 1) % playlistIds.length;
                player.loadVideoById(playlistIds[currentVideoIndex].id);
                updateTextOverlay();
                
                // Fade it back after short delay (let tube load next cache)
                setTimeout(() => { videoContainer.style.opacity = '1'; }, 1000);
            }
            if (event.data === YT.PlayerState.PLAYING) {
                videoContainer.style.opacity = '1';
            }
        }

        function updateTextOverlay() {
            const videoData = playlistIds[currentVideoIndex];
            
            // Animación Fade
            titleEl.style.opacity = '0';
            titleEl.style.transform = 'translateY(10px)';
            subtitleEl.style.opacity = '0';
            
            setTimeout(() => {
                titleEl.textContent = videoData.title;
                subtitleEl.textContent = videoData.subtitle;
                
                titleEl.style.opacity = '1';
                titleEl.style.transform = 'translateY(0)';
                subtitleEl.style.opacity = '1';
            }, 500);
        }

        // Reloj y Fecha
        function updateClock() {
            const now = new Date();
            const timeOptions = { hour: 'numeric', minute: '2-digit', hour12: true };
            const dateOptions = { year: 'numeric', month: 'long', day: 'numeric' };

            document.getElementById('current-time').textContent = now.toLocaleTimeString('es-CO', timeOptions).toUpperCase();
            document.getElementById('current-date').textContent = now.toLocaleDateString('es-CO', dateOptions);
        }
        updateClock(); /* Ejecutar primero antes del intervalo */
        setInterval(updateClock, 1000);
    </script>
</body>

</html>