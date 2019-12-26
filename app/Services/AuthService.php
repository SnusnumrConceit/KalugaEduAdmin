<?php
/**
 * Created by PhpStorm.
 * User: snusnumr1996
 * Date: 26.12.19
 * Time: 17:49
 */

namespace App\Services;


use App\Http\Requests\Auth\RegisterRequest;

class AuthService
{
    public function register(RegisterRequest $request)
    {
        $request->validated();


    }
}