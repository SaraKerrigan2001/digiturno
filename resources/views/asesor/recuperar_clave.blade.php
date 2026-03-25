<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Clave - SENA APE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
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
                        sena: { 50: '#f1f8e9', 100: '#dcedc8', 500: '#39A900', 600: '#2d8700', 900: '#1a4d00' } 
                    },
                    boxShadow: {
                        'soft': '0 10px 25px -5px rgba(57, 169, 0, 0.1), 0 8px 10px -6px rgba(57, 169, 0, 0.1)',
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in { animation: fadeIn 0.6s ease-out forwards; opacity: 0; }
        .slide-up { animation: slideUp 0.6s ease-out forwards; opacity: 0; transform: translateY(20px); }
        .delay-100 { animation-delay: 100ms; }
        @keyframes fadeIn { to { opacity: 1; } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Background Decorators -->
    <div class="absolute top-0 left-0 w-full h-96 bg-sena-500/10 skew-y-6 origin-top-left -z-10"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-sena-500/20 rounded-full blur-3xl -z-10"></div>

    <div class="w-full max-w-md bg-white p-10 rounded-3xl shadow-2xl border border-gray-100 slide-up relative z-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-gray-50 p-4 rounded-2xl w-20 h-20 mx-auto mb-6 flex items-center justify-center shadow-inner">
                <i class="fa-solid fa-key text-3xl text-sena-500"></i>
            </div>
            <h1 class="text-2xl font-poppins font-semibold text-gray-900 tracking-tight mb-2">Recuperar Contraseña</h1>
            <p class="text-gray-500 text-sm font-normal">Ingrese el correo electrónico asociado a su cuenta. Enviaremos instrucciones para restablecerla.</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-start space-x-3 text-green-700 mb-8 fade-in">
            <i class="fa-solid fa-circle-check mt-0.5"></i>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Form -->
        <form action="#" method="GET" class="space-y-6">
            @csrf
            
            <div class="space-y-1.5 group">
                <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider ml-1 group-focus-within:text-sena-600 transition-colors">
                    Correo Institucional
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-sena-500 transition-colors">
                        <i class="fa-regular fa-envelope text-lg"></i>
                    </div>
                    <input type="email" name="email" required
                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl text-gray-800 focus:bg-white focus:border-sena-500 focus:ring-4 focus:ring-sena-500/10 outline-none transition-all duration-300 placeholder:text-gray-400 font-medium"
                        placeholder="usuario@sena.edu.co">
                </div>
            </div>

            <div class="pt-2">
                <!-- For demo purposes, we will just simulate a success message or redirect -->
                <button type="submit" onclick="event.preventDefault(); document.getElementById('success-msg').classList.remove('hidden');"
                    class="w-full bg-sena-500 hover:bg-sena-600 text-white font-semibold py-3.5 rounded-xl shadow-soft hover:shadow-lg hover:-translate-y-0.5 active:scale-[0.98] transition-all duration-300 flex items-center justify-center">
                    <span class="tracking-wide text-sm">Enviar Instrucciones</span>
                    <i class="fa-regular fa-paper-plane ml-2"></i>
                </button>
            </div>
            
            <div id="success-msg" class="hidden bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 text-sm text-center mt-4">
                Instrucciones enviadas correctamente. Revisa tu bandeja de entrada.
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('asesor.login') }}" class="text-sm font-medium text-gray-500 hover:text-sena-600 transition-colors inline-flex items-center">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver al Login
                </a>
            </div>
        </form>
    </div>
</body>
</html>
