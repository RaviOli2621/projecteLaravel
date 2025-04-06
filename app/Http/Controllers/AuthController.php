<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // Mostrar el formulario de login (opcional si usas una API)
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar el login
    public function login(Request $request)
    {
        // Validación de los datos
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:1',
        ]);
    
        // Buscar al usuario por correo electrónico (Asegúrate de que tu tabla es "usuaris" y los campos coinciden)
        $user = User::where('Correu', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->Contrasenya)) {
            Auth::login($user);
            $request->session()->regenerate();
            $request->session()->save();

            return redirect()->route('test'); 
        }
    
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ]);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        // Cerrar la sesión del usuario
        Auth::logout();
        // Invalidar la sesión actual
        $request->session()->invalidate();
        // Regenerar el token CSRF
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout exitoso'], 200);
    }

    // Función para crear un nuevo usuario
    public function register(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'email' => 'required|email|unique:usuaris,Correu', // Validar correo y asegurar que es único
            'name' => 'required|string|min:3', // Validar el nombre de usuario
            'password' => 'required|string|min:6|confirmed', // Validar la contraseña y su confirmación
        ]);

        // Crear el nuevo usuario
        DB::table('usuaris')->insert([
            'Correu' => $request->email,
            'Usuari' => $request->name,
            'Contrasenya' => bcrypt($request->password),
            'Admin' => False,
            'google_id' => "",
            'github_id' => ""
        ]);
        
        // Aquí puedes devolver una respuesta JSON o redirigir al usuario
        return redirect()->route('login')->with('success', 'Usuario registrado con éxito. Puedes iniciar sesión ahora.');
    }
}
