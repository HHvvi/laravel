<?php

namespace App\Http\Requests\V1;

use Dingo\Api\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'account' => 'required|account|unique:ac_user,mobile|unique:ac_user,email',
            'password' => 'required',
            'defaultLogo' => 'required|url',
            'name' => 'required|alpha_dash|between:2,10',
            'verification' => 'required|digits:6|integer|exists:ac_verification_code,verification_code,to,'.$this->container['request']['account']
        ];
    }

    public function attributes()
    {
        return [
            'account' => '帐号',
            'logo' => '头像',
            'name' => '昵称',
            'verification' => '验证码'
        ];
    }

    public function messages()
    {
        return [
            'verification.required' => '请输入:attribute',
            'verification.exists' => '请输入正确的:attribute',
            'account.unique' => ':attribute已注册，请登录'
        ];
    }
}
