<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Obtener todos los usuarios
    public function index()
    {
        return response()->json(User::all()); // No es necesario un método extra en el modelo
    }
    public function test(){
        dd(Auth::user(), session()->all());
    }
    // Obtener un usuario por ID
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Asegurar que la tabla sea 'users' y el campo 'email'
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Encriptar la contraseña
        ]);

        return response()->json($user, 201);
    }

    public function edit($name)
    {
        $user = User::where("Usuari", $name)->first();
        if ($user) {
            return view('user.edit', ['user' => $user]);
        }
        return response()->json(['message' => 'User not found'], 404);

    }

    // Actualizar un usuario
    public function update(Request $request, $name)
    {
        // Verificar si el usuario existe
        $user = User::where("Usuari", $name)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
        
        try {

            $messages = [
                'password.regex' => 'La contraseña debe contener al menos 8 caracteres, incluyendo una letra mayúscula, una minúscula, un número y un carácter especial (@$!%*?&)',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres',
                'password.same' => 'Las contraseñas no coinciden',
                'photo.image' => 'El archivo debe ser una imagen',
                'photo.mimes' => 'Solo se permiten imágenes JPG o JPEG',
                'photo.max' => 'La imagen no debe superar los 2MB',
            ];

            $data = $request->validate([
                'username' => 'sometimes|string|max:255',
                'currentPassword' => 'sometimes|nullable|string',
                'password' => 'sometimes|nullable|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/|same:password2|required_with:currentPassword',
                'password2' => 'sometimes|nullable|required_with:password',
                'photo' => 'sometimes|nullable|image|mimes:jpg,jpeg|max:2048',
            ],$messages);

            // Verificar contraseña actual si se está intentando cambiar la contraseña
            if (!empty($data['password']) && !empty($data['currentPassword'])) {
                if (!Hash::check($data['currentPassword'], $user->Contrasenya)) {
                    return redirect()->back()
                        ->withInput($request->except('currentPassword', 'password', 'password2'))
                        ->with('error', 'La contraseña actual es incorrecta');
                }
            }
            
            // Procesar imagen si se subió
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageData = file_get_contents($image->getRealPath());
                $base64Image = base64_encode($imageData);
                $data['photo'] = $base64Image;
            }
            
            // Verificar si hay datos para actualizar
            if (empty($data['username']) && (empty($data['password']) || $data['password'] === null) && !$request->hasFile('photo')) {
                return redirect()->back()->with('error', 'No se proporcionaron datos para actualizar');
            }
            
            // Guardar el nuevo nombre de usuario si existe
            $newUsername = isset($data['username']) ? $data['username'] : null;
            
            try {
                $updated = User::updateUser($name, $data);
                
                if ($updated) {
                    // Si se cambió el nombre de usuario
                    if ($newUsername && $newUsername != $name) {
                        // Obtener el usuario actualizado
                        $updatedUser = User::where('Usuari', $newUsername)->first();
                        
                        // Cerrar sesión actual
                        Auth::logout();
                        
                        // Iniciar sesión con el usuario actualizado
                        Auth::login($updatedUser);
                        
                        return redirect()->route('usuaris.edit', $newUsername)->with('success', 'Usuario actualizado correctamente');
                    }
                    return redirect()->back()->with('success', 'Usuario actualizado correctamente');
                } else {
                    return redirect()->back()->with('error', 'No se realizaron cambios o hubo un problema con la actualización');
                }
            } catch (\PDOException $e) {
                return redirect()->back()->with('error', 'Error de base de datos: ' . $e->getMessage())->withInput();
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error inesperado: ' . $e->getMessage())->withInput();
        }
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}
