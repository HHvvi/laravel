<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-5-10
 * Time: 下午3:10
 */

namespace App\Http\Requests\V1;

use Dingo\Api\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;

class BaseRequest extends IlluminateFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        if ($this->container['request'] instanceof Request) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException(array_first($validator->errors()->toArray())[0], $validator->errors());
        }

        parent::failedValidation($validator);
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return mixed
     */
    protected function failedAuthorization()
    {
        if ($this->container['request'] instanceof Request) {
            throw new HttpException(403);
        }

        parent::failedAuthorization();
    }

}