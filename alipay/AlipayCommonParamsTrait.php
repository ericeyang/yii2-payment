<?php
/**
 * @link http://www.youfangfa.me/
 * @copyright Copyright (c) 2016 YouFang Inc.
 * @license http://www.youfangfa.me/license/
 */

namespace ericeyang\payment\alipay;

/**
 * Trait AlipayCommonParamsTrait
 * 定义 Alipay App支付公共参数
 * @see https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.97AEg9&treeId=193&articleId=105465&docType=1
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
trait AlipayCommonParamsTrait
{
    // 支付宝分配给开发者的应用ID，示例：2014072300007148
    private $appId;
    // 接口名称，示例：alipay.trade.app.pay
    private $method;
    // 仅支持JSON
    private $format;
    // 请求使用的编码格式，如utf-8,gbk,gb2312等，示例：utf-8
    private $charset;
    // 商户生成签名字符串所使用的签名算法类型，目前支持RSA
    private $signType;
    // 商户请求参数的签名串
    private $sign;
    // 发送请求的时间，格式"yyyy-MM-dd HH:mm:ss"，示例：2014-07-24 03:07:50
    private $timestamp;
    // 调用的接口版本，固定为：1.0
    private $version;
    // 支付宝服务器主动通知商户服务器里指定的页面http/https路径。建议商户使用https，示例：https://api.xx.com/receive_notify.htm
    private $notifyUrl;
    // 业务请求参数的集合，最大长度不限，除公共参数外所有请求参数都必须放在这个参数中传递，具体参照各产品快速接入文档
    private $bizContent;

    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    public function getCharset()
    {
        return $this->charset;
    }

    public function setSignType($signType)
    {
        $this->signType = $signType;
    }

    public function getSignType()
    {
        return $this->signType;
    }

    public function setSign($sign)
    {
        $this->sign = $sign;
    }

    public function getSign()
    {
        return $this->sign;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
    }

    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    public function setBizContent($bizContent)
    {
        $this->bizContent = $bizContent;
    }

    public function getBizContent()
    {
        return $this->bizContent;
    }
}