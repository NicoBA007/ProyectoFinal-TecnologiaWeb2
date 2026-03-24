namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Traemos todos los usuarios de la tabla 'usuarios'
        $usuarios = User::all();

        // Se los enviamos a la vista dashboard.blade.php
        return view('dashboard', compact('usuarios'));
    }
}
