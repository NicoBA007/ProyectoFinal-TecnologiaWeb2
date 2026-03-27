<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('id_usuario', 'desc')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        // 1. Validamos usando los NUEVOS campos de la base de datos
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100', // Nullable porque en SQL no le pusiste NOT NULL
            'email' => 'required|email|unique:usuario,email', // Apuntamos a la tabla 'usuario'
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:admin,cliente' 
        ]);

        // 2. Guardamos con la nueva estructura
        User::create([
            'nombres' => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'rol' => $request->rol,
            'activo' => true // Por defecto lo creamos activo
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function show(string $id)
    {
        return redirect()->route('usuarios.index');
    }

    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $reglas = [
            'nombres' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'email' => 'required|email|unique:usuario,email,' . $id . ',id_usuario',
            'rol' => 'required|in:admin,cliente'
        ];

        if ($request->filled('password')) {
            $reglas['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($reglas);

        // 3. Actualizamos los nuevos campos
        $usuario->nombres = $request->nombres;
        $usuario->apellido_paterno = $request->apellido_paterno;
        $usuario->apellido_materno = $request->apellido_materno;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        
        // En lugar de borrarlo físicamente (delete), lo desactivamos por seguridad (Soft Delete lógico)
        $usuario->activo = false;
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario desactivado correctamente.');
    }
}