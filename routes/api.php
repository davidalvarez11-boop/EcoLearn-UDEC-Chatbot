<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\ChatbotController;

// Auth pública (con throttle)
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
Route::post('/login',    [AuthController::class, 'login'])->middleware('throttle:10,1');

// Chatbot endpoints públicos
Route::post('/chatbot/message', [ChatbotController::class, 'sendMessage'])->middleware('throttle:30,1');
Route::get('/chatbot/statement', [ChatbotController::class, 'getStatement']);

// Protegidas por token Sanctum
Route::middleware(['auth:sanctum','throttle:60,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get   ('/tasks',        [TaskController::class, 'index']);
    Route::post  ('/tasks',        [TaskController::class, 'store']);
    Route::get   ('/tasks/{task}', [TaskController::class, 'show']);
    Route::put   ('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});