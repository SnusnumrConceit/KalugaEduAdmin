<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class DocumentUploadRequest extends FormRequest
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
            'file.*' => 'file|mimes:docx,doc'
        ];
    }

    public function failedAuthorization()
    {
        return (new AuthorizationException(__('form_request_auth_error'), 403));
    }

    public function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator, response()->json(
            [
                'status' => 'error',
                'msg' => __('form_request_invalid_data_msg'),
                'error' => $validator->errors()
            ]
        )));
    }
}
