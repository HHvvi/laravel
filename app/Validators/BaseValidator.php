<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-15
 * Time: 上午11:35
 */

namespace App\Validators;


use Prettus\Validator\LaravelValidator;

class BaseValidator extends LaravelValidator
{

    protected $messages = array();
    protected $attributes = array();


    public function getMessages(){
        return $this->messages;
    }
    public function setMessages(array $messages)
    {
        $this->messages = $messages;
        return $this;
    }
    public function getAttributes(){
        return $this->attributes;
    }
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }


    public function passes($action = null)
    {
        $rules      = $this->getRules($action);
        $messages   = $this->getMessages();
        $attributes = $this->getAttributes();
        $validator  = $this->validator->make($this->data, $rules, $messages, $attributes);

        if( $validator->fails() )
        {
            $this->errors = $validator->messages();
            return false;
        }
        return true;
    }
}