<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

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
    
        // Verificar reCAPTCHA si se envió el token
        if ($request->has('g-recaptcha-response')) {
            $recaptcha = $request->input('g-recaptcha-response');
            $secretKey = env('RECAPTCHA_SECRET_KEY');
            
            // Validación mediante la API de Google con opción para ignorar SSL en desarrollo
            $response = Http::withOptions([
                'verify' => false, // Ignorar verificación SSL en desarrollo - NO USAR EN PRODUCCIÓN
            ])->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $recaptcha,
                'remoteip' => $request->ip()
            ]);
            
            $result = $response->json();
            
            // Si la validación falla (no exitosa o score bajo)
            if (!isset($result['success']) || !$result['success'] || (isset($result['score']) && $result['score'] < 0.5)) {
                return back()->withErrors([
                    'recaptcha' => 'La verificación de seguridad ha fallado. Por favor, inténtalo de nuevo.'
                ])->withInput($request->except('password'));
            }
        }
    
        // Buscar al usuario por correo electrónico (usando la columna Correu)
        $user = User::where('Correu', $credentials['email'])->first();
        
        if ($user && Hash::check($credentials['password'], $user->Contrasenya)) {
            // Si marcó "recordar", guardar email en cookie por 30 días
            if ($request->has('remember')) {
                Cookie::queue('remembered_user_email', $credentials['email'], 60*24*30);
            }else{
                Cookie::queue(Cookie::forget('remembered_user_email'));
            }

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
            
            // Generar JWT y almacenarlo en la sesión
            $token = JWTAuth::fromUser($user);
            session(['jwt_token' => $token]);

            return redirect()->intended(route('home'));
        }
    
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ])->withInput($request->except('password'));
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        // Eliminar el JWT de la sesión
        $request->session()->forget('jwt_token');
        
        // Proceso normal de logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
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

    //Oauth 
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            $socialId = $socialUser->getId();
            $email = $socialUser->getEmail();
            $name = $socialUser->getName() ?? $socialUser->getNickname();
            $providerField = $provider . '_id'; // google_id o github_id

            // Buscar por ID del proveedor
            $user = User::where($providerField, $socialId)->first();

            if (!$user) {
                // Buscar por correo electrónico
                $user = User::where('Correu', $email)->first();

                if ($user) {
                    // Asociamos el login social a un usuario existente utilizando DB::table
                    DB::table('usuaris')
                        ->where('Usuari', $user->Usuari)
                        ->update([
                            $providerField => $socialId,
                            // No se incluye updated_at aquí
                        ]);
                    
                    // Refrescar la instancia del usuario con los datos actualizados
                    $user = User::where('Usuari', $user->Usuari)->first();
                } else {
                    // Crear nuevo usuario siguiendo el patrón de la función register
                    $uniqueUsername = $name . '_' . date('Ymd') . substr(uniqid(), -4);
                    
                    // Usar DB::table para ser consistente con la función register
                    DB::table('usuaris')->insert([
                        'Correu' => $email,
                        'Usuari' => $uniqueUsername,
                        'Contrasenya' => bcrypt(str()->random(0)), 
                        $providerField => $socialId,
                        'Foto' => null,
                        'Admin' => False,
                        'github_id' => $provider === 'github' ? $socialId : "",
                        'google_id' => $provider === 'google' ? $socialId : "",
                    ]);
                    
                    // Obtener el usuario recién creado
                    $user = User::where('Correu', $email)->first();
                    
                    // Flash message para nuevo registro, similar a register()
                    session()->flash('success', 'Cuenta creada exitosamente con ' . ucfirst($provider));
                }
            }

            // Establecer las mismas variables de sesión que en login()
            session([
                'usuari' => $user->Usuari,
                'admin' => $user->Admin,
                'email' => $user->Correu,
                'name' => $user->Usuari,
            ]);
            
            // Configurar cookie para recordar al usuario (30 días)
            Cookie::queue('remembered_user_email', $user->Correu, 60*24*30);
            
            // Realizar login sin "remember me", igual que en login()
            Auth::login($user, false);
            
            // Migrar sesión preservando datos
            $request->session()->migrate(true);
            
            // Guardar sesión explícitamente
            session()->save();
            
            $token = JWTAuth::fromUser($user);
            session(['jwt_token' => $token]);

            // Redireccionar a la misma ruta que login()
            return redirect()->intended(route('home'));
            
        } catch (\Exception $e) {
            // Manejo de errores consistente con las otras funciones
            return redirect()->route('login')
                ->withErrors(['oauth' => 'No se pudo autenticar con ' . ucfirst($provider) . '. Por favor intenta otra opción.']);
        }
    }
}
