<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Muestra la lista de usuarios.
     */
    public function index()
    {
        $usuarios = User::orderBy('id_usuario', 'desc')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Recibe los datos, los valida y guarda el nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:admin,cliente'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra los detalles de un solo usuario (Opcional, usualmente no se usa si ya tienes la tabla).
     */
    public function show(string $id)
    {
        // Puedes dejarlo vacío o redirigir al index si alguien intenta entrar aquí
        return redirect()->route('usuarios.index');
    }

    /**
     * Muestra el formulario con los datos cargados del usuario a editar.
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id); // Busca al usuario, si no existe da error 404
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Recibe los cambios del formulario de edición y actualiza la base de datos.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        // Validaciones (Nota: el 'unique' ignora el email actual del usuario para que no dé error)
        $reglas = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id . ',id_usuario',
            'rol' => 'required|in:admin,cliente'
        ];

        // Si el usuario escribió una contraseña nueva, la validamos
        if ($request->filled('password')) {
            $reglas['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($reglas);

        // Actualizamos los datos
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;

        // Si hay una contraseña nueva, la encriptamos y la cambiamos
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save(); // Guarda los cambios en MySQL

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina a un usuario de la base de datos.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete(); // Lo borra de la tabla

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado definitivamente.');
    }
}