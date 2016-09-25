<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace ericeyang\payment\alipay;
use ericeyang\payment\helpers\PaymentException;

/**
 * AlipayException represents an exception caused by Alipay.
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
class AlipayException extends PaymentException
{
    public static $AlipayStatuses = [
        9000 => '订单支付成功',
        8000 => '正在处理中，支付结果未知（有可能已经支付成功），请查询商户订单列表中订单的支付状态',
        4000 => '订单支付失败',
        5000 => '重复请求',
        6001 => '用户中途取消',
        6002 => '网络连接出错',
        6004 => '支付结果未知（有可能已经支付成功），请查询商户订单列表中订单的支付状态',
    ];

    /**
     * @var integer Alipay status code, such as 8000, 4000, etc.
     */
    public $statusCode;


    /**
     * Constructor.
     * @param integer $status Alipay status code, such as 8000, 4000, etc.
     * @param string $message error message
     * @param integer $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($status, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $status;
        if (!isset($message)) {
            $message = $this->getMsg();
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string the user-friendly message of this exception
     */
    protected function getMsg()
    {
        if (isset(self::$AlipayStatuses[$this->statusCode])) {
            return self::$AlipayStatuses[$this->statusCode];
        } else {
            return '其它支付错误';
        }
    }
}