<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    // Listar actores
    public function index()
    {
        $actores = Actor::all();
        return view('actores.index', compact('actores'));
    }

    // Formulario de creación
    public function create()
    {
        return view('actores.form');
    }

    // Guardar nuevo actor
    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'nacionalidad' => 'required|string|max:100',
        ]);

        Actor::create($request->all());

        return redirect()->route('actores.index');
    }

    // Formulario de edición
    public function edit($id)
    {
        $actor = Actor::findOrFail($id);
        return view('actores.form', compact('actor'));
    }

    // Actualizar datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'nacionalidad' => 'required|string|max:100',
        ]);

        $actor = Actor::findOrFail($id);
        $actor->update($request->all());

        return redirect()->route('actores.index');
    }

    // Eliminar actor
    public function destroy($id)
    {
        $actor = Actor::findOrFail($id);
        $actor->delete();

        return redirect()->route('actores.index');
    }
}
