<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;

class AdValidator extends BaseValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
        ],
    ];

    protected $attributes = [
        'name' => '广告名称',
        'logo' => '广告宣传图',
    ];
}