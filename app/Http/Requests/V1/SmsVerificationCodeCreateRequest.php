<?php

namespace App\Http\Requests\V1;

class SmsVerificationCodeCreateRequest extends BaseRequest
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
            'account' => 'required|account|unique:ac_user,mobile'
        ];
    }

    public function messages()
    {
        return [
            'account.unique' => '手机号码已注册，请登录'
        ];
    }
}
