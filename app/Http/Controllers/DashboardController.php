namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // tremos usuarios de 10 en 10 para no saturar el sistema
        $usuarios = User::orderBy('id_usuario', 'desc')->paginate(10); [cite: 346]

        // Retornamos la vista con los datos [cite: 347]
        return view('dashboard', compact('usuarios'));
    }

    // para eliminar un usuario [cite: 348]
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('dashboard')->with('success', 'Usuario eliminado correctamente');
    }
}