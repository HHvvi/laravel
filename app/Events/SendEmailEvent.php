<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-5-4
 * Time: 上午11:56
 */

namespace App\Events;


class SendEmailEvent extends Event
{
    public $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }
}