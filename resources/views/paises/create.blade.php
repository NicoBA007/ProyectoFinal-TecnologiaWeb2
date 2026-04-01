<div class="bg-gray-900 p-8 rounded-3xl mb-8 border border-gray-800 shadow-2xl">
    <h3 class="text-gray-400 font-bold mb-4 uppercase tracking-widest text-xs">Registrar País</h3>
    <form id="formCrear" onsubmit="guardarData(event)" class="flex gap-4 items-center">
        <input type="text" id="nombre" placeholder="Ej: Estados Unidos, Japón..." required class="flex-1 bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-black px-6 py-2 rounded-lg transition-all uppercase tracking-widest text-sm shadow-[0_0_15px_rgba(220,38,38,0.3)]">Guardar</button>
    </form>
</div>