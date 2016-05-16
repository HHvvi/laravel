<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;

class VerificationCodeValidator extends BaseValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
//            'account' => 'required|unique:ac_user,mobile|mobile'
        ],
        ValidatorInterface::RULE_UPDATE => [

        ]
   ];

//    protected $attributes = [
//        'account' => '手机号码',
//    ];
//
//    protected $messages = [
//        'account.unique' => '号码已注册，请登录',
//    ];

}