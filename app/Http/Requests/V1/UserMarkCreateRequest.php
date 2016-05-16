<?php

namespace App\Http\Requests\V1;

use Dingo\Api\Http\FormRequest;

class UserMarkCreateRequest extends FormRequest
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
            'mark' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'mark' => '标签'
        ];
    }

}
