<nav x-data="{ open: true }" 
    class="fixed left-0 top-0 h-screen z-50 transition-all duration-300 border-r border-white/5 bg-gray-950/95 backdrop-blur-xl shadow-[10px_0_30px_rgba(0,0,0,0.5)]"
    :class="open ? 'w-64' : 'w-20'">

    <div class="flex flex-col h-full py-8">
        
        <div class="px-6 mb-12 shrink-0 flex items-center justify-center">
            <a href="/" class="group flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Prime Cinemas"
                    class="w-auto object-contain transition-all duration-500 group-hover:scale-110 filter drop-shadow-[0_0_10px_rgba(220,38,38,0.3)]"
                    :class="open ? 'h-14' : 'h-8'">
            </a>
        </div>

        <div class="flex-grow px-4 space-y-8 overflow-y-auto custom-scrollbar">
            
            <div>
                <p x-show="open" class="px-4 mb-4 text-[10px] font-black text-gray-600 uppercase tracking-[0.3em]">Gestión de Contenido</p>
                <div class="space-y-1">
                    <a href="{{ route('peliculas.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/peliculas*') ? 'bg-red-600/10 text-red-500 border border-red-600/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <span class="text-lg">🎬</span>
                        <span x-show="open" class="ml-4 text-[11px] font-black uppercase tracking-widest">Películas</span>
                    </a>
                    <a href="{{ route('personas.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->is('admin/personas*') ? 'bg-red-600/10 text-red-500 border border-red-600/20' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <span class="text-lg">🎭</span>
                        <span x-show="open" class="ml-4 text-[11px] font-black uppercase tracking-widest">Talento & Staff</span>
                    </a>
                </div>
            </div>

            <div>
                <p x-show="open" class="px-4 mb-4 text-[10px] font-black text-gray-600 uppercase tracking-[0.3em]">Configuración Base</p>
                <div class="space-y-1">
                    <a href="{{ route('generos.index') }}" class="flex items-center px-4 py-3 rounded-xl {{ request()->is('admin/generos*') ? 'text-red-500 bg-white/5' : 'text-gray-400' }} hover:text-red-500 hover:bg-white/5 transition-all text-[10px] font-bold uppercase tracking-wider">
                        <span class="mr-3 opacity-50">#</span>
                        <span x-show="open">Géneros</span>
                    </a>
                    <a href="{{ route('clasificaciones.index') }}" class="flex items-center px-4 py-3 rounded-xl {{ request()->is('admin/clasificaciones*') ? 'text-red-500 bg-white/5' : 'text-gray-400' }} hover:text-red-500 hover:bg-white/5 transition-all text-[10px] font-bold uppercase tracking-wider">
                        <span class="mr-3 opacity-50">#</span>
                        <span x-show="open">Clasificaciones</span>
                    </a>
                    <a href="{{ route('paises.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-400 hover:text-red-500 hover:bg-white/5 transition-all text-[10px] font-bold uppercase tracking-wider">
                        <span class="mr-3 opacity-50">#</span>
                        <span x-show="open">Países</span>
                    </a>
                </div>
            </div>

            <div>
                <p x-show="open" class="px-4 mb-4 text-[10px] font-black text-gray-600 uppercase tracking-[0.3em]">Comunidad</p>
                <div class="space-y-1">
                    <a href="{{ route('criticas.index') }}" class="flex items-center px-4 py-3 rounded-xl {{ request()->is('admin/criticas*') ? 'bg-red-600/10 text-red-500' : 'text-gray-400' }} hover:bg-white/5 hover:text-white transition-all">
                        <span class="text-lg">⭐</span>
                        <span x-show="open" class="ml-4 text-[11px] font-black uppercase tracking-widest">Moderación</span>
                    </a>
                    <a href="{{ route('usuarios.index') }}" class="flex items-center px-4 py-3 rounded-xl {{ request()->is('admin/usuarios*') ? 'bg-red-600/10 text-red-500' : 'text-gray-400' }} hover:bg-white/5 hover:text-white transition-all">
                        <span class="text-lg">👥</span>
                        <span x-show="open" class="ml-4 text-[11px] font-black uppercase tracking-widest">Usuarios</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="px-4 mt-auto pt-6 border-t border-white/5">
            <div class="flex items-center px-4 py-3 bg-red-950/10 rounded-2xl border border-red-900/20 mb-2">
                <div class="shrink-0 w-8 h-8 rounded-full bg-red-600 flex items-center justify-center text-white font-black text-xs shadow-[0_0_10px_rgba(220,38,38,0.4)]">
                    {{ substr(Auth::user()->nombres, 0, 1) }}
                </div>
                <div x-show="open" class="ml-3 overflow-hidden">
                    <p class="text-[10px] font-black text-white truncate uppercase tracking-tighter">{{ Auth::user()->nombres }}</p>
                    <p class="text-[8px] font-bold text-red-500 uppercase tracking-widest">Administrator</p>
                </div>
            </div>

            <a href="{{ route('profileAdmin.edit') }}" 
               class="group flex items-center px-4 py-2 rounded-xl transition-all duration-300 {{ request()->routeIs('profileAdmin.edit') ? 'text-red-500 bg-white/5 border border-white/5' : 'text-gray-500 hover:text-white hover:bg-white/5' }}">
                <span class="text-lg group-hover:rotate-45 transition-transform duration-500">⚙️</span>
                <span x-show="open" class="ml-4 text-[10px] font-black uppercase tracking-[0.2em]">Configurar Perfil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="group flex items-center w-full px-4 py-2 text-gray-600 hover:text-red-600 transition-colors">
                    <span class="text-lg group-hover:scale-110 transition-transform">🚪</span>
                    <span x-show="open" class="ml-4 text-[10px] font-black uppercase tracking-[0.2em]">Finalizar Sesión</span>
                </button>
            </form>
        </div>
    </div>
</nav>

