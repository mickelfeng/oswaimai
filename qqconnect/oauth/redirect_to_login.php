<?php
/**
 * PHP SDK for QQ登录 OpenAPI
 *
 * @version 1.5
 * @author connect@qq.com
 * @copyright © 2011, Tencent Corporation. All rights reserved.
 */

require_once("get_request_token.php");

/**
 * @brief 跳转到QQ登录页面.请求需经过URL编码，编码时请遵循 RFC 1738
 *
 * @param $appid
 * @param $appkey
 * @param $callback
 *
 * @return 返回字符串格式为：oauth_token=xxx&openid=xxx&oauth_signature=xxx&timestamp=xxx&oauth_vericode=xxx
 */
function redirect_to_login($appid, $appkey, $callback)
{
    global $global_arg;
    //跳转到QQ登录页的接口地址, 不要更改!!
    $redirect = "http://openapi.qzone.qq.com/oauth/qzoneoauth_authorize?oauth_consumer_key=$appid&";

    //调用get_request_token接口获取未授权的临时token
    $request_token = get_request_token($appid, $appkey);

    //由于编码,appid,secret都可能导致获取request token失败
    if (strpos($request_token, "error_code") !== false)
    {
        echo '<html lang="zh-cn">';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        echo '</head>';
        echo '<body>';
        echo "<h3>请求url:</h3>$global_arg</br>";
        echo "<h3>返回值:</h3>$request_token</br>";
        echo '<h3>请参考</h3><a href="http://wiki.opensns.qq.com/wiki/%E3%80%90QQ%E7%99%BB%E5%BD%95%E3%80%91%E5%85%AC%E5%85%B1%E8%BF%94%E5%9B%9E%E7%A0%81%E8%AF%B4%E6%98%8E" target="_blank">错误码说明</a>与<a href="http://open.qzone.qq.com/oauth_tool/oauth_url_check.htm">调试工具</a>';
        echo '</body>';
        echo '</html>';
        exit;
    }

    //解析返回值
    $result = array();
    parse_str($request_token, $result);

    //request token, request token secret 需要保存起来
    //在demo演示中，直接保存在全局变量中.
    //为避免网站存在多个子域名或同一个主域名不同服务器造成的session无法共享问题
    //请开发者按照本SDK中comm/session.php中的注释对session.php进行必要的修改，以解决上述2个问题，
    $_SESSION["token"]        = $result["oauth_token"];
    $_SESSION["secret"]       = $result["oauth_token_secret"];

    ////构造请求URL
    $redirect .= "oauth_token=".$result["oauth_token"]."&oauth_callback=".QQConnect_urlencode($callback);
    header("Location:$redirect");
}

//redirect_to_login接口调用示例(当用户点击QQ登录按钮时，应该调用该接口以引导用户到QQ登录页面)
redirect_to_login($_SESSION["appid"], $_SESSION["appkey"], $_SESSION["callback"]);
?>
