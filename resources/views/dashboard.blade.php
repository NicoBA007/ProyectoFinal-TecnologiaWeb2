<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight tracking-tight uppercase">
            Panel de <span class="text-red-600">Control</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-gray-900 border border-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl p-12 text-center relative">
                <div
                    class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-red-600 to-transparent">
                </div>

                <span class="text-7xl mb-6 block animate-bounce">🍿</span>

                <h3 class="text-3xl font-black text-white mb-2 uppercase tracking-tighter">
                    ¡Hola de nuevo, <span class="text-red-500">{{ Auth::user()->nombres }}</span>!
                </h3>

                <p class="text-gray-500 mb-10 uppercase tracking-[0.2em] text-xs font-bold">
                    Bienvenido a la central de administración de PrimeCinemas
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl mx-auto">

                    <div
                        class="bg-gray-800/50 border border-gray-700 p-6 rounded-2xl hover:border-red-500/50 transition-all group">
                        <div class="text-3xl mb-4">👥</div>
                        <h4 class="text-white font-bold mb-4 uppercase text-sm tracking-widest">Usuarios</h4>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('usuarios.index') }}"
                                class="bg-gray-700 hover:bg-gray-600 text-white text-[10px] font-black py-2 rounded-lg transition-all">VER
                                LISTADO</a>
                            <a href="{{ route('usuarios.create') }}"
                                class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-black py-2 rounded-lg transition-all shadow-lg shadow-red-900/20">NUEVO
                                REGISTRO</a>
                        </div>
                    </div>

                    <div
                        class="bg-gray-800/50 border border-gray-700 p-6 rounded-2xl hover:border-red-500/50 transition-all group">
                        <div class="text-3xl mb-4">🎭</div>
                        <h4 class="text-white font-bold mb-4 uppercase text-sm tracking-widest">Talento & Staff</h4>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('personas.index') }}"
                                class="bg-gray-700 hover:bg-gray-600 text-white text-[10px] font-black py-2 rounded-lg transition-all">VER
                                ELENCO</a>
                            <a href="{{ route('personas.create') }}"
                                class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-black py-2 rounded-lg transition-all shadow-lg shadow-red-900/20">AÑADIR
                                TALENTO</a>
                        </div>
                    </div>

                    <div
                        class="bg-gray-800/30 border border-gray-800 p-6 rounded-2xl opacity-60 cursor-not-allowed italic">
                        <div class="text-3xl mb-4 grayscale">🎬</div>
                        <h4 class="text-gray-500 font-bold mb-4 uppercase text-sm tracking-widest">Películas</h4>
                        <p class="text-[10px] text-gray-600 font-black uppercase tracking-tighter">Módulo en Desarrollo
                        </p>
                    </div>

                </div>

                <div class="mt-12 pt-8 border-t border-gray-800">
                    <p class="text-gray-600 text-[10px] font-mono uppercase">
                        PrimeCinemas Engine v1.0 | Dashboard Administrativo
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>