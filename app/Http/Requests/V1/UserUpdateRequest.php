<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sex' => 'in:1,2',
            'bornDate' => 'date_format:Y-m-d|before:now',
            'height' => 'numeric|between:1,300',
            'weight' => 'numeric|between:1,300',
        ];
    }

    public function attributes()
    {
        return [
            'sex' => '性别',
            'bornDate' => '生日',
            'height' => '身高',
            'weight' => '体重',
        ];
    }

    public function messages()
    {
        return [
            'sex.in' => '请选择正确的:attribute',
            'bornDate.before' => ':attribute必须在今天之前'
        ];
    }
}
