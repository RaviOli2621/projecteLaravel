<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Services\PasswordService;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuaris'; // Asegúrate de que la tabla es 'usuaris'

    protected $primaryKey = 'Usuari'; // Ajusta si es diferente
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['Correu', 'Usuari', 'Contrasenya', 'Foto', 'tokenRec', 'Admin', 'google_id', 'github_id']; // Los campos correctos de la tabla
    public $timestamps = true; // Si usas timestamps en la tabla

    // Obtener todos los usuarios
    public static function updateUser($username, $data)
    {
        $updateData = [];
        
        // Si viene el nombre de usuario y es diferente al actual
        if (isset($data['username']) && $data['username'] != $username) {
            // Verificar si el nuevo nombre de usuario ya existe
            $existingUser = DB::table('usuaris')->where('Usuari', $data['username'])->first();
            if ($existingUser) {
                throw new \Exception('El nombre de usuario ya está en uso');
            }
            $updateData['Usuari'] = $data['username'];
        }
        
        // Si viene la contraseña
        if (isset($data['password']) && !empty($data['password'])) {
            $updateData['Contrasenya'] = bcrypt($data['password']);
        }
        
        // Si viene la foto
        if (isset($data['photo'])) {
            $updateData['Foto'] = $data['photo'];
        }
        
        // Solo actualizar si hay datos para actualizar
        if (!empty($updateData)) {
            try {
                $updated = DB::table('usuaris')
                    ->where('Usuari', $username)
                    ->update($updateData);
                return $updated;
            } catch (\Exception $e) {
                throw new \Exception('Error al actualizar la base de datos: ' . $e->getMessage());
            }
        }
        
        return false;
    }

    public static function getAllUsers()
    {
        return self::all();
    }

    // Obtener un usuario por ID
    public static function getUserById($id)
    {
        return self::find($id);
    }

    // Buscar un usuario por nombre (o nombre de usuario)
    public static function testName($name)
    {
        return self::where("Usuari", "like", '%' . $name . '%')->get();
    }

    // Crear un nuevo usuario
    public static function createUser($data)
    {
        return self::create([
            'Correu' => $data['email'], // Usamos 'Correu' para el correo
            'Usuari' => $data['name'],  // Usamos 'Usuari' para el nombre de usuario
            'Contrasenya' => bcrypt($data['password']), // Usamos 'Contrasenya' para la contraseña cifrada
        ]);
    }

    // Editar características del usuario (ej. cambiar nombre)
    public static function updateUserName($id, $newName)
    {
        $user = self::find($id);
        if ($user) {
            $user->Usuari = $newName; // Usamos 'Usuari' para el nombre de usuario
            $user->save();
            return $user;
        }
        return null;
    }

    // Editar la foto del usuario
    public static function updateFoto($id, $newFoto)
    {
        $user = self::find($id);
        if ($user) {
            $user->Foto = $newFoto; // Usamos 'Foto' para actualizar la foto
            $user->save();
            return $user;
        }
        return null;
    }

    // Editar la contraseña del usuario
    public static function updatePassword($id, $newPassword)
    {
        $user = self::find($id);
        if ($user) {
            $hashedPassword = PasswordService::encrypt($newPassword);
            $user->Contrasenya = $hashedPassword; // Usamos 'Contrasenya' para actualizar la contraseña
            $user->save();
            return $user;
        }
        return null;
    }

    // Eliminar un usuario por ID
    public static function deleteUser($id)
    {
        return self::destroy($id);
    }

    // Método para obtener el nombre de usuario para la autenticación
    public function getAuthIdentifierName()
    {
        return $this->primaryKey; // Ahora devolverá 'Usuari'
    }

    // Método para obtener la contraseña del usuario
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }
    
    public function getAuthPassword()
    {
        return $this->Contrasenya;
    }
    
    /**
     * Get the remember token for the user.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        // Return null since we don't have this column
        return null;
    }
    
    /**
     * Set the remember token for the user.
     *
     * @param string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // Do nothing since we don't have remember_token column
    }
    
    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token'; // Keep default name but the methods above will handle missing column
    }
}

