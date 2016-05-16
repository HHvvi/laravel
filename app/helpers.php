<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-3-31
 * Time: 下午3:36
 */
if (!function_exists('encrypt_pwd')) {
    function encrypt_pwd($pwd,$salt)
    {
        return md5($pwd.md5($salt));
    }
}

if (!function_exists('create_guid')){
    function create_guid() {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.

            $charid = md5(uniqid(rand(), true));
            $uuid = ''
                . substr($charid, 0, 8)
                . substr($charid, 8, 4)
                . substr($charid, 12, 4)
                . substr($charid, 16, 4)
                . substr($charid, 20, 12);
            return $uuid;
        }
    }
}
if (!function_exists('add_thumbnail')){
    function add_thumbnail() {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.

            $charid = md5(uniqid(rand(), true));
            $uuid = ''
                . substr($charid, 0, 8)
                . substr($charid, 8, 4)
                . substr($charid, 12, 4)
                . substr($charid, 16, 4)
                . substr($charid, 20, 12);
            return $uuid;
        }
    }
}
if (!function_exists('field_map')){
    function field_map($map,$data) {
        // 检查字段映射
        if(!empty($map)) {
            foreach ($map as $key=>$val){
                if(isset($data[$val])) {
                    $data[$key] = $data[$val];
                    unset($data[$val]);
                }
            }
        }
        return $data;
    }
}

