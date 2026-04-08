<footer class="bg-gray-950 border-t border-white/5 py-6 mt-auto">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            
            {{-- Identidad Minimalista --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-6 w-auto opacity-50 grayscale hover:grayscale-0 transition-all">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-600">
                    Admin <span class="text-red-900">Console</span>
                </span>
            </div>

            {{-- Info de Sistema / Links Formales --}}
            <div class="flex items-center gap-8">
                <div class="flex gap-6">
                    <a href="#" class="text-gray-600 hover:text-red-600 text-[10px] font-bold uppercase tracking-widest transition-colors">Soporte Técnico</a>
                    <a href="#" class="text-gray-600 hover:text-red-600 text-[10px] font-bold uppercase tracking-widest transition-colors">Documentación</a>
                </div>
                
                {{-- Indicador de Estado (Opcional, se ve muy Pro) --}}
                <div class="hidden sm:flex items-center gap-2 px-3 py-1 bg-white/5 rounded-full border border-white/5">
                    <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-[9px] font-black text-gray-500 uppercase tracking-tighter">Sistema Online</span>
                </div>
            </div>

            {{-- Copyright --}}
            <p class="text-gray-700 text-[10px] uppercase tracking-[0.1em] font-bold">
                &copy; {{ date('Y') }} <span class="text-gray-500">PrimeCinemas Cochabamba.</span>
            </p>
            
        </div>
    </div>
</footer>