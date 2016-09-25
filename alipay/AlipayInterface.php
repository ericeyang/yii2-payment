<?php
/**
 * @link http://www.youfangfa.me/
 * @copyright Copyright (c) 2016 YouFang Inc.
 * @license http://www.youfangfa.me/license/
 */

namespace ericeyang\payment\alipay;

/**
 *  Interface AlipayInterface
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
interface AlipayInterface
{
    /**
     * 加签
     * @param $data
     * @param $signType
     * @return
     */
    public function sign($data, $signType);

    /**
     * 验签
     * @param $data
     * @param $sign
     * @param $signType
     * @return
     */
    public function verify($data, $sign, $signType);
}