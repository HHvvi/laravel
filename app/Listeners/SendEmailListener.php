<?php

/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-5-4
 * Time: 上午11:57
 */

namespace  App\Listeners;


use App\Events\SendEmailEvent;
use Mail;

class SendEmailListener
{
    public function __construct()
    {

    }


    public function handle(SendEmailEvent $event)
    {
        $data = $event->data;
        Mail::send('emails.activemail',$data, function ($message) use ($data) {
            $message->to($data['email'], '测试')->subject('欢迎注册我们的APP！');
        });
    }
}