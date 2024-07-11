<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LogRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Аутентификация пользователя
    public function auth(AuthRequest $request)
    {
        // Поиск пользователя в бд
        $user = User::where(['email' => $request->email])->first();

        // Создание одноразового кода
        $password = Hash::make($this->generatePassword(4));

        if (!$user) {
            // Создать пользоавтеля, если его нет в бд
            $user = User::create([
                'email' => $request->email,
                'password' => $password
            ]);
        } else {
            // Обновить код пользователя
            $user->update(['password' => $password]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Authorized successfully',
        ], 200);
    }

    public function login(LogRequest $request)
    {
        // Поиск пользователя в бд
        $user = User::where(['email' => $request->email])->first();

        // Проверка пароля
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect email or password',
            ], 403);
        }

        // Создание токена
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successfully',
            'token' => $token,
        ], 200);
    }

    // public function mailSend(Request $request)
    // {
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Mail sent successfully',
    //     ], 200);
    // }

    // Получить всех пользователей в бд
    public function index()
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'data' => $users
        ], 200);;
    }

    // Генерирование кода длинной $length символов
    private function generatePassword($length)
    {
        $numbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $numbers[array_rand($numbers)];
        }

        return $password;
    }
}
