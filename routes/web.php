<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// dd(Blade::getCustomDirectives());

Route::view("/",'home')->name("home"); 
//Ruta articulos
Route::resource('usuaris', UserController::class);
Route::get('user/admin', [UserController::class, 'userAdminis'])->name('user.articles')->middleware('auth');

Route::resource('articles', ArticleController::class);
Route::get('user/articles', [ArticleController::class, 'userArticles'])->name('user.articles')->middleware('auth');

// Ruta para mostrar el formulario de login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
// Ruta para procesar el login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Ruta para cerrar sesión
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register'); // Asegúrate de tener una vista 'auth.register'
})->name('register');

// Ruta para manejar el registro
Route::post('/register', [AuthController::class, 'register']);

Route::get('/dashboard', function () {
    return "Bienvenido al dashboard";
})->middleware('auth'); // Ruta protegida por autenticación

// Ruta para mostrar el formulario de restablecimiento de contraseña
Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'showForgotForm'])
    ->name('password.forgot');
Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])
    ->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\PasswordResetController::class, 'showResetForm'])
    ->name('password.reset.form');
Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'resetPassword'])
    ->name('password.reset');

// Ruta para manejar la autenticación con Google y GitHub
Route::get('auth/{provider}', [AuthController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

?>