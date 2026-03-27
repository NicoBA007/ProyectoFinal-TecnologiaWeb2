<?php

namespace App\Http\Controllers;

use App\Models\Persona; // Importamos el modelo que creamos al principio
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Muestra el listado de actores y staff.
     */
    public function index()
    {
        // Traemos a todos ordenados por el más reciente
        $personas = Persona::orderBy('id_persona', 'desc')->get();
        return view('personas.index', compact('personas'));
    }

    /**
     * Muestra el formulario para crear un nuevo talento.
     */
    public function create()
    {
        return view('personas.create');
    }

    /**
     * Guarda el nuevo registro en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos según tu script SQL
        $request->validate([
            'nombre_completo' => 'required|string|max:150',
            'nacionalidad' => 'nullable|string|max:50',
            'foto_url' => 'required|url',
            'activo' => 'required|boolean'
        ]);

        // 2. Creamos el registro
        Persona::create([
            'nombre_completo' => $request->nombre_completo,
            'nacionalidad' => $request->nacionalidad,
            'foto_url' => $request->foto_url,
            'activo' => $request->activo,
        ]);

        return redirect()->route('personas.index')
            ->with('success', 'Talento registrado correctamente en el elenco.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $persona = Persona::findOrFail($id);
        return view('personas.edit', compact('persona'));
    }

    /**
     * Actualiza los datos en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);

        // Validamos (igual que en store)
        $request->validate([
            'nombre_completo' => 'required|string|max:150',
            'nacionalidad' => 'nullable|string|max:50',
            'foto_url' => 'required|url',
            'activo' => 'required|boolean'
        ]);

        // Actualizamos los campos
        $persona->update($request->all());

        return redirect()->route('personas.index')
            ->with('success', 'Los datos de ' . $persona->nombre_completo . ' han sido actualizados.');
    }

    /**
     * Cambia el estado de la persona (Borrado lógico).
     */
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);

        // Alternamos el estado: si estaba activo (1), pasa a inactivo (0) y viceversa
        $persona->activo = !$persona->activo;
        $persona->save();

        $mensaje = $persona->activo ? 'Talento reactivado.' : 'Talento desactivado del elenco.';

        return redirect()->route('personas.index')->with('success', $mensaje);
    }
}