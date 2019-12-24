<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => 'required|min:5|max:255|regex:/([\w][\w+\d+])/i',
            'email' => 'required|min:10|max:255|email'
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException(__('form_request_auth_error'), 403);
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, response()->json([
            'error' => $validator->errors(),
            'msg' => __('form_request_invalid_data_msg'),
            'status' => 'error'
        ])));
    }
}
