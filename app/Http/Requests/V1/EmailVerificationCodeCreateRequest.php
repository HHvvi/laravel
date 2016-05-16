<?php

namespace App\Http\Requests\V1;

use Dingo\Api\Http\FormRequest;

class EmailVerificationCodeCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|unique:ac_user,email'
        ];
    }

    public function attributes()
    {
        return [
            'email' => '邮箱'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => ':attribute已注册，请登录'
        ];
    }
}
