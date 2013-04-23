<?php
/**
 * PHP SDK for QQ登录 OpenAPI
 *
 * @version 1.5
 * @author connect@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */


require_once("../comm/utils.php");

/*
 * @brief 获取登录用户的QQ空间相册列表.请求需经过URL编码，编码时请遵循 RFC 1738
 *
 * @param $appid
 * @param $appkey
 * @param $access_token
 * @param $access_token_secret
 * @param $openid
 *
 */
function list_album($appid, $appkey, $access_token, $access_token_secret, $openid)
{
    //获取相册列表的接口地址, 不要更改!!
    $url    = "http://openapi.qzone.qq.com/photo/list_album";
    echo do_get($url, $appid, $appkey, $access_token, $access_token_secret, $openid);
}

//接口调用示例：
list_album($_SESSION["appid"], $_SESSION["appkey"], $_SESSION["token"], $_SESSION["secret"], $_SESSION["openid"]);
?>
