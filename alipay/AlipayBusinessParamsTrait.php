<?php
/**
 * @link http://www.youfangfa.me/
 * @copyright Copyright (c) 2016 YouFang Inc.
 * @license http://www.youfangfa.me/license/
 */

namespace ericeyang\payment\alipay;

/**
 * Trait AlipayBusinessParamsTrait
 * 定义 Alipay App支付业务参数
 * @see https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.97AEg9&treeId=193&articleId=105465&docType=1
 *
 * @author ericeyang <ericeyany@gmail.com>
 * @since 1.0.0
 */
trait AlipayBusinessParamsTrait
{
    // 对一笔交易的具体描述信息。如果是多种商品，请将商品描述字符串累加传给body。示例：Iphone6 16G。
    private $body;
    // 商品的标题/交易标题/订单标题/订单关键字等。示例：大乐透
    private $subject;
    // 商户网站唯一订单号，70501111111S001111119
    private $outTradeNo;
    // 该笔订单允许的最晚付款时间，逾期将关闭交易。
    // 取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。
    // 该参数数值不接受小数点， 如 1.5h，可转换为 90m。
    private $timeoutExpress;
    // 订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]
    private $totalAmount;
    // 收款支付宝用户ID。 如果该值为空，则默认为商户签约账号对应的支付宝用户ID，示例：2088102147948060
    private $sellerId;
    // 销售产品码，商家和支付宝签约的产品码，示例：QUICK_MSECURITY_PAY
    private $productCode;

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setOutTradeNo($outTradeNo)
    {
        $this->outTradeNo = $outTradeNo;
    }

    public function getOutTradeNo()
    {
        return $this->outTradeNo;
    }

    public function setTimeoutExpress($timeoutExpress)
    {
        $this->timeoutExpress = $timeoutExpress;
    }

    public function getTimeoutExpress()
    {
        return $this->timeoutExpress;
    }

    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    public function setSellerId($sellerId)
    {
        $this->sellerId = $sellerId;
    }

    public function getSellerId()
    {
        return $this->sellerId;
    }

    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;
    }

    public function getProductCode()
    {
        return $this->productCode;
    }
}