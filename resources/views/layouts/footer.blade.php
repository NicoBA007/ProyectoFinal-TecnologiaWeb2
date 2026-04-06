<footer class="bg-gray-950 border-t border-gray-900 pt-16 pb-8 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center">

            <div class="mb-8">
                {{-- Ajusta la ruta a donde tengas tu logo (ej: public/logo.png) --}}
                <img src="{{ asset('images/logo.png') }}" alt="PrimeCinemas Logo" class="h-10 w-auto brightness-110">
            </div>

            <nav class="flex flex-wrap justify-center gap-8 mb-10">
                <a href="/"
                    class="text-gray-500 hover:text-red-600 text-xs font-bold uppercase tracking-widest transition-colors">Inicio</a>
                <a href="{{ route('cartelera.index') }}"
                    class="text-gray-500 hover:text-red-600 text-xs font-bold uppercase tracking-widest transition-colors">Cartelera</a>
                <a href="#"
                    class="text-gray-500 hover:text-red-600 text-xs font-bold uppercase tracking-widest transition-colors">Películas</a>
                <a href="#"
                    class="text-gray-500 hover:text-red-600 text-xs font-bold uppercase tracking-widest transition-colors">Mi
                    Perfil</a>
            </nav>

            <div class="flex gap-6 mb-10 text-gray-600">
                <a href="#" class="hover:text-white transition-all transform hover:scale-110">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                    </svg>
                </a>
                <a href="#" class="hover:text-white transition-all transform hover:scale-110">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.245 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.063 1.366-.333 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.063-2.633-.333-3.608-1.308-.975-.975-1.245-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.063-1.366.333-2.633 1.308-3.608.975-.975 2.242-1.245 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                    </svg>
                </a>
            </div>

            <p
                class="text-gray-700 text-[10px] uppercase tracking-[0.2em] font-medium border-t border-gray-900 pt-8 w-full text-center">
                &copy; {{ date('Y') }} PrimeCinemas. Todos los derechos reservados.
            </p>
        </div>
    </div>
</footer>
