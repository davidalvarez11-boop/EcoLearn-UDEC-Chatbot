<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Web\AuthViewController;
use App\Http\Controllers\Web\CourseController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EvaluationController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\TaskViewController;
use App\Http\Controllers\Web\ProgressController;

/*
|--------------------------------------------------------------------------
| RUTA INICIAL
|--------------------------------------------------------------------------
*/

Route::view('/', 'inicio')->name('inicio');
Route::view('/chatbot', 'chatbot-demo')->name('chatbot');

/*
|--------------------------------------------------------------------------
| CONTACTO
|--------------------------------------------------------------------------
*/

Route::get('/contacto', [ContactoController::class, 'index'])
    ->name('contacto.index');

Route::post('/contacto', [ContactoController::class, 'store'])
    ->name('contacto.store');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

// LOGIN
Route::get('/login', [AuthViewController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthViewController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.store');

// REGISTER
Route::get('/register', [AuthViewController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthViewController::class, 'register'])
    ->name('register.store');

// LOGOUT
Route::post('/logout', [AuthViewController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD PROTEGIDO
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard.dashboard');

    /*
    |--------------------------------------------------------------------------
    | TASKS (CRUD COMPLETO)
    |--------------------------------------------------------------------------
    */

    Route::get('/tasks', [TaskViewController::class, 'index'])
        ->name('tasks.index');

    Route::get('/tasks/create', [TaskViewController::class, 'create'])
        ->name('tasks.create');

    Route::post('/tasks', [TaskViewController::class, 'store'])
        ->name('tasks.store');

    Route::get('/tasks/{id}/edit', [TaskViewController::class, 'edit'])
        ->name('tasks.edit');

    Route::put('/tasks/{id}', [TaskViewController::class, 'update'])
        ->name('tasks.update');

    Route::delete('/tasks/{id}', [TaskViewController::class, 'destroy'])
        ->name('tasks.destroy');

    /*
    |--------------------------------------------------------------------------
    | COURSES (CATÁLOGO EDUCATIVO)
    |--------------------------------------------------------------------------
    */

    Route::get('/courses', [CourseController::class, 'index'])
        ->name('courses.index');

    Route::get('/courses/{id}', [CourseController::class, 'show'])
        ->name('courses.show');

    Route::post('/courses/{id}/evaluate', [EvaluationController::class, 'store'])
        ->name('courses.evaluate');

    Route::get('/courses/{courseId}/resultado/{attemptId}', [EvaluationController::class, 'result'])
        ->name('courses.result');

    // PERFIL
    Route::get('/perfil', [ProfileController::class, 'index'])
        ->name('profile.index');
    Route::put('/perfil', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::put('/perfil/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');

    // PROGRESO
    Route::get('/progreso', [ProgressController::class, 'index'])
        ->name('progress.index');

});

/*
|--------------------------------------------------------------------------
| PANEL DE ADMINISTRACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/courses', [AdminCourseController::class, 'index'])
        ->name('courses.index');

    Route::get('/courses/create', [AdminCourseController::class, 'create'])
        ->name('courses.create');

    Route::post('/courses', [AdminCourseController::class, 'store'])
        ->name('courses.store');

    Route::get('/courses/{id}/edit', [AdminCourseController::class, 'edit'])
        ->name('courses.edit');

    Route::put('/courses/{id}', [AdminCourseController::class, 'update'])
        ->name('courses.update');

    Route::delete('/courses/{id}', [AdminCourseController::class, 'destroy'])
        ->name('courses.destroy');

    // ESTUDIANTES
    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('users.index');

    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])
        ->name('users.destroy');

});

/*
|--------------------------------------------------------------------------
| RUTA DE PRUEBA
|--------------------------------------------------------------------------
*/

Route::get('/ping', function () {
    return "OK";
});