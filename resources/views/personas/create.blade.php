<div class="bg-gray-900 p-8 rounded-3xl mb-8 border border-gray-800 shadow-2xl">
    <h3 class="text-gray-400 font-bold mb-4 uppercase tracking-widest text-xs">Añadir Talento/Staff</h3>
    <form id="formCrear" onsubmit="guardarData(event)" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="text-[10px] uppercase tracking-widest text-gray-500 mb-1 block">Nombre Completo</label>
            <input type="text" id="nombre_completo" placeholder="Ej: Christopher Nolan" required class="w-full bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
        </div>
        <div class="md:col-span-2">
            <label class="text-[10px] uppercase tracking-widest text-gray-500 mb-1 block">URL de la Fotografía</label>
            <input type="url" id="foto_url" placeholder="https://ejemplo.com/foto.jpg" required class="w-full bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
        </div>
        <div class="md:col-span-1">
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-2 rounded-lg transition-all uppercase tracking-widest text-sm shadow-[0_0_15px_rgba(220,38,38,0.3)]">Guardar</button>
        </div>
    </form>
</div>