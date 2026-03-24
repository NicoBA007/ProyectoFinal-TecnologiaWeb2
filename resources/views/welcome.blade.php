<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeCinemas - Cochabamba</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    @livewireStyles
</head>
<body class="bg-gray-950 text-white font-sans antialiased selection:bg-red-600 selection:text-white">

    <nav class="fixed w-full z-50 bg-gray-950/80 backdrop-blur-md border-b border-gray-800">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-black tracking-tighter flex items-center gap-2">
                <span class="text-3xl">🎬</span> 
                <span class="text-white">Prime</span><span class="text-red-600">Cinemas</span>
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="#" class="text-gray-300 hover:text-red-500 font-medium transition-colors">Cartelera</a>
                <a href="#" class="text-gray-300 hover:text-red-500 font-medium transition-colors">Próximos Estrenos</a>
                <a href="#" class="text-gray-300 hover:text-red-500 font-medium transition-colors">Snacks</a>
            </div>

            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white font-medium transition-colors">Mi Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-medium transition-colors">Ingresar</a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full font-bold transition-all shadow-[0_0_15px_rgba(220,38,38,0.5)] hover:shadow-[0_0_25px_rgba(220,38,38,0.7)] transform hover:-translate-y-0.5">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main class="pt-32 pb-16 px-6">
        <div class="container mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16 mt-10">
                <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-gray-200 to-gray-500">
                    Vive el cine como nunca antes
                </h1>
                <p class="text-gray-400 text-xl mb-10">
                    La comunidad cinéfila más grande de Cochabamba. Descubre, califica y debate sobre los mejores estrenos.
                </p>
                <a href="#cartelera" class="inline-block border-2 border-red-600 text-red-500 hover:bg-red-600 hover:text-white px-8 py-3 rounded-full font-bold transition-all">
                    Ver Cartelera de Hoy
                </a>
            </div>

            <div id="cartelera" class="mt-20">
                <div class="flex justify-between items-end mb-8">
                    <h2 class="text-3xl font-bold border-l-4 border-red-600 pl-4">En Cartelera</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <div class="bg-gray-900 rounded-xl overflow-hidden border border-gray-800 hover:border-red-600 transition-colors group cursor-pointer">
                        <div class="h-80 bg-gray-800 relative">
                            <div class="absolute inset-0 flex items-center justify-center text-gray-600">Póster Película 1</div>
                            <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">ESTRENO</div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-xl mb-1 group-hover:text-red-500 transition-colors">Duna: Parte Dos</h3>
                            <p class="text-sm text-gray-400 mb-3">Ciencia Ficción • 2h 46m</p>
                            <div class="flex text-yellow-500 text-sm">
                                ⭐⭐⭐⭐⭐ <span class="text-gray-500 ml-2">(4.8)</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-xl overflow-hidden border border-gray-800 hover:border-red-600 transition-colors group cursor-pointer">
                        <div class="h-80 bg-gray-800 relative">
                            <div class="absolute inset-0 flex items-center justify-center text-gray-600">Póster Película 2</div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-xl mb-1 group-hover:text-red-500 transition-colors">Kung Fu Panda 4</h3>
                            <p class="text-sm text-gray-400 mb-3">Animación • 1h 34m</p>
                            <div class="flex text-yellow-500 text-sm">
                                ⭐⭐⭐⭐ <span class="text-gray-500 ml-2">(4.1)</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-900 rounded-xl overflow-hidden border border-gray-800 hover:border-red-600 transition-colors group cursor-pointer">
                        <div class="h-80 bg-gray-800 relative">
                            <div class="absolute inset-0 flex items-center justify-center text-gray-600">Póster Película 3</div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-xl mb-1 group-hover:text-red-500 transition-colors">Godzilla y Kong</h3>
                            <p class="text-sm text-gray-400 mb-3">Acción • 1h 55m</p>
                            <div class="flex text-yellow-500 text-sm">
                                ⭐⭐⭐ <span class="text-gray-500 ml-2">(3.5)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @livewireScripts
</body>
</html>