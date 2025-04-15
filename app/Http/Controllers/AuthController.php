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
    
        // Buscar al usuario por correo electrónico (usando la columna Correu)
        $user = User::where('Correu', $credentials['email'])->first();
        
        if ($user && Hash::check($credentials['password'], $user->Contrasenya)) {
            // Guardar datos relevantes del usuario en la sesión
            session([
                'usuari' => $user->Usuari,  // Campo primario personalizado
                'admin' => $user->Admin,
                'email' => $user->Correu,
                'name' => $user->Usuari,    // Nombre de usuario como campo primario
            ]);
            
            // Realizar login sin usar "remember me"
            Auth::login($user, false);
            
            // Migrar sesión preservando datos
            $request->session()->migrate(true);
            
            // Guardar sesión explícitamente
            session()->save();
            
            return redirect()->intended(route('home'));
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

        return redirect()->intended(route('home'));
    }

    // Función para crear un nuevo usuario
    public function register(Request $request)
    {
        try {

            $messages = [
                'password.regex' => 'La contraseña debe contener al menos 8 caracteres, incluyendo una letra mayúscula, una minúscula, un número y un carácter especial (@$!%*?&)',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.same' => 'Las contraseñas no coinciden',
                'password.confirmed' => 'La confirmación de contraseña no coincide',
                'email.unique' => 'Este correo electrónico ya está registrado',
                'name.min' => 'El nombre de usuario debe tener al menos 3 caracteres',
            ];
            
            // Validar los datos de entrada
            $request->validate([
                'email' => 'required|email|unique:usuaris,Correu',
                'name' => 'required|string|min:3',
                'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ], $messages);

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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
}
