<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class DocumentStoreRequest extends FormRequest
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
            'name' => 'required|min:3|max:255|string',
            'url' => 'required|min:10|max:255|string',
            'category_id' => 'nullable|exists:categories,id'
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException(__('form_request_auth_error'), 403);
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, response()->json([
            'status' => 'error',
            'msg'    => __('form_request_invalid_data_msg'),
            'error'  => $validator->errors()
        ])));
    }
}
