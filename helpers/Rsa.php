<?php
/**
 * @link http://www.youfangfa.me/
 * @copyright Copyright (c) 2016 YouFang Inc.
 * @license http://www.youfangfa.me/license/
 */

namespace ericeyang\payment\helpers;

/**
 * Class Rsa
 * 支付宝接口RSA函数
 * 详细：RSA签名、验签、解密
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
class Rsa
{
    /**
     * RSA签名
     * @param object $data 待签名数据
     * @param string $private_key_path 商户私钥文件路径
     * @return string 签名结果
     */
    public static function rsaSign($data, $private_key_path) {
        $priKey = file_get_contents($private_key_path);
        $res = openssl_get_privatekey($priKey);
        openssl_sign($data, $sign, $res);
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }
    /**
     * RSA验签
     * @param object $data 待签名数据
     * @param string $ali_public_key_path 支付宝的公钥文件路径
     * @param string $sign 要校对的的签名结果
     * @return string 验证结果
     */
    public static function rsaVerify($data, $ali_public_key_path, $sign)  {
        $pubKey = file_get_contents($ali_public_key_path);
        $res = openssl_get_publickey($pubKey);
        $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        openssl_free_key($res);
        return $result;
    }
    /**
     * RSA解密
     * @param string $content 需要解密的内容，密文
     * @param string $private_key_path 商户私钥文件路径
     * @return string 解密后内容，明文
     */
    public static function rsaDecrypt($content, $private_key_path) {
        $priKey = file_get_contents($private_key_path);
        $res = openssl_get_privatekey($priKey);
        //用base64将内容还原成二进制
        $content = base64_decode($content);
        //把需要解密的内容，按128位拆开解密
        $result  = '';
        for($i = 0; $i < strlen($content)/128; $i++  ) {
            $data = substr($content, $i * 128, 128);
            openssl_private_decrypt($data, $decrypt, $res);
            $result .= $decrypt;
        }
        openssl_free_key($res);
        return $result;
    }
}