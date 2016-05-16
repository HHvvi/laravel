<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-27
 * Time: 下午2:49
 */
return [

    'qiniu' => [
        'open_bucket' => env('QINIU_OPEN_BUCKET', 'img-open-dev'),
        'temporary_bucket' => env('QINIU_TEMPORARY_BUCKET', 'temporary-storage'),
        'access_key' => 'e1z-qHQxApgVMJb2ihBYOGLF2xwLVzcv2my9A1WB',
        'secret_key' => 'a0CXKwFlOie84lH2NFoECOl7EwwdEjqfeen06Qew',
    ],

    'url' =>[
        'open_img'  => env('URL_OPEN_IMG', 'http://img.dev.tykapp.com/'),
    ],

    'img_reduce' => [
        'user_logo' => 'userLogoThumbnail',
        'img_separator' => "_"
    ],
    'expiration' => [
        'time' => 1800
    ],

];
