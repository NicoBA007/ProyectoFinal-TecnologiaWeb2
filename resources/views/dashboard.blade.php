<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight tracking-tight">
            Panel de <span class="text-red-600">Control</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-gray-800 overflow-hidden shadow-2xl sm:rounded-2xl p-8 text-center">
                <span class="text-6xl mb-4 block">🍿</span>
                <h3 class="text-2xl font-bold text-white mb-2">¡Bienvenido al sistema, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-400 mb-8">Desde aquí puedes administrar todo el contenido de PrimeCinemas.</p>

                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">

                    <a href="{{ route('usuarios.index') }}"
                        class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-white font-bold py-3 px-6 rounded-xl transition-all transform hover:-translate-y-1">
                        👥 Ver Usuarios
                    </a>

                    <a href="{{ route('usuarios.create') }}"
                        class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-black py-3 px-6 rounded-xl transition-all shadow-[0_0_20px_rgba(220,38,38,0.4)] hover:shadow-[0_0_30px_rgba(220,38,38,0.6)] transform hover:-translate-y-1">
                        ➕ Nuevo Usuario
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>