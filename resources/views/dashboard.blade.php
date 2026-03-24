<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gray-900 border border-gray-800 overflow-hidden shadow-lg sm:rounded-2xl mb-8">
                <div class="p-8 text-gray-300 text-lg flex items-center gap-4">
                    <span class="text-4xl">🍿</span>
                    <div>
                        ¡Hola, <strong class="text-white">{{ Auth::user()->name }}</strong>! <br>
                        <span class="text-sm text-gray-400">Has iniciado sesión correctamente en PrimeCinemas.</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-12">
                <a href="/" class="flex items-center gap-3 border-2 border-red-600 text-red-500 hover:bg-red-600 hover:text-white px-8 py-4 rounded-full font-bold text-lg transition-all shadow-[0_0_15px_rgba(220,38,38,0.2)] hover:shadow-[0_0_30px_rgba(220,38,38,0.6)] transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Regresar a la Cartelera (Inicio)
                </a>
            </div>

        </div>
    </div>
</x-app-layout>