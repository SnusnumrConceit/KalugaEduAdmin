<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UserStoreRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required|min:5|max:255|regex:/([\w][\w+\d+])/i',
            'email' => 'required|min:10|max:255|email',
            'password' => 'required|min:6|max:60|confirmed|regex:/([\w][\w+\d+])/i',
            'role.id' => 'required|exists:roles,id'
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
