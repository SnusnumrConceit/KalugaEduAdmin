<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Services\UserService;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $user;

    public function __construct(UserService $user)
    {
        return $this->user = $user;
    }

    public function login(LoginRequest $request) : JsonResponse
    {
        if (! $request->validated()) {
            return false;
        }

        $user = User::where([
            'email' => $request->email
        ])->first();

        $is_auth = auth()->attempt(['email' => $request->email, 'password' => $request->password]);

        if  (! $is_auth || ! Hash::check($request->password, $user->password)) {
            throw new ServiceException('Неверные данные', 500);
        }

        return $this->token($user);
    }

    protected function token($user)
    {
        $token = $user->createToken(Str::random(15))->plainTextToken;
        return response()->json([
            'status' => 'success',
//            'user' => $user,
            'token' => $token
        ], 200)->header('Authorization', $token);
    }

    /** метод отправки ссылки обнулирования пароля */
    public function sendPasswordResetLink(Request $request)
    {
        return $this->sendResetLinkEmail($request);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json([
            'message' => 'Password reset email sent.',
            'data' => $response
        ]);
    }
    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['message' => 'Email could not be sent to this email address.']);
    }

//
//    /** Регистрация пользователя в системе */
//    public function register(UserStoreRequest $request) : JsonResponse
//    {
//        return $this->user->store($request);
//    }
//
//    /** Вход в систему */
//    public function login(LoginRequest $request) : JsonResponse
//    {
////        if (! $request->validated()) {
////            return false;
////        }
//
//        $credentials = $request->only('email', 'password');
//
//        /** attempt - проверка соответствия credential'a */
//        if (! $token = $this->guard()->attempt($credentials)) {
//            return response()->json([
//                'status' => 'error',
//                'error' => __('auth_login_error')
//            ]);
//        } else {
//            auth()->attempt($credentials, true);
//            return response()->json([
//                'status' => 'success'
//            ], 200)->header('Authorization', $token);
//        }
//    }
//
    /** Выход из системы */
    public function logout() : JsonResponse
    {
//        $this->guard()->logout();
        auth()->user()->tokens->each->delete();
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'msg' => __('auth_logout_success')
        ], 200);
    }
//
    /** Получаем авторизованного пользователя */
    public function user(Request $request) : JsonResponse
    {
        $user = User::with(['roles'])->find(auth()->user()->id);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ], 200);
    }
//
//    /** Обновление JWT Token спустя истечённого времени
//     *
//     * Этот параметр JWT_TTL находится в .env (значения в минутах, default: 60)
//     *
//     */
//    public function refresh() : JsonResponse
//    {
//        if ($token = $this->guard()->refresh()) {
//            return response()->json([
//                'status' => 'success'
//            ], 200);
//        }
//
//        return response()->json([
//            'status' => 'error',
//            'error' => 'auth_token_refresh_error'
//        ]);
//    }
//
//    /** Получаем Guard авторизации */
//    private function guard()
//    {
//        return auth()->guard();
//    }
//
//    public function sendPasswordResetLink(Request $request)
//    {
//
//    }
}