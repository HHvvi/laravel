<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;

class ActivityValidator extends BaseValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'logo' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
            'logo' => 'required'
        ],
   ];
    
    protected $attributes = [
        'name' => '赛事名称',
        'logo' => '赛事宣传图',
    ];
}