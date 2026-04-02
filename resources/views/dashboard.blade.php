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
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-red-600 to-transparent">
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
              
            </div>
          </div>

          <div
            class="bg-gray-800/50 border border-gray-700 p-6 rounded-2xl hover:border-red-500/50 transition-all group">
            <div class="text-3xl mb-4">🏷️</div>
            <h4 class="text-white font-bold mb-4 uppercase text-sm tracking-widest">Catálogos Base</h4>
            <div class="flex flex-col gap-2">
              <a href="{{ route('generos.index') }}"
                class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-black py-2 rounded-lg transition-all shadow-lg shadow-red-900/20">
                GESTIONAR GÉNEROS
              </a>
              <a href="{{ route('clasificaciones.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black py-2 rounded-lg transition-all shadow-lg shadow-blue-900/20">
                GESTIONAR CLASIFICACIONES
              </a>
              <a href="{{ route('paises.index') }}"
                class="bg-green-600 hover:bg-green-700 text-white text-[10px] font-black py-2 rounded-lg transition-all shadow-lg shadow-green-900/20">
                GESTIONAR PAÍSES
              </a>
            </div>
          </div>

          <div
            class="bg-gray-800/50 border border-gray-700 p-6 rounded-2xl hover:border-red-500/50 transition-all group">
            <div class="text-3xl mb-4">🎭</div>
            <h4 class="text-white font-bold mb-4 uppercase text-sm tracking-widest">Talento & Staff</h4>
            <div class="flex flex-col gap-2">
              <a href="{{ route('personas.index') }}"
                class="bg-gray-700 hover:bg-gray-600 text-white text-[10px] font-black py-2 rounded-lg transition-all shadow-lg uppercase">
                VER ELENCO COMPLETO
              </a>
              {{-- Este botón ahora también lleva al index porque ahí tenemos nuestro formulario AJAX --}}
              <a href="{{ route('personas.index') }}"
                class="bg-red-600 hover:bg-red-700 text-white text-[10px] font-black py-2 rounded-lg transition-all shadow-lg shadow-red-900/20 uppercase">
                AÑADIR NUEVO TALENTO
              </a>
            </div>
          </div>
          <div
            class="bg-gray-800/50 border border-gray-700 p-6 rounded-2xl hover:border-yellow-500/50 transition-all group">
            <div class="text-3xl mb-4">⭐</div>
            <h4 class="text-white font-bold mb-4 uppercase text-sm tracking-widest">Reseñas y Críticas</h4>
            <div class="flex flex-col gap-2">
              <a href="{{ route('criticas.index') }}"
                class="bg-yellow-600 hover:bg-yellow-700 text-white text-[10px] font-black py-2 rounded-lg transition-all shadow-lg shadow-yellow-900/20 uppercase">
                MODERAR COMENTARIOS
              </a>
            </div>
          </div>
          <div
            class="bg-gray-800/50 border border-gray-700 p-6 rounded-2xl hover:border-purple-500/50 transition-all group">
            <div class="text-3xl mb-4">🎬</div>
            <h4 class="text-white font-bold mb-4 uppercase text-sm tracking-widest">Películas</h4>
            <div class="flex flex-col gap-2">
              <a href="{{ route('peliculas.index') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white text-[10px] font-black py-2 rounded-lg transition-all shadow-lg shadow-purple-900/20 uppercase">
                GESTIONAR CATÁLOGO
              </a>
            </div>
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