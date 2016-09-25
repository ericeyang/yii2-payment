<?php
/**
 * @link http://www.youfangfa.me/
 * @copyright Copyright (c) 2016 YouFang Inc.
 * @license http://www.youfangfa.me/license/
 */

namespace ericeyang\payment\alipay;

/**
 * Trait AlipayTrait
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
trait AlipayTrait
{
    // 支付宝配置
    private $config;
    // 商户私钥路径
    private $rsaPrivateKeyFilePath;
    // 支付宝公钥路径
    private $rsaAlipayPublicKeyFilePath;

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setRsaPrivateKeyFilePath($rsaPrivateKeyFilePath)
    {
        $this->rsaPrivateKeyFilePath = $rsaPrivateKeyFilePath;
    }

    public function getRsaPrivateKeyFilePath()
    {
        return $this->rsaPrivateKeyFilePath;
    }

    public function setRsaAliPublicKeyFilePath($rsaAlipayPublicKeyFilePath)
    {
        $this->rsaAlipayPublicKeyFilePath = $rsaAlipayPublicKeyFilePath;
    }

    public function getRsaAlipayPublicKeyFilePath()
    {
        return $this->rsaAlipayPublicKeyFilePath;
    }
}