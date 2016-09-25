<?php
/**
 * @link http://www.youfangfa.me/
 * @copyright Copyright (c) 2016 YouFang Inc.
 * @license http://www.youfangfa.me/license/
 */

namespace ericeyang\payment\alipay;

/**
 *  Interface AlipayNotifyInterface
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
interface AlipayNotifyInterface
{
    /**
     * 接收商户客户端支付结果通知
     * @param $data
     * @param $sign
     * @param $rsaPublicKeyFilePath
     * @param $signType
     * @return
     */
    public function verifyClientNotify($data, $sign, $signType);

    /**
     * 接收支付宝服务器支付通知
     */
    public function verifyServerNotify($params);

    /**
     * 验证是否是支付宝发来的通知
     * @param $notifyId
     * @return
     */
    public function verifyFromAliPayServer($notifyId);
}