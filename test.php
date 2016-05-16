<?php
/**
 * Created by PhpStorm.
 * User: zq014
 * Date: 16-4-13
 * Time: 下午4:23
 */
//echo md5('467913');

//return preg_match("/^1[34578]{1}\d{9}$/",'');
function myfunction(&$value,$key)
{
    $value="yellow";
}
$a=array(
	"a"=>"red",
	"b"=>"green",
	"c"=>"blue"
);
array_walk($a,"myfunction");
print_r($a);