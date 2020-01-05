<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Services\UserService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $user;

    public function __construct(UserService $user)
    {
        return $this->user = $user;
    }

    /** Регистрация пользователя в системе */
    public function register(UserStoreRequest $request) : JsonResponse
    {
        return $this->user->store($request);
    }

    /** Вход в систему */
    public function login(LoginRequest $request) : JsonResponse
    {
//        if (! $request->validated()) {
//            return false;
//        }

        $credentials = $request->only('email', 'password');

        /** attempt - проверка соответствия credential'a */
        if (! $token = $this->guard()->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'error' => __('auth_login_error')
            ]);
        } else {
            auth()->attempt($credentials, true);
            return response()->json([
                'status' => 'success'
            ], 200)->header('Authorization', $token);
        }
    }

    /** Выход из системы */
    public function logout() : JsonResponse
    {
        $this->guard()->logout();
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'msg' => __('auth_logout_success')
        ], 200);
    }

    /** Получаем авторизованного пользователя */
    public function user(Request $request) : JsonResponse
    {
        $user = User::with(['roles'])->find(auth()->user()->id);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ], 200);
    }

    /** Обновление JWT Token спустя истечённого времени
     *
     * Этот параметр JWT_TTL находится в .env (значения в минутах, default: 60)
     *
     */
    public function refresh() : JsonResponse
    {
        if ($token = $this->guard()->refresh()) {
            return response()->json([
                'status' => 'success'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'error' => 'auth_token_refresh_error'
        ]);
    }

    /** Получаем Guard авторизации */
    private function guard()
    {
        return auth()->guard();
    }
}