<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UserStoreRequest;
use App\Notifications\MailResetPasswordNotification;
use App\Services\UserService;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Notifications\Notifiable;

class AuthController extends Controller
{
    use Notifiable;

    use SendsPasswordResetEmails, ResetsPasswords {
        SendsPasswordResetEmails::broker insteadof ResetsPasswords;
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
    }

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

    public function customResetPassword(ResetPasswordRequest $request)
    {
//        if (is_null(User::find(auth()->user()->id))) {
//            throw new ServiceException('Вы не авторизованы для данной операции', 500);
//        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => bcrypt($request->password_confirmation)
        ]);

        $root = User::where(['email' => 'kaluga_edu@admin.ru'])->first();

        $root->notify(new MailResetPasswordNotification($user));

        return response()->json([
            'status' => 'success',
            'msg' => "Пароль для пользователя " . $user['email'] . ' успешно изменён'
        ]);
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
            'status' => 'success',
            'msg' => 'Email-сообщение о сбросе пароля было успешно отправлено на почту'
//            'message' => 'Password reset email sent.',
//            'data' => $response
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
        return response()->json([
            'status' => 'error',
            'msg' => 'Email не может быть отправлен по данному адресу'
//            'message' => 'Email could not be sent to this email address.'
        ]);
    }

    public function callResetPassword(Request $request)
    {
        return $this->reset($request);
    }

    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();

        event(new PasswordReset($user));
    }

    protected function sendResetResponse(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'msg' => 'Пароль успешно сброшен'
//            'message' => 'Password reset successfully'
        ]);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json([
            'status' => 'error',
            'msg' => 'Невалидный токен'
//            'message' => 'Failed Invalid Token'
        ]);
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