<?php

/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-5-4
 * Time: 上午11:57
 */

namespace  App\Listeners;

use App\Events\SendSmsEvent;
use Cloud;

class SendSmsListener
{
    public function __construct()
    {

    }


    public function handle(SendSmsEvent$event)
    {
        $data = $event->data;
        $rep = Cloud::sendTemplateSMS($data['account'], [$data['verificationCode'], config('cloud.valid_time')], config('cloud.temp_id'));
        if (!$rep['resultStatus']) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(500, '发送失败，请稍后重试');
        }
    }
}