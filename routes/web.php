<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::view("/",'home')->name("home"); 
//Ruta articulos
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

// Add this route to your web routes file
?>