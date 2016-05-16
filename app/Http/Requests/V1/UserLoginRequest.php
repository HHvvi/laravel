<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-5-10
 * Time: 下午3:36
 */

namespace App\Http\Requests\V1;


class UserLoginRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'account' => 'required|account',
            'password' => 'required'
        ];
    }
    public function attributes()
    {
        return [
            'account' => '帐号',
            'password' => '密码'
        ];
    }
    public function messages()
    {
        return [
        ];
    }
}