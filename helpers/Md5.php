<?php
/**
 * @link http://www.youfangfa.me/
 * @copyright Copyright (c) 2016 YouFang Inc.
 * @license http://www.youfangfa.me/license/
 */

namespace ericeyang\payment\helpers;

/**
 * Class Md5
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
class Md5
{
    /**
     * 签名字符串
     * @param string $prestr 需要签名的字符串
     * @param string $key 私钥
     * @return string 签名结果
     */
    public static function md5Sign($prestr, $key) {
        $prestr = $prestr . $key;
        return md5($prestr);
    }
    /**
     * 验证签名
     * @param string $prestr 需要签名的字符串
     * @param string $sign 签名结果
     * @param string $key 私钥
     * @return boolean 签名结果
     */
    public static function md5Verify($prestr, $sign, $key) {
        $prestr = $prestr . $key;
        $mysgin = md5($prestr);
        if($mysgin == $sign) {
            return true;
        }
        else {
            return false;
        }
    }
}