<x-admin-layout>
    <div class="py-10 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Contenedor Principal Estilizado --}}
            <div class="bg-gray-950 border border-white/5 overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.7)] sm:rounded-3xl p-10 relative">
                
                {{-- Línea de acento superior sutil --}}
                <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-red-800 to-transparent opacity-40"></div>

                {{-- CABECERA DEL DASHBOARD --}}
                <div class="flex flex-col items-center text-center mb-12 pb-10 border-b border-white/5">
                    
                    {{-- LOGO (Llamado exacto solicitado) --}}
                    <div class="shrink-0 flex items-center mb-6">
                        <a href="#" class="group flex items-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Prime Cinemas"
                                class="w-auto h-16 object-contain transition-all duration-500 group-hover:scale-110 filter drop-shadow-[0_0_15px_rgba(220,38,38,0.4)]">
                        </a>
                    </div>

                    <p class="text-gray-600 mb-2 uppercase tracking-[0.4em] text-[9px] font-black">
                        Management System Engine
                    </p>
                    
                    <h3 class="text-4xl font-black text-white mb-3 uppercase tracking-tighter">
                        Terminal de <span class="text-red-600">Control</span>
                    </h3>
                    
                    <div class="flex items-center gap-3 px-5 py-2 bg-white/5 rounded-full border border-white/10">
                        <div class="w-2 h-2 rounded-full bg-red-600 animate-pulse shadow-[0_0_8px_#dc2626]"></div>
                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">
                            ¡Bienvenido <span class="text-white">{{ Auth::user()->nombres }}</span>!
                        </span>
                    </div>
                </div>

                {{-- SECCIONES DE GESTIÓN (GRID) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- Gestión de Películas --}}
                    <div class="lg:col-span-2 bg-gray-900 border border-gray-800 p-8 rounded-2xl hover:border-red-900/50 transition-all duration-500 group relative overflow-hidden flex items-center justify-between shadow-2xl">
                        <div class="absolute -right-8 -bottom-8 text-[140px] opacity-[0.03] group-hover:opacity-[0.07] transition-opacity pointer-events-none">🎞️</div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-4">
                                <span class="p-3 bg-red-600/10 rounded-lg text-2xl">🎬</span>
                                <h4 class="text-white font-black uppercase text-lg tracking-widest">Cartelera Central</h4>
                            </div>
                            <p class="text-gray-500 text-xs mb-8 max-w-sm leading-relaxed">Administración integral del catálogo: estrenos, edición de metadatos y control de estados de emisión.</p>
                            <div class="flex gap-4">
                                <a href="{{ route('peliculas.index') }}"
                                   class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white text-[10px] font-black px-8 py-3.5 rounded-md transition-all shadow-lg shadow-red-900/30 uppercase tracking-[0.1em]">
                                   Abrir Catálogo
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Usuarios --}}
                    <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl hover:border-white/10 transition-all duration-500 group flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <span class="p-3 bg-white/5 rounded-lg text-2xl">👥</span>
                                <h4 class="text-white font-black uppercase text-base tracking-widest">Seguridad</h4>
                            </div>
                            <p class="text-gray-500 text-xs mb-6">Gestión de privilegios y perfiles de usuario dentro del sistema.</p>
                        </div>
                        <a href="{{ route('usuarios.index') }}"
                           class="w-full text-center bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white text-[10px] font-black py-3 rounded-md transition-all uppercase tracking-widest border border-gray-700">
                           Ver Usuarios
                        </a>
                    </div>

                    {{-- Parámetros Base --}}
                    <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl hover:border-white/10 transition-all duration-500 flex flex-col">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="p-3 bg-white/5 rounded-lg text-2xl">🏷️</span>
                            <h4 class="text-white font-black uppercase text-base tracking-widest">Parámetros</h4>
                        </div>
                        <div class="space-y-3">
                            <a href="{{ route('generos.index') }}" class="group flex justify-between items-center bg-black/40 hover:bg-red-600/10 px-5 py-3.5 rounded-lg text-gray-400 hover:text-red-500 transition-all border border-gray-800/50">
                                <span class="text-[10px] font-black uppercase tracking-widest">Géneros</span>
                                <span class="text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                            </a>
                            <a href="{{ route('clasificaciones.index') }}" class="group flex justify-between items-center bg-black/40 hover:bg-red-600/10 px-5 py-3.5 rounded-lg text-gray-400 hover:text-red-500 transition-all border border-gray-800/50">
                                <span class="text-[10px] font-black uppercase tracking-widest">Clasificaciones</span>
                                <span class="text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                            </a>
                        </div>
                    </div>

                    {{-- Talento --}}
                    <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl hover:border-white/10 transition-all duration-500 group flex flex-col">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="p-3 bg-white/5 rounded-lg text-2xl">🎭</span>
                            <h4 class="text-white font-black uppercase text-base tracking-widest">Personal</h4>
                        </div>
                        <p class="text-gray-500 text-xs mb-8 flex-grow">Base de datos de celebridades, directores y equipo técnico vinculado a producciones.</p>
                        <a href="{{ route('personas.index') }}" class="text-center bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white text-[10px] font-black py-3 rounded-md transition-all uppercase tracking-widest border border-gray-700">Explorar Talento</a>
                    </div>

                    {{-- Moderación --}}
                    <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl hover:border-yellow-900/30 transition-all duration-500 group flex flex-col">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="p-3 bg-yellow-600/10 rounded-lg text-2xl text-yellow-600">⭐</span>
                            <h4 class="text-white font-black uppercase text-base tracking-widest">Críticas</h4>
                        </div>
                        <p class="text-gray-500 text-xs mb-8 flex-grow">Supervisión de comentarios y gestión de calificaciones de la comunidad cinéfila.</p>
                        <a href="{{ route('criticas.index') }}"
                           class="w-full text-center bg-yellow-950/10 hover:bg-yellow-900/20 text-yellow-600 text-[10px] font-black py-3 rounded-md transition-all uppercase tracking-widest border border-yellow-900/30">
                           Moderar
                        </a>
                    </div>

                </div>

                {{-- Indicador de Sistema Inferior --}}
                <div class="mt-16 pt-8 border-t border-white/5 flex justify-center">
                    <div class="flex items-center gap-6">
                        <span class="text-gray-700 text-[9px] font-mono uppercase tracking-[0.4em]">Engine Status: Nominal</span>
                        <span class="w-1 h-1 bg-gray-800 rounded-full"></span>
                        <span class="text-gray-700 text-[9px] font-mono uppercase tracking-[0.4em]">Connection: Secure</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>