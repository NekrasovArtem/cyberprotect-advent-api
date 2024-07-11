<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Проверка работоспособности API
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working'
    ], 200);
});

// Аутентификация пользователя по почте
Route::post('/auth', [UserController::class, 'auth']);

// Авторизация пользователя с кодом
Route::post('/login', [UserController::class, 'login']);

// Получить список всех пользователей
Route::get('/users', [UserController::class, 'index']);