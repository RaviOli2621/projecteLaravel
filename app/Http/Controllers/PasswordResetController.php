<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Muestra el formulario para solicitar el restablecimiento
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Procesa la solicitud y envía el correo
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuaris,Correu',
        ], [
            'email.exists' => 'No encontramos ningún usuario con ese correo electrónico.'
        ]);

        // Generar token aleatorio con timestamp incorporado
        // Formato: timestamp_randomString
        $timestamp = Carbon::now()->timestamp;
        $randomStr = Str::random(40);
        $token = $timestamp . '_' . $randomStr;
        
        $email = $request->email;

        // Guardar token en la base de datos (sin updated_at)
        DB::table('usuaris')
            ->where('Correu', $email)
            ->update([
                'tokenRec' => $token
            ]);

        // Enviar correo con enlace de restablecimiento
        $resetUrl = route('password.reset.form', ['token' => $token, 'email' => $email]);
        
        Mail::send('emails.reset-password', ['resetUrl' => $resetUrl], function($message) use ($email) {
            $message->to($email)->subject('Restablecer contraseña');
        });

        return back()->with('status', 'Te hemos enviado un correo con el enlace para restablecer tu contraseña.');
    }

    // Muestra el formulario para restablecer la contraseña
    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        
        // Verificar que el token es válido
        $user = DB::table('usuaris')
            ->where('Correu', $email)
            ->where('tokenRec', $token)
            ->first();
            
        if (!$user) {
            return redirect()->route('password.forgot')
                ->withErrors(['email' => 'El enlace no es válido o ha expirado.']);
        }
        
        // Verificar si el token ha expirado (24 horas)
        if (strpos($token, '_') !== false) {
            list($timestamp, $randomStr) = explode('_', $token);
            $tokenCreationTime = Carbon::createFromTimestamp($timestamp);
            $expirationTime = Carbon::now()->subHours(24);
            
            if ($tokenCreationTime->lessThan($expirationTime)) {
                // Limpiar el token expirado
                DB::table('usuaris')
                    ->where('Correu', $email)
                    ->update(['tokenRec' => null]);
                    
                return redirect()->route('password.forgot')
                    ->withErrors(['email' => 'El enlace ha expirado. Por favor, solicita un nuevo enlace de recuperación.']);
            }
        }
        
        return view('auth.reset-password', compact('token', 'email'));
    }

    // Procesa la solicitud de cambio de contraseña
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:usuaris,Correu',
            'password' => 'required|min:8|confirmed',
        ]);

        $token = $request->token;
        $email = $request->email;

        // Verificar que el token es válido
        $user = DB::table('usuaris')
            ->where('Correu', $email)
            ->where('tokenRec', $token)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'El enlace no es válido o ha expirado.']);
        }

        // Verificar si el token ha expirado (24 horas)
        if (strpos($token, '_') !== false) {
            list($timestamp, $randomStr) = explode('_', $token);
            $tokenCreationTime = Carbon::createFromTimestamp($timestamp);
            $expirationTime = Carbon::now()->subHours(24);
            
            if ($tokenCreationTime->lessThan($expirationTime)) {
                // Limpiar el token expirado
                DB::table('usuaris')
                    ->where('Correu', $email)
                    ->update(['tokenRec' => null]);
                    
                return redirect()->route('password.forgot')
                    ->withErrors(['email' => 'El enlace ha expirado. Por favor, solicita un nuevo enlace de recuperación.']);
            }
        }

        // Actualizar la contraseña
        DB::table('usuaris')
            ->where('Correu', $email)
            ->update([
                'Contrasenya' => Hash::make($request->password),
                'tokenRec' => null // Limpiar el token una vez usado
            ]);

        return redirect()->route('login')->with('success', 'Tu contraseña ha sido restablecida correctamente. Ya puedes iniciar sesión.');
    }
}
